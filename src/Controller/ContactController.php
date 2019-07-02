<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class ContactController
 * @package App\Controller
 * @Route("/contact")
 *
 * //TODO ajouter IsGranted("ROLE_USER") quand l'entité User sera créé.
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact_index")
     */
    public function index()
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

    /**
     * @param Contact $contact
     * @return Response
     *
     * @Route("/show/{id}", name="contact_show", methods={"GET"})
     */
    public function show(Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', [
            'contact' => $contact
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", name="contact_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($contact);
                $entityManager->flush();

                // TODO ajouter un message de validation de création de formulaire
                return $this->redirectToRoute('contact_index');
            }
            //TODO ajouter un message d'erreur de formulaire non valide
        }
        return $this->render('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Contact $contact
     * @return Response
     *
     * @Route("/edit/{id}/", name="contact_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Contact $contact): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $this->getDoctrine()->getManager()->flush();

                //TODO ajouter un message de validation d'edition
                return $this->redirectToRoute('contact_show', [
                    'id' => $contact->getId()
                ]);
            }
            //TODO ajouter un message d'erreur de formulaire non valide
        }
        return $this->render('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param EntityManagerInterface $em
     * @param Contact $contact
     * @return Response
     *
     * @Route("/delete/{id}", name="contact_delete", methods={"GET"})
     */
    public function delete(Contact $contact)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($contact);
        $entityManager->flush();

        //TODO ajouter un message de confirmation de suppression
        return $this->redirectToRoute('contact_index');
    }
}
