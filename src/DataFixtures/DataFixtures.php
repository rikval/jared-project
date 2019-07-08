<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\Contact;
use App\Entity\Event;
use App\Entity\Location;
use App\Entity\Permission;
use App\Entity\Relation;
use App\Entity\Tour;
use App\Entity\User;
use App\Entity\Venue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;


class DataFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');


        // Creating user fixtures
        $users = [];
        for($a = 1; $a <= 10; $a++){
            $users[$a] = new User();
            $randomNickname = $faker->firstName;
            $users[$a]->setNickname($randomNickname);
            $users[$a]->setEmail($randomNickname . "@mail.com");
            $users[$a]->setPassword($faker->password);

            $manager->persist($users[$a]);

            // Creating contacts fixtures
            $contacts = [];
            for($f = 1; $f <= mt_rand(20, 100); $f++){
                $contacts[$f] = new Contact();
                $contacts[$f]->setName($faker->firstName());
                $contacts[$f]->setEmail($faker->email);
                $contacts[$f]->setLanguage($faker->languageCode);
                $contacts[$f]->setPhone($faker->phoneNumber);
                $contacts[$f]->setWebsite($faker->url);
                $contacts[$f]->setUser($users[$a]);

                $manager->persist($contacts[$f]);
            }

            // Creating artists fixtures
            $artists = [];
            for($b = 1; $b <= mt_rand(1, 5); $b++){
                $artists[$b] = new Artist();
                $artists[$b]->setName($faker->domainWord);
                $artists[$b]->setUser($users[$a]);

                $manager->persist($artists[$b]);

                // Creating relation fixtures
                $affinity = ["Like", "Doesn't like"];
                $relations = [];
                for($g = 1; $g <= mt_rand(0, 20); $g++){
                    $relations[$g] = new Relation();
                    $relations[$g]->setArtist($faker->randomElement($artists));
                    $relations[$g]->setContact($faker->randomElement($contacts));
                    $relations[$g]->setAffinity($faker->randomElement($affinity));

                    $manager->persist($relations[$g]);
                }

                $artistName = $artists[$b]->getName();

                // Creating tour fixtures
                $tours = [];
                for($c = 1; $c <= mt_rand(0, 3); $c++){
                    $tours[$c] = new Tour();
                    $tours[$c]->setName($artistName . "Tour" . $c);
                    $tours[$c]->setArtist($artists[$b]);
                    $tours[$c]->setStartDate($faker->dateTimeBetween('-50 days'));

                    $days = (new \DateTime())->diff($tours[$c]->getStartDate())->days;
                    $tours[$c]->setEndDate($faker->dateTimeBetween('-' . $days . ' days'));
                    $manager->persist($tours[$c]);

                    // Creating permission fixtures
                    $permissionsList = ["Administrator", "Contributor"];
                    $permission = new Permission();
                    $permission->setUser($faker->randomElement($users));
                    $permission->setTour($faker->randomElement($tours));
                    $permission->setPermission($faker->randomElement($permissionsList));

                    $manager->persist($permission);

                    // Creating venue fixtures
                    $venues = [];
                    for($e = 1; $e <= mt_rand(4, 50); $e++) {
                        $venues[$e] = new Venue();
                        $venues[$e]->setName($faker->word);
                        $venues[$e]->setAudienceCapacity($faker->numberBetween(30, 500));

                        // Creating location fixtures
                        $location = new Location();
                        $location->setVenue($venues[$e]);
                        $location->setCity($faker->city);
                        $location->setCountry($faker->country);
                        $location->setStreetName($faker->streetName);
                        $location->setStreetNumber($faker->randomNumber());
                        $location->setZip($faker->postcode);
                        $location->setLatitude($faker->latitude);
                        $location->setLongitude($faker->longitude);

                        $venues[$e]->setLocation($location);

                        $manager->persist($venues[$e]);
                        $manager->persist($location);

                    }
                        // Creating event fixtures
                    $events = [];
                    for($d = 1; $d <= mt_rand(1, 10); $d++){
                        $events[$d] = new Event();
                        $events[$d]->setDateEvent($faker->dateTimeBetween('-' . $days . ' days'));
                        $events[$d]->setAllowance($faker->numberBetween(50, 400));
                        $events[$d]->setCurrency($faker->currencyCode);
                        $events[$d]->setIsPublic($faker->boolean);
                        $events[$d]->setArrivalHour($faker->dateTimeBetween('-50 days'));
                        $events[$d]->setStartHour($faker->dateTimeBetween('-50 days'));
                        $events[$d]->setEndHour($faker->dateTimeBetween('-50 days'));
                        $events[$d]->setHasAccommodation($faker->boolean);
                        $events[$d]->setTour($tours[$c]);
                        $events[$d]->setVenue($faker->randomElement($venues));
                        $events[$d]->addContact($faker->randomElement($contacts));

                        $manager->persist($events[$d]);
                    }
                }
            }
        }
        $manager->flush();
    }
}
