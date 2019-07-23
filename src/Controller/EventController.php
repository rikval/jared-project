<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
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
        if($this->getUser() != null){
            $events = $this->getUser()->getEvents();
            return $this->render('event/index.html.twig', [
                'events' => $events,
            ]);
        }
         return $this->redirectToRoute("security_login");
    }

    /**
     * @param Event $event
     * @return Response
     *
     * @Route("/show/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        if($event->getIsPublic() === false){
            if ($event->getUsers()->contains($this->getUser())){
            return $this->render('event/show.html.twig', [
                'event' => $event
            ]);
        }
            return $this->redirectToRoute("home_index");
        }
        return $this->render('event/show.html.twig', [
            'event' => $event
        ]);
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
        $event->addUser($this->getUser());

        if($form->isSubmitted()){
            if($form->isValid()){

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($event);
                $entityManager->flush();

                $this->addFlash('success', 'Event has been created !');
                return $this->redirectToRoute('event_index');
            }
            $this->addFlash('error', 'The form contains errors');
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
        if($event->getUsers()->contains($this->getUser())) {
            $form = $this->createForm(EventType::class, $event);
            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                if ($form->isValid()) {
                    $this->getDoctrine()->getManager()->flush();

                    $this->addFlash('success', 'Event has been edited !');
                    return $this->redirectToRoute('event_show', [
                        'id' => $event->getId()
                    ]);
                }
                $this->addFlash('error', 'The form contains errors');
            }
            return $this->render('event/edit.html.twig', [
                'event' => $event,
                'form' => $form->createView(),
            ]);
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
        if($event->getUsers()->contains($this->getUser())){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();

            $this->addFlash('success', 'Event has been deleted !');
            return $this->redirectToRoute('event_index');
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
