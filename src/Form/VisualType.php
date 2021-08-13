<?php

namespace App\Form;

use App\Entity\Visual;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class VisualType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichFileType::class,[
                'required' => false,
                'allow_delete' => false,
                'download_uri' => true,
                'download_label' => false,
                'asset_helper' => true,

                'label' => false
            ]);
            // ->add('imageFile', FileType::class, [
            //     'label' => 'Visuel (PDF file)',

            //     // unmapped means that this field is not associated to any entity property
            //     'mapped' => false,

            //     // make it optional so you don't have to re-upload the PDF file
            //     // every time you edit the Product details
            //     'required' => false,

            //     // unmapped fields can't define their validation using annotations
            //     // in the associated entity, so you can use the PHP constraint classes
            //     'constraints' => [
            //         new File([
            //             'maxSize' => '1024k',
            //             'mimeTypes' => [
            //                 'image/jpeg'
            //             ],
            //             'mimeTypesMessage' => 'Merci de charger une image JPEG',
            //         ])
            //     ],
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Visual::class,
        ]);
    }
}
