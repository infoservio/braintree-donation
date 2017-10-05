<?php
namespace endurant\donationsfree\migrations;

use craft\db\Migration;

class Install extends Migration
{
    public function safeUp()
    {
        // if (!$this->tableExists('donations_transaction')) {
        //     $this->createTable('donations_transaction', [
        //         'id' => $this->primaryKey(),
        //         'transaction_id' => $this->text(),
        //         'type' => $this->text(),
        //         'card_id' => $this->integer(),
        //         'amount' => $this->integer(),
        //         'status' => $this->integer(),
        //         'projectid' => $this->integer()->null(),
        //         'projectname' => $this->integer()->null(),
        //         'success' => $this->boolean(),
        //         'transaction_details' => $this->text()->null(),
        //         'transaction_errors' => $this->text()->null(),
        //         'transaction_error_message' => $this->text()->null(),
        //         'created_at' => $this->date(),
        //         'updated_at' => $this->date()
        //     ]);
        // }

        // if (!$this->tableExists('donations_card')) {
        //     $this->createTable('donations_card', [
        //         'id' => $this->primaryKey(),
        //         'token_id' => $this->string(36),
        //         'bin' => $this->integer(),
        //         'last_4' => $this->integer(4),
        //         'card_type' => $this->string(32),
        //         'expiration_date' => $this->string(7),
        //         'cardholder_name' => $this->text()->null(),
        //         'customer_location' => $this->string(2)->null()
        //     ]);
        // }

        // if (!$this->tableExists('donations_customer')) {
        //     $this->createTable('donations_customer', [
        //         'id' => $this->primaryKey(),
        //         'card_id' => $this->integer(),
        //         'customer_id' => $this->string(36),
        //         'first_name' => $this->string(100),
        //         'last_name' => $this->string(100),
        //         'email' => $this->text(),
        //         'company' => $this->text(),
        //         'phone' => $this->text(),
        //         'country' => $this->text(),
        //         'country_code' => $this->string(2)->null(),
        //         'region' => $this->text()->null(),
        //         'city' => $this->text()->null(),
        //         'postal_code' => $this->integer()->null(),
        //         'street_address' => $this->text()
        //     ]);
        // }

        // if (!$this->tableExists('donations_recurring_payment')) {
        //     $this->createTable('donations_recurring_payment', [
        //         'id' => $this->primaryKey(),
        //         'card_id' => $this->integer(),
        //         'customer_id' => $this->integer(),
        //         'frequency' => $this->integer(),
        //         'amount' => $this->integer(),
        //         'status' => $this->integer(),
        //         'last_date_payment' => $this->date(),
        //         'next_date_payment' => $this->date()
        //     ]);
        // }

        // $this->addForeignKey(
        //     'fk-dontaions-transaction-card',
        //     'donations_transaction',
        //     'card_id',
        //     'donations_card',
        //     'id',
        //     'SET NULL'
        // );

        // $this->addForeignKey(
        //     'fk-donations-customer-card',
        //     'donations_customer',
        //     'card_id',
        //     'donations_card',
        //     'id',
        //     'CASCADE'
        // );

        // $this->addForeignKey(
        //     'fk-donations-recurring_payment-card',
        //     'donations_recurring_payment',
        //     'card_id',
        //     'donations_card',
        //     'id',
        //     'CASCADE'
        // );

        // $this->addForeignKey(
        //     'fk-donations-recurring_payment-customer',
        //     'donations_recurring_payment',
        //     'customer_id',
        //     'donations_customer',
        //     'id',
        //     'SET NULL'
        // );
    }

    public function safeDown()
    {
        // $this->dropForeignKey(
        //     'fk-dontaions-transaction-card',
        //     'donations_transaction'
        // );

        // $this->dropForeignKey(
        //     'fk-donations-customer-card',
        //     'donations_customer'
        // );

        // $this->dropForeignKey(
        //     'fk-donations-recurring_payment-customer',
        //     'donations_recurring_payment'
        // );

        // $this->dropForeignKey(
        //     'fk-donations-recurring_payment-card',
        //     'donations_recurring_payment'
        // );

        // $this->dropTable('donations_recurring_payment');
        // $this->dropTable('donations_transaction');
        // $this->dropTable('donations_customer');
        // $this->dropTable('donations_card');
    }

    public function tableExists($table)
    {
        return (Yii::$app->db->schema->getTableSchema($table) !== null);
    }
}