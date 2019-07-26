<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class ContactController
 * @package App\Controller
 * @Route("/contact")
 * @IsGranted("ROLE_USER")
 *
 *
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact_index")
     */
    public function index()
    {
        if($this->getUser() != null) {
            $artists = $this->getUser()->getArtist();
            $contacts = $this->getUser()->getContact();
            return $this->render('contact/index.html.twig', [
                'contacts' => $contacts,
                'artists' => $artists,
            ]);
        }
        return $this->redirectToRoute("security_login");
    }

    /**
     * @param Contact $contact
     * @return Response
     *
     * @Route("/show/{id}", name="contact_show", methods={"GET"})
     */
    public function show(Contact $contact): Response
    {
        if($contact->getUser() === $this->getUser()){
            return $this->render('contact/show.html.twig', [
                'contact' => $contact
            ]);
        }
        return $this->redirectToRoute("home_index");
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

        $contact->setUser($this->getUser());

        if($form->isSubmitted()){
            if($form->isValid()){
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($contact);
                $entityManager->flush();
                
                $this->addFlash('success', 'Contact has been created !');
                return $this->redirectToRoute('contact_index');
            }
            $this->addFlash('error', 'The form contains errors');
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

        if($contact->getUser() === $this->getUser()){
            $form = $this->createForm(ContactType::class, $contact);
            $form->handleRequest($request);

            if($form->isSubmitted()){
                if($form->isValid()){
                    $this->getDoctrine()->getManager()->flush();

                    $this->addFlash('success', 'Contact has been edited !');
                    return $this->redirectToRoute('contact_show', [
                        'id' => $contact->getId()
                    ]);
                }
                $this->addFlash('error', 'The form contains errors');
            }
            return $this->render('contact/edit.html.twig', [
                'contact' => $contact,
                'form' => $form->createView(),
            ]);
        }
        return $this->redirectToRoute("home_index");
    }

    /**
     *
     * @param Contact $contact
     * @return Response
     *
     * @Route("/delete/{id}", name="contact_delete", methods={"GET"})
     */
    public function delete(Contact $contact)
    {
        if($contact->getUser() === $this->getUser()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contact);
            $entityManager->flush();

            $this->addFlash('success', 'Contact has been deleted !');
            return $this->redirectToRoute('contact_index');
        }
        return $this->redirectToRoute("home_index");
    }
}
