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
        $userMail = 'mail' . rand(1, 100000) . '@mail.com';
        $form['user[email]'] = $userMail ;
        $form['user[plainPassword][first]'] = 'lazerty12';
        $form['user[plainPassword][second]'] = 'lazerty12';
        $client->submit($form);
        //retrieve the updated crawler
        $crawler = $client->followRedirect();
        // Check if there a success alert after registration
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());

        // Click on sign in link and check if the status code is correct
        $link = $crawler->selectLink('Sign in')->link();
        $crawler = $client->click($link);
        $crawler = $client->request('GET', '/login');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        //fill the sign in form with the same datas we use for registration
        $form = $crawler->selectButton('Sign in')->form();
        $form['_username'] = $userMail ;
        $form['_password'] = 'lazerty12';
        $client->submit($form);

        // follow the redirection and check if user is log
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('.user-is-log')->count());
    }
}