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

use endurant\donationsfree\models\Card;
use endurant\donationsfree\records\Card as CardRecord;

class CardRecordTest extends TestCase
{
    var $card = null;

    public function setUp()
    {
        $this->card = new Card();
        $this->card->customerId = 1;
        $this->card->tokenId = 'dsadasd';
        $this->card->bin = 356600;
        $this->card->last4 = 0505;
        $this->card->cardType = 'JCB';
        $this->card->expirationDate = '02/2022';
        $this->card->cardholderName = '';
        $this->card->customerLocation = 'US';
    }

    /**
     * @group cardRecord
     */
    public function testSavingSuccessCard()
    {
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertTrue($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardTokenIdIsNull()
    {
        $this->card->tokenId = null;
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertFalse($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardTokenIdIsInteger()
    {
        $this->card->tokenId = 21312312;
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertFalse($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardTokenIdIsEmptyString()
    {
        $this->card->tokenId = '';
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertFalse($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardBinIsNull()
    {
        $this->card->bin = null;
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertFalse($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardBinIsInteger()
    {
        $this->card->bin = 21312312;
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertTrue($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardBinIsEmptyString()
    {
        $this->card->bin = '';
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertFalse($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardLast4IsNull()
    {
        $this->card->last4 = null;
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertFalse($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardLast4IsInteger()
    {
        $this->card->last4 = 21312312;
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $cardRecord->validate();
        print_r(json_encode($cardRecord->errors));
        $this->assertTrue($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardLast4IsEmptyString()
    {
        $this->card->last4 = '';
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertFalse($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardCardTypeIsNull()
    {
        $this->card->cardType = null;
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertFalse($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardCardTypeIsInteger()
    {
        $this->card->cardType = 21312312;
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertFalse($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardCardTypeIsEmptyString()
    {
        $this->card->cardType = '';
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertFalse($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardExpirationDateIsNull()
    {
        $this->card->expirationDate = null;
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertFalse($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardExpirationDateIsInteger()
    {
        $this->card->expirationDate = 21312312;
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertFalse($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardExpirationDateIsEmptyString()
    {
        $this->card->expirationDate = '';
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertFalse($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardCardholderNameIsNull()
    {
        $this->card->cardholderName = null;
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertTrue($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardCardholderNameIsInteger()
    {
        $this->card->cardholderName = 21312312;
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertFalse($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardCardholderNameIsEmptyString()
    {
        $this->card->cardholderName = '';
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertTrue($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardCustomerLocationIsNull()
    {
        $this->card->customerLocation = null;
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertTrue($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardCustomerLocationIsInteger()
    {
        $this->card->customerLocation = 21312312;
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertFalse($cardRecord->save());
    }

    /**
     * @group cardRecord
     */
    public function testSavingCardCustomerLocationIsEmptyString()
    {
        $this->card->customerLocation = '';
        $cardRecord = new CardRecord();
        $cardRecord->setAttributes($this->card->getAttributes(), false);
        $this->assertTrue($cardRecord->save());
    }

}