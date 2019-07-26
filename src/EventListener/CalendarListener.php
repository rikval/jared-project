<?php

namespace App\EventListener;

use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use CalendarBundle\Entity\Event as Ev;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\Security\Core\Security;

class CalendarListener
{
    private $eventRepository;
    private $router;
    private $security;

    public function __construct(
        EventRepository $eventRepository,
        UrlGeneratorInterface $router,
        Security $security
    ) {
        $this->eventRepository = $eventRepository;
        $this->router = $router;
        $this->security = $security;
    }

    public function load(CalendarEvent $calendar): void
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $user = $this->security->getUser();

        $events = $this->eventRepository
            ->createQueryBuilder('event')
            ->innerJoin('event.users', 'eventUser')
            ->andWhere('eventUser.id = :user')
            ->andWhere('event.beginAt BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;

        foreach ($events as $event) {
            $eventEv = new Ev(
                $event->getTitle(),
                $event->getBeginAt(),
                $event->getEndAt()
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            $eventEv->setOptions([
                'backgroundColor' => '#9b43a9',
                'borderColor' => '#9b43a9',
            ]);
            $eventEv->addOption(
                'url',
                $this->router->generate('event_show', [
                    'id' => $event->getId(),
                ])
            );

            $calendar->addEvent($eventEv);
        }
    }
}