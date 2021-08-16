<?php

namespace App\Controller;

use App\Entity\Project;
use App\Service\Search;
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
        $projects = $repo->findBy(array(), array('date' => 'DESC'));
        
        return $this->render('portfolio/index.html.twig', [
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/portfolio/{slug}", name="portfolio_show")
     * 
     */
    public function show(Project $project, Search $search): Response
    {
        $previous = $search->getPrevious($project);
        $next = $search->getNext($project);

        dump($previous);
        dump($next);
        
        return $this->render('portfolio/show.html.twig', [
            'project' => $project,
            'previous' => $previous,
            'next' => $next
        ]);
    }
}
