<?php


namespace App\Factory;


use App\Entity\Contact;

class ContactFactory
{
    public function createContact()
    {
        $contact = new Contact();
        return $contact;
    }
}