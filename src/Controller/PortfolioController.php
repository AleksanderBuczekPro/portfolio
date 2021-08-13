<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PortfolioController extends AbstractController
{
    /**
     * @Route("/portfolio", name="portfolio_index")
     */
    public function index(ProjectRepository $repo): Response
    {
        $projects = $repo->findAll();
        
        return $this->render('portfolio/index.html.twig', [
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/portfolio/{slug}", name="portfolio_show")
     * 
     */
    public function show(Project $project): Response
    {
        
        return $this->render('portfolio/show.html.twig', [
            'project' => $project,
        ]);
    }
}
