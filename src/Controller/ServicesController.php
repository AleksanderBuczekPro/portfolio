<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServicesController extends AbstractController
{
    /**
     * @Route("/services", name="services_index")
     */
    public function index(): Response
    {
        return $this->render('services/index.html.twig', [
            'controller_name' => 'ServicesController',
        ]);
    }

    /**
     * @Route("/services/web-design", name="services_webdesign")
     */
    public function webdesign(): Response
    {
        return $this->render('services/webdesign.html.twig', [
            'controller_name' => 'ServicesController',
        ]);
    }

    /**
     * @Route("/services/developppement-web", name="services_developpementweb")
     */
    public function developpementWeb(): Response
    {
        return $this->render('services/developpement_web.html.twig', [
            'controller_name' => 'ServicesController',
        ]);
    }

     /**
     * @Route("/services/graphisme", name="services_graphisme")
     */
    public function graphisme(): Response
    {
        return $this->render('services/graphisme.html.twig', [
            'controller_name' => 'ServicesController',
        ]);
    }
}
