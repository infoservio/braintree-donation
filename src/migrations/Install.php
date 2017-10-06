<?php
namespace endurant\donationsfree\migrations;

use Yii;
use craft\db\Migration;

class Install extends Migration
{
    public $driver;

    private $countryCsvPath = '../assets/countries.csv';
    private $usaStatesCsvPath = '../assets/usa-states.csv';

    // Public Methods
    // =========================================================================

    /**
     * This method contains the logic to be executed when applying this migration.
     * This method differs from [[up()]] in that the DB logic implemented here will
     * be enclosed within a DB transaction.
     * Child classes may implement this method instead of [[up()]] if the DB logic
     * needs to be within a transaction.
     *
     * @return boolean return a false value to indicate the migration fails
     * and should not proceed further. All other return values mean the migration succeeds.
     */
    public function safeUp()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        if ($this->createTables()) {
            // $this->createIndexes();
            $this->addForeignKeys();
            // Refresh the db schema caches
            Craft::$app->db->schema->refresh();
            $this->insertDefaultData();
        }

        return true;
    }

    /**
     * This method contains the logic to be executed when removing this migration.
     * This method differs from [[down()]] in that the DB logic implemented here will
     * be enclosed within a DB transaction.
     * Child classes may implement this method instead of [[down()]] if the DB logic
     * needs to be within a transaction.
     *
     * @return boolean return a false value to indicate the migration fails
     * and should not proceed further. All other return values mean the migration succeeds.
     */
    public function safeDown()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        $this->removeForeignKeys();
        $this->removeTables();

        return true;
    }

    // Private Methods
    // =========================================================================

    private function createTables() 
    {
        if (!$this->tableExists('donations_transaction')) {
            $this->createTable('donations_transaction', [
                'id' => $this->primaryKey(),
                'transactionId' => $this->text(),
                'type' => $this->text()->null(),
                'cardId' => $this->integer(),
                'amount' => $this->integer(),
                'status' => $this->integer(),
                'projectId' => $this->integer()->null(),
                'projectName' => $this->integer()->null(),
                'success' => $this->boolean(),
                'transactionDetails' => $this->text()->null(),
                'transactionErrors' => $this->text()->null(),
                'transactionErrorMessage' => $this->text()->null(),
                'createdAt' => $this->date(),
                'updatedAt' => $this->date()
            ]);
        }

        if (!$this->tableExists('donations_card')) {
            $this->createTable('donations_card', [
                'id' => $this->primaryKey(),
                'tokenId' => $this->string(36),
                'customerId' => $this->integer(),
                'bin' => $this->integer(),
                'last4' => $this->integer(4),
                'cardType' => $this->string(32),
                'expirationDate' => $this->string(7),
                'cardholderName' => $this->text()->null(),
                'customerLocation' => $this->string(2)->null()
            ]);
        }

        if (!$this->tableExists('donations_customer')) {
            $this->createTable('donations_customer', [
                'id' => $this->primaryKey(),
                'customerId' => $this->string(36),
                'addressId' => $this->integer(),
                'firstName' => $this->string(100),
                'lastName' => $this->string(100),
                'email' => $this->text()
            ]);
        }

        if (!$this->tableExists('donations_address')) {
            $this->createTable('donations_address', [
                'id' => $this->primaryKey(),
                'company' => $this->text(),
                'countryId' => $this->integer(),
                'region' => $this->text()->null(),
                'city' => $this->text()->null(),
                'postalCode' => $this->integer()->null(),
                'streetAddress' => $this->text(),
                'extendedAddress' => $this->text()
            ]);
        }

        if (!$this->tableExists('donations_recurring_payment')) {
            $this->createTable('donations_recurring_payment', [
                'id' => $this->primaryKey(),
                'cardId' => $this->integer(),
                'frequency' => $this->integer(),
                'amount' => $this->integer(),
                'status' => $this->integer(),
                'lastDateDonation' => $this->date(),
                'nextDateDonation' => $this->date()
            ]);
        }

        if (!$this->tableExists('donations_country')) {
            $this->createTable('donations_country', [
                'id' => $this->primaryKey(),
                'name' => $this->integer(),
                'code' => $this->integer()
            ]);
        }

        if (!$this->tableExists('donations_state')) {
            $this->createTable('donations_state', [
                'id' => $this->primaryKey(),
                'name' => $this->integer(),
                'code' => $this->integer()
            ]);
        }
    }

    private function addForeignKeys() 
    {
        $this->addForeignKey(
            'fk-dontaions-transaction-card',
            'donations_transaction',
            'cardId',
            'donations_card',
            'id',
            'SET NULL'
        );

        $this->addForeignKey(
            'fk-donations-card-customer',
            'donations_card',
            'customerId',
            'donations_customer',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-donations-recurring_payment-card',
            'donations_recurring_payment',
            'cardId',
            'donations_card',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-donations-customer-address',
            'donations_customer',
            'addressId',
            'donations_address',
            'id',
            'SET NULL'
        );

        $this->addForeignKey(
            'fk-donations-address-country',
            'donations_address',
            'countryId',
            'donations_country',
            'id',
            'SET NULL'
        );
    }

    private function removeForeignKeys()
    {
        $this->dropForeignKey(
            'fk-dontaions-transaction-card',
            'donations_transaction'
        );

        $this->dropForeignKey(
            'fk-donations-card-customer',
            'donations_card'
        );

        $this->dropForeignKey(
            'fk-donations-recurring_payment-card',
            'donations_recurring_payment'
        );

        $this->dropForeignKey(
            'fk-donations-customer-address',
            'donations_customer'
        );

        $this->dropForeignKey(
            'fk-donations-address-country',
            'donations_address'
        );
    }

    private function removeTables()
    {
        $this->dropTable('donations_recurring_payment');
        $this->dropTable('donations_transaction');
        $this->dropTable('donations_customer');
        $this->dropTable('donations_address');
        $this->dropTable('donations_card');
        $this->dropTable('donations_country');
        $this->dropTable('donations_state');
    }

    private function insertDefaultData()
    {
        if ($this->fileExists($this->countryCsvPath)) {
            $this->insertCountries();
        }

        if ($this->fileExists($this->usaStatesCsvPath)) {
            $this->insertUsaStates();
        }
    }

    private function insertCountries() 
    {
        $countries = str_getcsv($this->countryCsvPath);
        foreach($countries as &$country) {
            $this->insert('donations_country', [
                'name' => $country['name'],
                'code' => $country['alpha-2']
            ]);
        }
        unset($country);
    }

    private function insertUsaStates()
    {
        $usaStates = str_getcsv($this->usaStatesCsvPath);
        foreach($usaStates as &$state) {
            $this->insert('donations_state', [
                'name' => $country['StateName'],
                'code' => $country['StateCode']
            ]);
        }
        unset($state);
    }

    private function fileExists($path)
    {
        return file_exists($path);
    }

    private function tableExists($table)
    {
        return (Yii::$app->db->schema->getTableSchema($table) !== null);
    }
}

