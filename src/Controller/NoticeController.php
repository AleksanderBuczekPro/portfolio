<?php

namespace App\Controller;

use App\Entity\Notice;
use App\Form\NoticeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NoticeController extends AbstractController
{
    /**
     * @Route("/je-donne-mon-avis", name="notice")
     */
    public function index(Request $request, EntityManagerInterface $manager, \Swift_Mailer $mailer): Response
    {
        $notice = new Notice();

        $form = $this->createForm(NoticeType::class, $notice);

        $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                $notice->setApprouved(false);

                $this->addFlash(
                    'success',
                    "Votre avis a bien été pris en compte !"

                );

                $manager->persist($notice);
                $manager->flush();

                $mail = (new \Swift_Message('Nouveau avis via Portfolio'))
                    ->setFrom("aleksander.buczek.pro@gmail.com")
                    ->setTo("aleksander.buczek.pro@gmail.com")
                    ->setContentType("text/html")
                    ->setBody(
                        $this->renderView(

                            'notice.html.twig',
                            ['notice' => $notice]
                        )
                    )
                ;
                $mailer->send($mail);

                return $this->redirectToRoute('home');
            
            }

        return $this->render('notice/index.html.twig', [
            'form' => $form->createView()
        ]);
        
    
    }
}
