<?php

namespace App\Controller;

use App\Entity\Notice;
use App\Entity\Project;
use App\Form\ProjectType;

use App\Form\AdminNoticeType;
use App\Repository\NoticeRepository;
use App\Repository\MessageRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @Route("/admin/projets", name="admin_projects")
     */
    public function index(ProjectRepository $repo): Response
    {
        $projects = $repo->findBy(array(), array('date' => 'DESC'));

        return $this->render('admin/project/index.html.twig', [
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/add-project", name="admin_add_project")
     */
    public function addProject(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {

        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                
                $visualFiles = $form->get('visuals')->getData();

                // Visuals
                foreach($visualFiles as $visual){

                    $visual->setProject($project);
                   
                    $manager->persist($visual);
                    
                }

                /* Front Image */
                /** @var UploadedFile $frontImageFile */
                $frontImageFile = $form->get('frontImage')->getData();

                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                if ($frontImageFile) {
                    $originalFilename = pathinfo($frontImageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$frontImageFile->guessExtension();

                    // Move the file to the directory where brochures are stored
                    try {
                        $frontImageFile->move(
                            $this->getParameter('visuals_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $project->setFrontImage($newFilename);


                }
               

                $this->addFlash(
                    'success',
                    "Le projet <strong>{$project->getName()}</strong> a bien été créée !"

                );

                $manager->persist($project);
                $manager->flush();

                return $this->redirectToRoute('admin');
            
            }

        return $this->render('admin/project/create.html.twig', [
            'form' => $form->createView()
        ]);
        
    }

    /**
     * @Route("/edit-project/{id}", name="admin_edit_project")
     */
    public function editProject(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger, Project $project): Response
    {

        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                
                $visualFiles = $form->get('visuals')->getData();

                // Visuals
                foreach($visualFiles as $visual){

                    $visual->setProject($project);
                   
                    $manager->persist($visual);
                    
                }

                /* Front Image */
                /** @var UploadedFile $frontImageFile */
                $frontImageFile = $form->get('frontImage')->getData();

                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                if ($frontImageFile) {
                    $originalFilename = pathinfo($frontImageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$frontImageFile->guessExtension();

                    // Move the file to the directory where brochures are stored
                    try {
                        $frontImageFile->move(
                            $this->getParameter('visuals_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $project->setFrontImage($newFilename);
                
                }

                $this->addFlash(
                    'success',
                    "Le projet <strong>{$project->getName()}</strong> a bien été modifié !"

                );

                $manager->persist($project);
                $manager->flush();

                return $this->redirectToRoute('admin');
            
            }

        return $this->render('admin/project/edit.html.twig', [
            'form' => $form->createView()
        ]);
        
    }

    /**
     * Permet de supprimer un projet
     *
     * @Route("/delete-project/{id}", name="admin_delete_project")
     * 
     */
    public function delete(Project $project, EntityManagerInterface $manager)
    {
        $visuals = $project->getVisuals();

        // Visuals
        foreach($visuals as $visual){

            $manager->remove($visual);
            
        }

        $manager->remove($project);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le projet <strong>{$project->getName()}</strong> a bien été supprimé !"

        );

        return $this->redirectToRoute('admin');



    }

    /**
     * @Route("/admin/contacts", name="admin_contacts")
     */
    public function contacts(MessageRepository $repo): Response
    {
        $contacts = $repo->findAll();

        return $this->render('admin/contact/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * @Route("/admin/notices", name="admin_notices")
     */
    public function notices(NoticeRepository $repo): Response
    {
        $notices = $repo->findAll();

        return $this->render('admin/notice/index.html.twig', [
            'notices' => $notices,
        ]);
    }

    /**
     * @Route("/edit-notice/{id}", name="admin_edit_notice")
     */
    public function editNotice(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger, Notice $notice): Response
    {

        $form = $this->createForm(AdminNoticeType::class, $notice);

        $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){


                /* Front Image */
                /** @var UploadedFile $frontImageFile */
                $logo = $form->get('logo')->getData();

                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                if ($logo) {
                    $originalFilename = pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$logo->guessExtension();

                    // Move the file to the directory where brochures are stored
                    try {
                        $logo->move(
                            $this->getParameter('visuals_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $notice->setLogo($newFilename);
                
                }

                $this->addFlash(
                    'success',
                    "L'avis de <strong>{$notice->getFirstName()}</strong> a bien été modifié !"

                );

                $manager->persist($notice);
                $manager->flush();

                return $this->redirectToRoute('admin_notices');
            
            }

        return $this->render('admin/notice/edit.html.twig', [
            'form' => $form->createView()
        ]);
        
    }

    /**
     * Permet de d'approuver ou non un avis
     *
     * @Route("/approuve-notice/{id}", name="admin_approuve_notice")
     * 
     */
    public function approuve(Notice $notice, EntityManagerInterface $manager)
    {
    
        if($notice->getApprouved()){

            $notice->setApprouved(false);
            $status = "désapprouvé";

        }else{

            $notice->setApprouved(true);
            $status = "approuvé";
        }

        $manager->persist($notice);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'avis de <strong>{$notice->getFirstName()}</strong> a été " . $status . " !"

        );

        return $this->redirectToRoute('admin_notices');



    }

    

}