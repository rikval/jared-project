<?php

namespace App\Controller;

use App\Entity\Permission;
use App\Form\PermissionType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class PermissionController
 * @package App\Controller
 * @Route("/permission")
 *
 *
 */
class PermissionController extends AbstractController
{
    /**
     * @Route("/", name="permission_index")
     */
    public function index()
    {
        return $this->render('permission/index.html.twig', [
            'controller_name' => 'PermissionController',
        ]);
    }

    /**
     * @param Permission $permission
     * @return Response
     *
     * @Route("/show/{id}", name="permission_show", methods={"GET"})
     */
    public function show(Permission $permission): Response
    {
        return $this->render('permission/show.html.twig', [
            'permission' => $permission
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", name="permission_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $permission = new Permission();
        $form = $this->createForm(PermissionType::class, $permission);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($permission);
                $entityManager->flush();

                // TODO ajouter un message de validation de création de formulaire
                return $this->redirectToRoute('permission_index');
            }
            //TODO ajouter un message d'erreur de formulaire non valide
        }
        return $this->render('permission/new.html.twig', [
            'permission' => $permission,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Permission $permission
     * @return Response
     *
     * @Route("/edit/{id}/", name="permission_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Permission $permission): Response
    {
        $form = $this->createForm(PermissionType::class, $permission);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $this->getDoctrine()->getManager()->flush();

                //TODO ajouter un message de validation d'edition
                return $this->redirectToRoute('permission_show', [
                    'id' => $permission->getId()
                ]);
            }
            //TODO ajouter un message d'erreur de formulaire non valide
        }
        return $this->render('permission/edit.html.twig', [
            'permission' => $permission,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param EntityManagerInterface $em
     * @param Permission $permission
     * @return Response
     *
     * @Route("/delete/{id}", name="permission_delete", methods={"GET"})
     */
    public function delete(Permission $permission)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($permission);
        $entityManager->flush();

        //TODO ajouter un message de confirmation de suppression
        return $this->redirectToRoute('permission_index');
    }
}

