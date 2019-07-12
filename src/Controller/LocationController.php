<?php

namespace App\Controller;

use App\Entity\Location;
use App\Form\LocationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LocationController
 * @package App\Controller
 * @Route("/location")
 *
 *
 */
class LocationController extends AbstractController
{
    /**
     * @Route("/", name="location_index")
     */
    public function index()
    {
        return $this->render('location/index.html.twig', [
            'controller_name' => 'LocationController',
        ]);
    }

    /**
     * @param Location $location
     * @return Response
     *
     * @Route("/show/{id}", name="location_show", methods={"GET"})
     */
    public function show(Location $location): Response
    {
        return $this->render('location/show.html.twig', [
            'location' => $location
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", name="location_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $location = new Location();
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($location);
                $entityManager->flush();

                $this->addFlash('success', 'Location has been created !');
                return $this->redirectToRoute('location_index');
            }
            $this->addFlash('error', 'The form contains errors');
        }
        return $this->render('location/new.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Location $location
     * @return Response
     *
     * @Route("/edit/{id}/", name="location_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Location $location): Response
    {
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $this->getDoctrine()->getManager()->flush();

                $this->addFlash('success', 'Location has been edited !');
                return $this->redirectToRoute('location_show', [
                    'id' => $location->getId()
                ]);
            }
            $this->addFlash('error', 'The form contains errors');
        }
        return $this->render('location/edit.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Location $location
     * @return Response
     *
     * @Route("/delete/{id}", name="location_delete", methods={"GET"})
     */
    public function delete(Location $location)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($location);
        $entityManager->flush();

        $this->addFlash('success', 'Location has been deleted !');
        return $this->redirectToRoute('location_index');
    }
}
