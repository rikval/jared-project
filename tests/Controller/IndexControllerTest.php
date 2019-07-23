<?php


namespace Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    /** @test */
    public function homePageIsLoad ()
    {

        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertSame('200', $client->getResponse()->getStatusCode());

    }

    /**
     * @test
     */
    public function testRegisterUser()
    {
        $client = static::createClient();
        // check the register page load correctly
        $crawler = $client->request('GET', '/register');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('Register')->form();
        // fill the form
        $form['user[nickname]'] = 'Rico';
        // use random number to be sure that new mail isn't already in db
        $form['user[email]'] = 'mail' . rand(1, 100000) . '@mail.com';
        $form['user[plainPassword][first]'] = 'lazerty12';
        $form['user[plainPassword][second]'] = 'lazerty12';
        $client->submit($form);
        //retrieve the updated crawler
        $crawler = $client->followRedirect();
        // Check if there a success alert after registration
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }
}