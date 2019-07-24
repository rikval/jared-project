<?php


namespace Tests\Factory;

use App\Entity\Contact;
use App\Factory\ContactFactory;
use PHPUnit\Framework\TestCase;

class ContactFactoryTest extends TestCase
{
    /*
     * @var ContactFactory
     */
    private $factory;

    /**
     * PHPUnit magic.If you have a method that's exactly called setUp ,
     * PHPUnit will automatically call it before each test.
     * That's really important: each test should be completely independent of each other.
     * You never want one test to rely on something a different test set up first.
     */
    public function setUp() : void
    {
        $this->factory = new ContactFactory();
    }

    /**
     * Real simple test. Create a contact with the factory and check
     * it return an instance of Contact.
     */
    public function testCreateContact()
    {
        $contact = $this->factory->createContact();
        $this->assertInstanceOf(Contact::class, $contact);
    }

    /**
     * Method to implement later. The markTestIncomplete allow to write this test as a reminder
     * but will not fail when we launch other tests.
     */
    public function testPressContact()
    {
        $this->markTestIncomplete('Waiting for to implements ContactGenus');
    }
}