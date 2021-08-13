<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(EntityManagerInterface $manager, Request $request, \Swift_Mailer $mailer): Response
    {

        $message = new Message();

        $form = $this->createForm(ContactType::class, $message);

        $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
            
                $this->addFlash(
                    'success',
                    "Message envoyé !"

                );

                $manager->persist($message);
                $manager->flush();

                $mail = (new \Swift_Message('Nouveau message via Portfolio'))
                    ->setFrom($message->getEmail())
                    ->setTo("aleksander.buczek.pro@gmail.com")
                    ->setContentType("text/html")
                    ->setBody(
                        $this->renderView(

                            'email.html.twig',
                            ['message' => $message]
                        )
                    )
                ;
                $mailer->send($mail);

                return $this->redirectToRoute('contact');

            }


        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

        /**
     * @Route("/contact/test", name="contact_test")
     */
    public function test(): Response
    {
        $message = new Message();

        $message->setAuthor("Olek Buczek");
        $message->setEmail("buczek29@yahoo.fr");
        $message->setPhone("0667033707");
        $message->setSubject("Demande de devis");

        $message->setContent("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elementum leo orci, in laoreet velit egestas et. Morbi et nunc non purus blandit volutpat. Nulla id velit leo. Pellentesque nisi metus, sodales et lacinia sit amet, feugiat nec est. Morbi convallis libero sit amet justo placerat suscipit. Nunc sodales hendrerit tempor. Mauris pharetra dignissim porta.");

        return $this->render('email.html.twig', [
            'message' => $message
        ]);
    }


}
