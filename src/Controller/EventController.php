<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class EventController
 * @package App\Controller
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_index")
     */
    public function index()
    {
        $permissions = $this->getUser()->getPermissions();
        foreach($permissions as $p){
            $tours[] = $p->getTour();
        }
        foreach ($tours as $t){
            $tourEvents[] = $t->getEvents();
            foreach ($tourEvents as $e){
                $events = $e;
            }
        }
        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }

    /**
     * @param Event $event
     * @return Response
     *
     * @Route("/show/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        $tour = $event->getTour();
        $permissions = $tour->getPermissions();

            foreach ($permissions as $p){
            if($p->getUser() === $this->getUser()){
                return $this->render('event/show.html.twig', [
                    'event' => $event
                ]);
            }
        }
        return $this->redirectToRoute("home_index");
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", name="event_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($event);
                $entityManager->flush();

                // TODO ajouter un message de validation de création de formulaire
                return $this->redirectToRoute('event_index');
            }
            //TODO ajouter un message d'erreur de formulaire non valide
        }
        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Event $event
     * @return Response
     *
     * @Route("/edit/{id}/", name="event_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Event $event): Response
    {
        $tour = $event->getTour();
        $permissions = $tour->getPermissions();

        foreach ($permissions as $p) {
            if ($p->getUser() === $this->getUser()) {
                $form = $this->createForm(EventType::class, $event);
                $form->handleRequest($request);

                if ($form->isSubmitted()) {
                    if ($form->isValid()) {
                        $this->getDoctrine()->getManager()->flush();

                        //TODO ajouter un message de validation d'edition
                        return $this->redirectToRoute('event_show', [
                            'id' => $event->getId()
                        ]);
                    }
                    //TODO ajouter un message d'erreur de formulaire non valide
                }
                return $this->render('event/edit.html.twig', [
                    'event' => $event,
                    'form' => $form->createView(),
                ]);
            }
        }
        return $this->redirectToRoute("home_index");
    }

    /**
     *
     * @param Event $event
     * @return Response
     *
     * @Route("/delete/{id}", name="event_delete", methods={"GET"})
     */
    public function delete(Event $event)
    {
        $tour = $event->getTour();
        $permissions = $tour->getPermissions();

        foreach ($permissions as $p) {
            if ($p->getUser() === $this->getUser()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($event);
                $entityManager->flush();

                //TODO ajouter un message de confirmation de suppression
                return $this->redirectToRoute('event_index');
            }
        }
        return $this->redirectToRoute("home_index");
    }

    /**
     * @Route("/calendar", name="event_calendar", methods={"GET"})
     */
    public function calendar(): Response
    {
        return $this->render('event/calendar.html.twig');
    }


}
