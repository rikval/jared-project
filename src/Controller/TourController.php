<?php

namespace App\Controller;

use App\Entity\Tour;
use App\Form\TourType;
use App\Repository\TourRepository;
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
        $permissions = $this->getUser()->getPermissions();
        foreach($permissions as $p){
            $tours[] = $p->getTour();
        }
        return $this->render('tour/index.html.twig', [
            'tours' => $tours,
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
        $permissions = $tour->getPermissions();
        foreach ($permissions as $p){
            if($p->getUser() === $this->getUser()){
                return $this->render('tour/show.html.twig', [
                    'tour' => $tour
                ]);
            }
        }
        return $this->redirectToRoute("home_index");
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

                $this->addFlash('success', 'Tour has been created !');
                return $this->redirectToRoute('tour_index');
            }
            $this->addFlash('error', 'The form contains errors');
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
        $permissions = $tour->getPermissions();
        foreach ($permissions as $p) {
            if ($p->getUser() === $this->getUser()) {
                $form = $this->createForm(TourType::class, $tour);
                $form->handleRequest($request);

                if ($form->isSubmitted()) {
                    if ($form->isValid()) {
                        $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'Tour has been edited !');
                return $this->redirectToRoute('tour_show', [
                    'id' => $tour->getId()
                ]);
            }
            $this->addFlash('error', 'The form contains errors');
        }
        return $this->redirectToRoute("home_index");
    }

    /**
     *
     * @param Tour $tour
     * @return Response
     *
     * @Route("/delete/{id}", name="tour_delete", methods={"GET"})
     */
    public function delete(Tour $tour)
    {
        $permissions = $tour->getPermissions();
        foreach ($permissions as $p) {
            if ($p->getUser() === $this->getUser()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($tour);
                $entityManager->flush();
                return $this->redirectToRoute('tour_index');
            }
        }
        return $this->redirectToRoute("home_index");
        $this->addFlash('success', 'Tour has been deleted !');
    }
}
