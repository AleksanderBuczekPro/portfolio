<?php

namespace App\Form;

use App\Entity\Message;
use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', TextType::class, $this->getConfiguration(false, "Nom", [
                'attr' => ['autocomplete' => 'new-password']
            ]))
            ->add('email', EmailType::class, $this->getConfiguration(false, "Email", [
                'attr' => ['autocomplete' => 'new-password']
            ]))
            ->add('phone', TelType::class, $this->getConfiguration(false, "Numéro de téléphone (facultatif)", [
                'attr' => [
                    'autocomplete' => 'new-password'
                ],
                'required' => false
            ]))
            ->add('subject', TextType::class, $this->getConfiguration(false, "Objet", [
                'attr' => ['autocomplete' => 'new-password']
            ]))
            ->add('content', TextareaType::class, $this->getConfiguration(false, "Message", [
                'attr' => ['autocomplete' => 'new-password']
            ]))
            ->add('send', SubmitType::class, $this->getConfiguration("Envoyer le message", false, [

                'attr' => ['class' => 'btn btn-primary float-end']
            ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
