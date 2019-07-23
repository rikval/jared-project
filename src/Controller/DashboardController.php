<?php

namespace App\Controller;

use App\Repository\PermissionRepository;
use App\Repository\TourRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package App\Controller
 * @Route("/dashboard")
 * @IsGranted("ROLE_USER")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard_index")
     */
    public function index(PermissionRepository $permissionRepository, TourRepository $tourRepository)
    {
        $userId = $this->getUser()->getId();
        $allTours = $tourRepository->findAll();
        $userTours = $permissionRepository->findBy(
            [
                'user' => $userId,
                'tour' => $allTours
            ]
        );

        if($this->getUser() != null) {
            $userId = $this->getUser()->getId();
            $allTours = $tourRepository->findAll();
            $userTours = $permissionRepository->findBy(
                [
                    'user' => $userId,
                    'tour' => $allTours
                ]
            );
            $artists = $this->getUser()->getArtist();
            $venues = $this->getUser()->getVenues();
            $events = $this->getUser()->getEvents();
            return $this->render('dashboard/index.html.twig', [
                'tours' => $userTours,
                'artists' => $artists,
                'venues' => $venues,
                'events' => $events
            ]);
        }
        return $this->redirectToRoute("security_login");

    }
}
