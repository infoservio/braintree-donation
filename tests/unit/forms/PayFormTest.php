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

use endurant\donationsfree\models\forms\PayForm;


class PayFormTest extends TestCase
{
    var $payForm = null;

    public function setUp()
    {
        $this->payForm = new PayForm();
        $this->payForm->firstName = 'Test';
        $this->payForm->lastName = 'Test';
        $this->payForm->email = 'test@gmail.com';
        $this->payForm->phone = '+320131234';
        $this->payForm->company = 'Test';
        $this->payForm->countryId = 22;
        $this->payForm->stateId = 'asos';
        $this->payForm->city = 'Test';
        $this->payForm->postalCode = '12345';
        $this->payForm->streetAddress = 'dsda';
        $this->payForm->extendedAddress = 'weq';
    }

    /**
     * @group payForm
     */
    public function testSuccessPayForm()
    {
        $this->assertTrue($this->payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testFirstNameIsNull()
    {
        $payForm = $this->payForm;
        $payForm->firstName = null;

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testFirstNameIsEmptyString()
    {
        $payForm = $this->payForm;
        $payForm->firstName = '';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testFirstNameMoreThen50Characters()
    {
        $payForm = $this->payForm;
        $payForm->firstName = '12345678901234578901234567890123456789012345678901';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testFirstNameIs50Characters()
    {
        $payForm = $this->payForm;
        $payForm->firstName = '1234567890123457890123456789012345678901234567890';

        $this->assertTrue($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testFirstNameIsLessThen50Characters()
    {
        $payForm = $this->payForm;
        $payForm->firstName = '12345678901234578901234567890123456789012345678';

        $this->assertTrue($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testFirstNameIsNumber()
    {
        $payForm = $this->payForm;
        $payForm->firstName = 123432;

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testLastNameIsNull()
    {
        $payForm = $this->payForm;
        $payForm->lastName = null;

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testLastNameIsEmptyString()
    {
        $payForm = $this->payForm;
        $payForm->lastName = '';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testLastNameMoreThen50Characters()
    {
        $payForm = $this->payForm;
        $payForm->lastName = '12345678901234578901234567890123456789012345678901';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testLastNameIs50Characters()
    {
        $payForm = $this->payForm;
        $payForm->lastName = '1234567890123457890123456789012345678901234567890';

        $this->assertTrue($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testLastNameIsLessThen50Characters()
    {
        $payForm = $this->payForm;
        $payForm->lastName = '12345678901234578901234567890123456789012345678';

        $this->assertTrue($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testLastNameIsNumber()
    {
        $payForm = $this->payForm;
        $payForm->lastName = 123432;

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testEmailIsNull()
    {
        $payForm = $this->payForm;
        $payForm->email = null;

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testEmailIsEmptyString()
    {
        $payForm = $this->payForm;
        $payForm->email = '';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testEmailWithoutDogSymbol()
    {
        $payForm = $this->payForm;
        $payForm->email = 'tesds.com';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testEmailWithoutDotSymbol()
    {
        $payForm = $this->payForm;
        $payForm->email = 'tesds@dsadascom';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testEmailWithoutLastPartOfEmail()
    {
        $payForm = $this->payForm;
        $payForm->email = 'tesds@dsadas.';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testEmailWithComma()
    {
        $payForm = $this->payForm;
        $payForm->email = 'tesds@dsadas,com';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testEmailIsRight()
    {
        $payForm = $this->payForm;
        $payForm->email = 'tesds@dsadas.com';

        $this->assertTrue($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testEmailMoreThen50Characters()
    {
        $payForm = $this->payForm;
        $payForm->email = '12345678901234578901234567890123456789012345678901@gmail.com';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testEmailIs50Characters()
    {
        $payForm = $this->payForm;
        $payForm->email = '123456789012345789012345678901234567890@gmail.com';

        $this->assertTrue($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testEmailIsLessThen50Characters()
    {
        $payForm = $this->payForm;
        $payForm->email = '12345678901234578901234567890123@gmail.com';

        $this->assertTrue($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testEmailIsNumber()
    {
        $payForm = $this->payForm;
        $payForm->email = 342432;

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testPhoneIsNull()
    {
        $payForm = $this->payForm;
        $payForm->phone = null;

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testPhoneIsEmptyString()
    {
        $payForm = $this->payForm;
        $payForm->phone = '';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testPhoneMoreThen50Characters()
    {
        $payForm = $this->payForm;
        $payForm->phone = '12345678901234578901234567890123456789012345678901';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testPhoneIs50Characters()
    {
        $payForm = $this->payForm;
        $payForm->phone = '1234567890123457890123456789012345678901234567890';

        $this->assertTrue($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testPhoneIsLessThen50Characters()
    {
        $payForm = $this->payForm;
        $payForm->phone = '12345678901234578901234567890123456789012345678';

        $this->assertTrue($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testPhoneIsNumber()
    {
        $payForm = $this->payForm;
        $payForm->phone = 231321312;

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testCompanyIsNull()
    {
        $payForm = $this->payForm;
        $payForm->company = null;

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testCompanyIsEmptyString()
    {
        $payForm = $this->payForm;
        $payForm->company = '';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testCompanyMoreThen50Characters()
    {
        $payForm = $this->payForm;
        $payForm->company = '12345678901234578901234567890123456789012345678901';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testCompanyIs50Characters()
    {
        $payForm = $this->payForm;
        $payForm->company = '1234567890123457890123456789012345678901234567890';

        $this->assertTrue($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testCompanyIsLessThen50Characters()
    {
        $payForm = $this->payForm;
        $payForm->company = '12345678901234578901234567890123456789012345678';

        $this->assertTrue($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testCompanyIsNumber()
    {
        $payForm = $this->payForm;
        $payForm->company = 231321312;

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testCityIsNull()
    {
        $payForm = $this->payForm;
        $payForm->city = null;

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testCityIsEmptyString()
    {
        $payForm = $this->payForm;
        $payForm->city = '';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testCityMoreThen50Characters()
    {
        $payForm = $this->payForm;
        $payForm->city = '12345678901234578901234567890123456789012345678901';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testCityIs50Characters()
    {
        $payForm = $this->payForm;
        $payForm->city = '1234567890123457890123456789012345678901234567890';

        $this->assertTrue($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testCityIsLessThen50Characters()
    {
        $payForm = $this->payForm;
        $payForm->city = '12345678901234578901234567890123456789012345678';

        $this->assertTrue($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testCityIsNumber()
    {
        $payForm = $this->payForm;
        $payForm->city = 231321312;

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testRegionIsNull()
    {
        $payForm = $this->payForm;
        $payForm->stateId = null;

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testRegionIsEmptyString()
    {
        $payForm = $this->payForm;
        $payForm->stateId = '';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testRegionMoreThen50Characters()
    {
        $payForm = $this->payForm;
        $payForm->stateId = '12345678901234578901234567890123456789012345678901';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testRegionIs50Characters()
    {
        $payForm = $this->payForm;
        $payForm->stateId = '1234567890123457890123456789012345678901234567890';

        $this->assertTrue($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testRegionIsLessThen50Characters()
    {
        $payForm = $this->payForm;
        $payForm->stateId = '12345678901234578901234567890123456789012345678';

        $this->assertTrue($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testRegionIsNumber()
    {
        $payForm = $this->payForm;
        $payForm->stateId = 231321312;

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testCountryIsNull()
    {
        $payForm = $this->payForm;
        $payForm->countryId = null;

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testCountryIsEmptyString()
    {
        $payForm = $this->payForm;
        $payForm->countryId = '';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testCountryIsString()
    {
        $payForm = $this->payForm;
        $payForm->countryId = 'sdfds';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testCountryIsNumber()
    {
        $payForm = $this->payForm;
        $payForm->countryId = 231321312;

        $this->assertTrue($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testPostalCodeIsNull()
    {
        $payForm = $this->payForm;
        $payForm->postalCode = null;

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testPostalCodeIsEmptyString()
    {
        $payForm = $this->payForm;
        $payForm->postalCode = '';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testPostalCodeIsNumberString()
    {
        $payForm = $this->payForm;
        $payForm->postalCode = '1234567';

        $this->assertTrue($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testPostalCodeIsString()
    {
        $payForm = $this->payForm;
        $payForm->postalCode = 'dsadas';

        $this->assertFalse($payForm->validate());
    }

    /**
     * @group payForm
     */
    public function testPostalCodeIsNumber()
    {
        $payForm = $this->payForm;
        $payForm->postalCode = 231321312;

        $this->assertTrue($payForm->validate());
    }
}