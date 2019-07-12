<?php

namespace App\Controller;

use App\Entity\Relation;
use App\Form\RelationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RelationController
 * @package App\Controller
 * @Route("/relation")
 *
 *
 */
class RelationController extends AbstractController
{
    /**
     * @Route("/", name="relation_index")
     */
    public function index()
    {
        return $this->render('relation/index.html.twig', [
            'controller_name' => 'RelationController',
        ]);
    }

    /**
     * @param Relation $relation
     * @return Response
     *
     * @Route("/show/{id}", name="relation_show", methods={"GET"})
     */
    public function show(Relation $relation): Response
    {
        return $this->render('relation/show.html.twig', [
            'relation' => $relation
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", name="relation_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $relation = new Relation();
        $form = $this->createForm(RelationType::class, $relation);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($relation);
                $entityManager->flush();

                // TODO ajouter un message de validation de création de formulaire
                return $this->redirectToRoute('relation_index');
            }
            //TODO ajouter un message d'erreur de formulaire non valide
        }
        return $this->render('relation/new.html.twig', [
            'relation' => $relation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Relation $relation
     * @return Response
     *
     * @Route("/edit/{id}/", name="relation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Relation $relation): Response
    {
        $form = $this->createForm(RelationType::class, $relation);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $this->getDoctrine()->getManager()->flush();

                //TODO ajouter un message de validation d'edition
                return $this->redirectToRoute('relation_show', [
                    'id' => $relation->getId()
                ]);
            }
            //TODO ajouter un message d'erreur de formulaire non valide
        }
        return $this->render('relation/edit.html.twig', [
            'relation' => $relation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Relation $relation
     * @return Response
     *
     * @Route("/delete/{id}", name="relation_delete", methods={"GET"})
     */
    public function delete(Relation $relation)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($relation);
        $entityManager->flush();

        //TODO ajouter un message de confirmation de suppression
        return $this->redirectToRoute('relation_index');
    }
}
