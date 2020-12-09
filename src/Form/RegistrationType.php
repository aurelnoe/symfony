<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ApplicationType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class,$this->getConfiguration('Adresse mail', 'email@mail.com','form-control'))
            ->add('password',PasswordType::class,$this->getConfiguration('Mot de passe', 'Votre mot de passe...','form-control'))
            ->add('nom',TextType::class,$this->getConfiguration('Nom', 'Votre nom...','form-control'))
            ->add('prenom',TextType::class,$this->getConfiguration('Prénom', 'Votre prénom...','form-control'))
            ->add('dateAnniversaire',BirthdayType::class, $this->getConfiguration('Date de naissance','jj/mm/aaaa','datepicker'),[        
                'widget' => 'single_text',
                'html5'=>false,
                'type' => 'date',
                'attr' => [
                    'autocomplete'=>"off"
                    ],
                'format'=>'dd-MM-yyyy',
                ]) 
            ->add('dateInscription',DateTimeType::class, [
                'widget' => 'single_text',
                'html5' => true,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
