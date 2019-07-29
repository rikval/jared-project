<?php

namespace App\Controller;

use App\Entity\Venue;
use App\Form\VenueType;
use App\Repository\VenueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class VenueController
 * @package App\Controller
 * @Route("/venue")
 *
 *
 */
class VenueController extends AbstractController
{
    /**
     * @Route("/", name="venue_index")
     */
    public function index()
    {
        if($this->getUser() != null) {
            $venues = $this->getUser()->getVenues();
            return $this->render('venue/index.html.twig', [
                'venues' => $venues,
            ]);
        }
        return $this->redirectToRoute("security_login");
    }

    /**
     * @param Venue $venue
     * @return Response
     *
     * @Route("/show/{id}", name="venue_show", methods={"GET"})
     */
    public function show(Venue $venue): Response
    {
        if($venue->getUser() === $this->getUser()){
            return $this->render('venue/show.html.twig', [
                'venue' => $venue
            ]);
        }
        return $this->redirectToRoute("home_index");
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", name="venue_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $venue = new Venue();
        $form = $this->createForm(VenueType::class, $venue);
        $form->handleRequest($request);
        $venue->setUser($this->getUser());

        if($form->isSubmitted()){
            if($form->isValid()){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($venue);
                $entityManager->flush();

                $this->addFlash('success', 'Venue has been created !');
                return $this->redirectToRoute('venue_index');
            }
            $this->addFlash('error', 'The form contains errors');
        }
        return $this->render('venue/new.html.twig', [
            'venue' => $venue,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Venue $venue
     * @return Response
     *
     * @Route("/edit/{id}/", name="venue_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Venue $venue): Response
    {
        if($venue->getUser() === $this->getUser()) {
            $form = $this->createForm(VenueType::class, $venue);
            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                if ($form->isValid()) {
                    $this->getDoctrine()->getManager()->flush();

                    $this->addFlash('success', 'Venue has been edited !');
                    return $this->redirectToRoute('venue_show', [
                        'id' => $venue->getId()
                    ]);
                }
                $this->addFlash('error', 'The form contains errors');
            }
            return $this->render('venue/edit.html.twig', [
                'venue' => $venue,
                'form' => $form->createView(),
            ]);
        }
        return $this->redirectToRoute("home_index");
    }


    /**
     * @param Venue $venue
     * @return Response
     *
     * @Route("/delete/{id}", name="venue_delete", methods={"GET"})
     */
    public function delete(Venue $venue)
    {
        if ($venue->getUser() === $this->getUser()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($venue);
            $entityManager->flush();

            $this->addFlash('success', 'Venue has been deleted !');
            return $this->redirectToRoute('venue_index');
        }
        return $this->redirectToRoute("home_index");
    }
}
