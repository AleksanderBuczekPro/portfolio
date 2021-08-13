<?php

namespace App\Form;

use App\Entity\Notice;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdminNoticeType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('logo', FileType::class, [
                'label' => "Logo",

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Merci de charger une image JPEG',
                        'maxSize' => '25M',
                        'maxSizeMessage' => 'Merci de charger une image JPEG inférieure à 25 Mo.',
                    ])
                ]
            ])

            ->add('company', TextType::class, $this->getConfiguration("Entreprise", "Entreprise", [
                'attr' => ['autocomplete' => 'new-password']
            ]))
            ->add('firstName', TextType::class, $this->getConfiguration("Prénom", "Prénom", [
                'attr' => ['autocomplete' => 'new-password']
            ]))
            ->add('lastName', TextType::class, $this->getConfiguration("Nom", "Nom", [
                'attr' => ['autocomplete' => 'new-password']
            ]))
            ->add('content', TextareaType::class, $this->getConfiguration("Avis", "Votre avis en quelques phrases", [
                'attr' => ['autocomplete' => 'new-password']
            ]))

            ->add('send', SubmitType::class, $this->getConfiguration("Modifier", false, [

                'attr' => ['class' => 'btn btn-primary float-end']
            ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Notice::class,
        ]);
    }
}
