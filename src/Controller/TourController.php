<?php

namespace App\Controller;

use App\Entity\Tour;
use App\Form\TourType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class TourController
 * @package App\Controller
 * @Route("/tour")
 *
 * //TODO ajouter IsGranted("ROLE_USER") quand l'entité User sera créé.
 */
class TourController extends AbstractController
{
    /**
     * @Route("/", name="tour_index")
     */
    public function index()
    {
        return $this->render('tour/index.html.twig', [
            'controller_name' => 'TourController',
        ]);
    }

    /**
     * @param Tour $tour
     * @return Response
     *
     * @Route("/show/{id}", name="tour_show", methods={"GET"})
     */
    public function show(Tour $tour): Response
    {
        return $this->render('tour/show.html.twig', [
            'tour' => $tour
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", name="tour_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $tour = new Tour();
        $form = $this->createForm(TourType::class, $tour);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($tour);
                $entityManager->flush();

                // TODO ajouter un message de validation de création de formulaire
                return $this->redirectToRoute('tour_index');
            }
            //TODO ajouter un message d'erreur de formulaire non valide
        }
        return $this->render('tour/new.html.twig', [
            'tour' => $tour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Tour $tour
     * @return Response
     *
     * @Route("/edit/{id}/", name="tour_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Tour $tour): Response
    {
        $form = $this->createForm(TourType::class, $tour);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $this->getDoctrine()->getManager()->flush();

                //TODO ajouter un message de validation d'edition
                return $this->redirectToRoute('tour_show', [
                    'id' => $tour->getId()
                ]);
            }
            //TODO ajouter un message d'erreur de formulaire non valide
        }
        return $this->render('tour/edit.html.twig', [
            'tour' => $tour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param EntityManagerInterface $em
     * @param Tour $tour
     * @return Response
     *
     * @Route("/delete/{id}", name="tour_delete", methods={"GET"})
     */
    public function delete(EntityManagerInterface $em, Tour $tour)
    {
        $em->remove($tour);
        $em->flush();

        //TODO ajouter un message de confirmation de suppression
        return $this->redirectToRoute('tour_index');
    }
}
