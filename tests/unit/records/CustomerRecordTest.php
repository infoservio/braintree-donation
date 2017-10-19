<?php
/**
 * donations-free plugin for Craft CMS 3.x
 *
 * Free Braintree Donation System
 *
 * @link      https://endurant.org
 * @copyright Copyright (c) 2017 endurant
 */

use PHPUnit\Framework\TestCase;

use endurant\donationsfree\models\Customer;
use endurant\donationsfree\records\Customer as CustomerRecord;

class CustomerRecordTest extends TestCase
{
    var $customer = null;

    public function setUp()
    {
        $json = json_decode(file_get_contents('https://randomuser.me/api/'));
        $user = $json->results[0];

        $this->customer = new Customer();
        $this->customer->customerId = 'dsadas';
        $this->customer->addressId = 1;
        $this->customer->firstName = $user->name->first;
        $this->customer->lastName = $user->name->last;
        $this->customer->email = $user->email;
        $this->customer->phone = $user->phone;
    }

    /**
     * @group customerRecord
     */
    public function testSavingCustomerSuccess()
    {
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertTrue($customerRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCustomerCustomerIdIsNull()
    {
        $this->customer->customerId = null;
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCustomerCustomerIdIsInteger()
    {
        $this->customer->customerId = 32;
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCustomerCustomerIdIsEmptyString()
    {
        $this->customer->customerId = '';
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCustomerAddressIdIsNull()
    {
        $this->customer->addressId = null;
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @expectedException yii\db\IntegrityException
     * @group cardRecord
     */
    public function testSavingCustomerAddressIdIsNotExistingIntegerInDatabase()
    {
        $this->customer->addressId = 323213343432423;
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $customerRecord->save();
    }

    /**
     * @group cardRecord
     */
    public function testSavingCustomerAddressIdIsEmptyString()
    {
        $this->customer->addressId = '';
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCustomerFirstNameIsNull()
    {
        $this->customer->firstName = null;
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCustomerFirstNameIsInteger()
    {
        $this->customer->firstName = 32;
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCustomerFirstNameIsEmptyString()
    {
        $this->customer->firstName = '';
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCustomerLastNameIsNull()
    {
        $this->customer->lastName = null;
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCustomerLastNameIsInteger()
    {
        $this->customer->lastName = 32;
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCustomerLastNameIsEmptyString()
    {
        $this->customer->lastName = '';
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCustomerPhoneIsNull()
    {
        $this->customer->phone = null;
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCustomerPhoneIsInteger()
    {
        $this->customer->phone = 32;
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCustomerPhoneIsEmptyString()
    {
        $this->customer->phone = '';
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCustomerEmailIsNull()
    {
        $this->customer->email = null;
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCustomerEmailIsInteger()
    {
        $this->customer->email = 32;
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCustomerEmailIsEmptyString()
    {
        $this->customer->email = '';
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group payForm
     */
    public function testSavingCustomerEmailWithoutDogSymbol()
    {
        $this->customer->email = 'tesds.com.ds';
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group payForm
     */
    public function testSavingCustomerEmailWithoutDotSymbol()
    {
        $this->customer->email = 'tesds@comsd';
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group payForm
     */
    public function testSavingCustomerEmailWithoutLastPartOfEmail()
    {
        $this->customer->email = 'tesds@com.';
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

    /**
     * @group payForm
     */
    public function testSavingCustomerEmailWithComma()
    {
        $this->customer->email = 'tesds@com,ds';
        $customerRecord = new CustomerRecord();
        $customerRecord->setAttributes($this->customer->getAttributes(), false);
        $this->assertFalse($customerRecord->save());
    }

}