<?php

namespace App\Controller;

use App\Service\Search;
use App\Repository\NoticeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(NoticeRepository $repo, Search $search): Response
    {
        $notices = $repo->findBy(
            ['approuved' => true],
            ['createdAt' => 'ASC']
        );

        $fronts = $search->getFrontProjects();

        return $this->render('home.html.twig', [
            'notices' => $notices,
            'fronts' => $fronts
        ]);
    }
}
