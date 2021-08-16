<?php

namespace App\Form;

use App\Entity\Project;
use App\Form\VisualType;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProjectType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('frontImage', FileType::class, [
                'label' => 'Visuel principal',

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
            ->add('name', TextType::class, $this->getConfiguration("Nom du projet", "Entrez le nom du projet"))
            ->add('client', TextType::class, $this->getConfiguration("Client", "Client"))
            ->add('category', TextType::class, $this->getConfiguration("Catégorie", "Catégorie"))
            ->add('introduction', TextareaType::class, $this->getConfiguration("Introduction", "Entrez l'introduction au projet"))
            ->add('subtitle', TextType::class, $this->getConfiguration("Sous-titre", "Entrez le sous-titre du projet"))
            ->add('description', TextareaType::class, $this->getConfiguration("Description", "Décrivez votre projet"))
            ->add('color', ColorType::class, $this->getConfiguration("Couleur principale", "Sélectionnez la couleur principale"))
            ->add('date', DateType::class, [
                'label' => "Date de création",
                'format' => 'dd-MM-yyyy',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ]
            ])
            ->add('visuals', CollectionType::class, [
                'entry_type' => VisualType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,

                'label' => false
            ])
            ->add('front', ChoiceType::class,[
                'label' => "Mettre à la Une",
                'choices' => [
                    'Oui' => 1,
                    'Non' => 0
                    ]
                ]
            );

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
