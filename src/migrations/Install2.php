<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

namespace endurant\donationsfree\migrations;

use endurant\donationsfree\Donations;

use Craft;
use craft\config\DbConfig;
use craft\db\Migration;

/**
 * donations-free Install Migration
 *
 * If your plugin needs to create any custom database tables when it gets installed,
 * create a migrations/ folder within your plugin folder, and save an Install.php file
 * within it using the following template:
 *
 * If you need to perform any additional actions on install/uninstall, override the
 * safeUp() and safeDown() methods.
 *
 * @author    endurant
 * @package   Donations
 * @since     1.0.0
 */
class Install extends Migration
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The database driver to use
     */
    public $driver;

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
        $this->removeTables();

        return true;
    }

    // Protected Methods
    // =========================================================================

    /**
     * Creates the tables needed for the Records used by the plugin
     *
     * @return bool
     */
    protected function createTables()
    {
        $tablesCreated = false;

    // donations_customer table
        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%donations_customer}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%donations_transaction}}',
                [
                    'id' => $this->primaryKey(),
                    'transaction_id' => $this->text(),
                    'type' => $this->text(),
                    'card_id' => $this->integer(),
                    'amount' => $this->integer(),
                    'status' => $this->integer(),
                    'projectid' => $this->integer()->null(),
                    'projectname' => $this->integer()->null(),
                    'success' => $this->boolean(),
                    'transaction_details' => $this->text()->null(),
                    'transaction_errors' => $this->text()->null(),
                    'transaction_error_message' => $this->text()->null(),
                    'created_at' => $this->date(),
                    'updated_at' => $this->date()
                ]
            );
        }

    // donations_card table
        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%donations_card}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%donations_card}}',
                [
                    'id' => $this->primaryKey(),
                    'token_id' => $this->string(36),
                    'bin' => $this->integer(),
                    'last_4' => $this->integer(4),
                    'card_type' => $this->string(32),
                    'expiration_date' => $this->string(7),
                    'cardholder_name' => $this->text()->null(),
                    'customer_location' => $this->string(2)->null()
                ]
            );
        }

    // donations_transaction table
        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%donations_transaction}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%donations_customer}}',
                [
                    'id' => $this->primaryKey(),
                    'card_id' => $this->integer(),
                    'customer_id' => $this->string(36),
                    'first_name' => $this->string(100),
                    'last_name' => $this->string(100),
                    'email' => $this->text(),
                    'company' => $this->text(),
                    'phone' => $this->text(),
                    'country' => $this->text(),
                    'country_code' => $this->string(2)->null(),
                    'region' => $this->text()->null(),
                    'city' => $this->text()->null(),
                    'postal_code' => $this->integer()->null(),
                    'street_address' => $this->text()
                ]
            );
        }

        return $tablesCreated;
    }

    /**
     * Creates the foreign keys needed for the Records used by the plugin
     *
     * @return void
     */
    protected function addForeignKeys()
    {
    // donations_customer table
        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%donations_transaction}}', 'card_id'),
            '{{%donations_transaction}}',
            'card_id',
            '{{%donations_card}}',
            'id',
            'SET NULL',
            'SET NULL'
        );

    // donations_card table
        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%donations_customer}}', 'card_id'),
            '{{%donations_customer}}',
            'card_id',
            '{{%donations_card}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * Populates the DB with the default data.
     *
     * @return void
     */
    protected function insertDefaultData()
    {
    }

    /**
     * Removes the tables needed for the Records used by the plugin
     *
     * @return void
     */
    protected function removeTables()
    {
    // donations_customer table
        $this->dropTableIfExists('{{%donations_customer}}');

    // donations_card table
        $this->dropTableIfExists('{{%donations_card}}');

    // donations_transaction table
        $this->dropTableIfExists('{{%donations_transaction}}');
    }
}