<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\User;
use App\Form\ArtistType;
use App\Repository\ArtistRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class ArtistController
 * @package App\Controller
 * @Route("/artist")
 * @IsGranted("ROLE_USER")
 *
 */
class ArtistController extends AbstractController
{
    /**
     * @Route("/", name="artist_index")
     */
    public function index()
    {
        if($this->getUser() != null) {
            $artists = $this->getUser()->getArtist();
            return $this->render('artist/index.html.twig', [
                'artists' => $artists,
            ]);
        }
        return $this->redirectToRoute("security_login");
    }

    /**
     * @param Artist $artist
     * @return Response
     *
     * @Route("/show/{id}", name="artist_show", methods={"GET"})
     */
    public function show(Artist $artist): Response
    {
        if($artist->getUser() === $this->getUser()){
            return $this->render('artist/show.html.twig', [
                'artist' => $artist
            ]);
        }
        return $this->redirectToRoute("home_index");
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/new", name="artist_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        $artist->setUser($this->getUser());

        if($form->isSubmitted()){
            if($form->isValid()){

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($artist);
                $entityManager->flush();

                $this->addFlash('success', 'Artist has been created !');
                return $this->redirectToRoute('artist_index');
            }
            $this->addFlash('error', 'The form contains errors');
        }
        return $this->render('artist/new.html.twig', [
            'artist' => $artist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Artist $artist
     * @return Response
     *
     * @Route("/edit/{id}/", name="artist_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Artist $artist): Response
    {
        if($artist->getUser() === $this->getUser()){
            $form = $this->createForm(ArtistType::class, $artist);
            $form->handleRequest($request);

            if($form->isSubmitted()){
                if($form->isValid()){
                    $this->getDoctrine()->getManager()->flush();

                    $this->addFlash('success', 'Artist has been updated !');
                    return $this->redirectToRoute('artist_show', [
                        'id' => $artist->getId()
                    ]);
                }
                $this->addFlash('error', 'The form contains errors');
            }
            return $this->render('artist/edit.html.twig', [
                'artist' => $artist,
                'form' => $form->createView(),
            ]);
        }
        return $this->redirectToRoute("home_index");
    }

    /**
     *
     * @param Artist $artist
     * @return Response
     *
     * @Route("/delete/{id}", name="artist_delete", methods={"GET"})
     */
    public function delete(Artist $artist)
    {
        if($artist->getUser() === $this->getUser()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($artist);
            $entityManager->flush();

            $this->addFlash('success', 'Artist has been deleted !');
            return $this->redirectToRoute('artist_index');
        }
        return $this->redirectToRoute("home_index");
    }

    //TODO delete if no use
//    /**
//     * @Route("/api/artist", name="api_artist_form", methods={"POST"})
//     * @param Request $request
//     * @return JsonResponse
//     */
//    public function tourFormData(Request $request)
//    {
//        $data = [];
//        if(null !== $request->get('userId')){
//            $userRepository = $this->getDoctrine()->getRepository(User::class);
//            $user = $userRepository->find($request->get('userId'));
//            $artists = $user->getArtist();
//            foreach ($artists as $a){
//                $data[$a->getId()] = $t->getName();
//            }
//        }
//        return new JsonResponse($data);
//    }
}
