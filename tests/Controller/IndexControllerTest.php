<?php


namespace Tests\Controller;


use Faker\Factory;
use Faker\Provider\DateTime;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\Constraints\Date;


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
        $client = static::createClient(['external_base_uri' => 'https://localhost']);
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

        // Go to the user dashboard
        $link = $crawler->selectLink('Dashboard')->link();
        $crawler = $client->click($link);
        $crawler = $client->request('GET', '/dashboard/');
        $this->assertSame(200, $client->getResponse()->getStatusCode());


        //Create a new artist
        $link = $crawler->selectLink('New Artist')->link();
        $crawler = $client->click($link);
        $crawler = $client->request('GET', '/artist/new');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Add Artist')->form();
        $artist = "artist" . rand(1, 20);
        $form['artist[name]'] = $artist;
        $client->submit($form);

        //retrieve the updated crawler
        $crawler = $client->followRedirect();
        // Check if there a success alert after registration
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());

        // Go to the user dashboard
        $link = $crawler->selectLink('Dashboard')->link();
        $crawler = $client->click($link);
        $crawler = $client->request('GET', '/dashboard/');
        $this->assertSame(200, $client->getResponse()->getStatusCode());


        //Create a new tour
        $link = $crawler->selectLink('New Tour')->link();
        $crawler = $client->click($link);
        $crawler = $client->request('GET', '/tour/new');
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $startDateForm = new \DateTime('2007-07-29 22:30:48');
        $newStartDate = $startDateForm->format('Y-m-d');

        $endDateForm = new \DateTime('2007-08-29 22:30:48');
        $newEndDate = $endDateForm->format('Y-m-d');

        $form = $crawler->selectButton('Add Tour')->form();
        $form['tour[name]'] = "Tour test";
        $form['tour[artist]'] = 31;
        $form['tour[startDate]'] = $newStartDate;
        $form['tour[endDate]'] = $newEndDate;
        $client->submit($form);

        //retrieve the updated crawler
        $crawler = $client->followRedirect();
        // Check if there a success alert after registration
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }
}