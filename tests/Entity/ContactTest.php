<?php

namespace Tests\Entity;

use App\Entity\Contact;
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase
{
    public function testContact()
    {
        $this->assertClassHasAttribute('name', Contact::class);
    }
}