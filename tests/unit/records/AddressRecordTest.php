<?php

use PHPUnit\Framework\TestCase;

use endurant\donationsfree\models\Address;
use endurant\donationsfree\records\Address as AddressRecord;

class AddressRecordTest extends TestCase
{
    var $address = null;

    public function setUp()
    {
        $json = json_decode(file_get_contents('https://randomuser.me/api/'));
        $user = $json->results[0];

        $this->address = new Address();
        $this->address->city = $user->location->city;
        $this->address->streetAddress = $user->location->street;
        $this->address->postalCode = intval($user->location->postcode);
        $this->address->stateId = $user->location->state;
        $this->address->countryId = 32;
        $this->address->company = $user->login->username;
    }

    /**
     * @group addressRecord
     */
    public function testCreateAddressSuccess()
    {
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);
        $addressRecord->validate();
        print_r(json_encode($addressRecord->errors));
        $this->assertTrue($addressRecord->save());
    }

    /**
     * @group addressRecord
     */
    public function testCreateAddressCityIsNull()
    {
        $this->address->city = null;
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);

        $this->assertFalse($addressRecord->save());
    }

    /**
     * @group addressRecord
     */
    public function testCreateAddressCityIsInteger()
    {
        $this->address->city = 213213;
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);

        $this->assertFalse($addressRecord->save());
    }

    /**
     * @group addressRecord
     */
    public function testCreateAddressCityIsEmptyString()
    {
        $this->address->city = '';
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);

        $this->assertFalse($addressRecord->save());
    }

    /**
     * @group addressRecord
     */
    public function testCreateAddressStreetAddressIsNull()
    {
        $this->address->streetAddress = null;
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);

        $this->assertFalse($addressRecord->save());
    }

    /**
     * @group addressRecord
     */
    public function testCreateAddressStreetAddressIsInteger()
    {
        $this->address->streetAddress = 213213;
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);

        $this->assertFalse($addressRecord->save());
    }

    /**
     * @group addressRecord
     */
    public function testCreateAddressStreetAddressIsEmptyString()
    {
        $this->address->streetAddress = '';
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);

        $this->assertFalse($addressRecord->save());
    }

    /**
     * @group addressRecord
     */
    public function testCreateAddressPostalCodeIsNull()
    {
        $this->address->postalCode = null;
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);

        $this->assertFalse($addressRecord->save());
    }

    /**
     * @group addressRecord
     */
    public function testCreateAddressPostalCodeIsInteger()
    {
        $this->address->postalCode = 213213;
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);

        $this->assertTrue($addressRecord->save());
    }

    /**
     * @group addressRecord
     */
    public function testCreateAddressPostalCodeIsEmptyString()
    {
        $this->address->postalCode = '';
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);

        $this->assertFalse($addressRecord->save());
    }

    /**
     * @group addressRecord
     */
    public function testCreateAddressStateIdIsNull()
    {
        $this->address->stateId = null;
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);

        $this->assertTrue($addressRecord->save());
    }

    /**
     * @group addressRecord
     */
    public function testCreateAddressStateIdIsInteger()
    {
        $this->address->stateId = 213213;
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);

        $this->assertTrue($addressRecord->save());
    }

    /**
     * @group addressRecord
     */
    public function testCreateAddressStateIdIsEmptyString()
    {
        $this->address->stateId = '';
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);

        $this->assertTrue($addressRecord->save());
    }

    /**
     * @group addressRecord
     */
    public function testCreateAddressCountryIdIsNull()
    {
        $this->address->countryId = null;
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);

        $this->assertFalse($addressRecord->save());
    }

    /**
     * @expectedException yii\db\IntegrityException
     * @group addressRecord
     */
    public function testCreateAddressCountryIdIsNotExistingInteger()
    {
        $this->address->countryId = 321123;
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);

        $addressRecord->save();
    }

    /**
     * @group addressRecord
     */
    public function testCreateAddressCountryIdIsString()
    {
        $this->address->countryId = 'dasdas';
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);

        $this->assertFalse($addressRecord->save());
    }

    /**
     * @group addressRecord
     */
    public function testCreateAddressCompanyIsNull()
    {
        $this->address->company = null;
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);

        $this->assertFalse($addressRecord->save());
    }

    /**
     * @group addressRecord
     */
    public function testCreateAddressCompanyIsInteger()
    {
        $this->address->company = 213213;
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);

        $this->assertFalse($addressRecord->save());
    }

    /**
     * @group addressRecord
     */
    public function testCreateAddressCompanyIsEmptyString()
    {
        $this->address->company = '';
        $addressRecord = new AddressRecord();
        $addressRecord->setAttributes($this->address->getAttributes(), false);

        $this->assertFalse($addressRecord->save());
    }
}