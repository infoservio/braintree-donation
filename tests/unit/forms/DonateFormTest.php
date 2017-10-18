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

use endurant\donationsfree\models\forms\DonateForm;


class DonateFormTest extends TestCase
{
    var $donateForm = null;

    public function setUp()
    {
        $this->donateForm = new DonateForm();
        $this->donateForm->amount = 10;
        $this->donateForm->projectId = 1;
        $this->donateForm->projectName = 'Teerr';
    }

    /**
     * @group donateForm
     */
    public function testSuccessDonateForm()
    {
        $this->assertTrue($this->donateForm->validate());
    }

    /**
     * @group donateForm
     */
    public function testAmountIsNull()
    {
        $donateForm = $this->donateForm;
        $donateForm->amount = null;

        $this->assertFalse($donateForm->validate());
    }

    /**
     * @group donateForm
     */
    public function testAmountIsZero()
    {
        $donateForm = $this->donateForm;
        $donateForm->amount = 0;

        $this->assertFalse($donateForm->validate());
    }

    /**
     * @group donateForm
     */
    public function testProjectIdIsNull()
    {
        $donateForm = $this->donateForm;
        $donateForm->projectId = null;

        $this->assertTrue($donateForm->validate());
    }

    /**
     * @group donateForm
     */
    public function testProjectIdIsZero()
    {
        $donateForm = $this->donateForm;
        $donateForm->projectId = 0;

        $this->assertTrue($donateForm->validate());
    }

    /**
     * @group donateForm
     */
    public function testProjectNameIsNull()
    {
        $donateForm = $this->donateForm;
        $donateForm->projectName = null;

        $this->assertTrue($donateForm->validate());
    }

    /**
     * @group donateForm
     */
    public function testProjectNameIsMoreThen50Characters()
    {
        $donateForm = $this->donateForm;
        $donateForm->projectName = '12345678901234578901234567890123456789012345678901';

        $this->assertFalse($donateForm->validate());
    }

    /**
     * @group donateForm
     */
    public function testProjectNameIs49Characters()
    {
        $donateForm = $this->donateForm;
        $donateForm->projectName = '123456789012345789012345678901234567890123456789';

        $this->assertTrue($donateForm->validate());
    }

    /**
     * @group donateForm
     */
    public function testProjectNameIs50Characters()
    {
        $donateForm = $this->donateForm;
        $donateForm->projectName = '1234567890123457890123456789012345678901234567890';

        $this->assertTrue($donateForm->validate());
    }

    /**
     * @group donateForm
     */
    public function testProjectNameIsEmptyString()
    {
        $donateForm = $this->donateForm;
        $donateForm->projectName = '';

        $this->assertTrue($donateForm->validate());
    }

    /**
     * @group donateForm
     */
    public function testProjectNameIsNullAndAmountIsZero()
    {
        $donateForm = $this->donateForm;
        $donateForm->projectName = null;
        $donateForm->amount = 0;

        $this->assertFalse($donateForm->validate());
    }
}