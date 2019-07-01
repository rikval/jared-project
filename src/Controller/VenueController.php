<?php

namespace App\Controller;

use App\Entity\Venue;
use App\Form\VenueType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class VenueController
 * @package App\Controller
 * @Route("/venue")
 *
 * //TODO ajouter IsGranted("ROLE_USER") quand l'entité User sera créé.
 */
class VenueController extends AbstractController
{
    /**
     * @Route("/", name="venue_index")
     */
    public function index()
    {
        return $this->render('venue/index.html.twig', [
            'controller_name' => 'VenueController',
        ]);
    }

    /**
     * @param Venue $venue
     * @return Response
     *
     * @Route("/show/{id}", name="venue_show", methods={"GET"})
     */
    public function show(Venue $venue): Response
    {
        return $this->render('venue/show.html.twig', [
            'venue' => $venue
        ]);
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

        if($form->isSubmitted()){
            if($form->isValid()){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($venue);
                $entityManager->flush();

                // TODO ajouter un message de validation de création de formulaire
                return $this->redirectToRoute('venue_index');
            }
            //TODO ajouter un message d'erreur de formulaire non valide
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
        $form = $this->createForm(VenueType::class, $venue);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $this->getDoctrine()->getManager()->flush();

                //TODO ajouter un message de validation d'edition
                return $this->redirectToRoute('venue_show', [
                    'id' => $venue->getId()
                ]);
            }
            //TODO ajouter un message d'erreur de formulaire non valide
        }
        return $this->render('venue/edit.html.twig', [
            'venue' => $venue,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param EntityManagerInterface $em
     * @param Venue $venue
     * @return Response
     *
     * @Route("/delete/{id}", name="venue_delete", methods={"GET"})
     */
    public function delete(EntityManagerInterface $em, Venue $venue)
    {
        $em->remove($venue);
        $em->flush();

        //TODO ajouter un message de confirmation de suppression
        return $this->redirectToRoute('venue_index');
    }
}
