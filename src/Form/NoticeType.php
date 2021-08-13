<?php

namespace App\Form;

use App\Entity\Notice;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class NoticeType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, $this->getConfiguration(false, "Votre avis en quelques phrases", [
                'attr' => ['autocomplete' => 'new-password']
            ]))
            ->add('firstName', TextType::class, $this->getConfiguration(false, "Prénom", [
                'attr' => ['autocomplete' => 'new-password']
            ]))
            ->add('lastName', TextType::class, $this->getConfiguration(false, "Nom", [
                'attr' => ['autocomplete' => 'new-password']
            ]))
            ->add('company', TextType::class, $this->getConfiguration(false, "Entreprise", [
                'attr' => ['autocomplete' => 'new-password']
            ]))
            ->add('send', SubmitType::class, $this->getConfiguration("Je donne mon avis", false, [

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
