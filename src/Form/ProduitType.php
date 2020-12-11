<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Categorie;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProduitType extends ApplicationType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation',TextType::class, $this->getConfiguration(false,'designation','form-control m-auto'))  
            ->add('prix',MoneyType::class, $this->getConfiguration(false,'prix','form-control m-auto'))
            ->add('couleur',TextType::class, $this->getConfiguration(false,'couleur','form-control m-auto'))
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'label' => 'Catégorie',
                'choice_label' => "nom", ]);
            // ->add('save',SubmitType::class,[
            //     'label' => 'Ajouter un produit',
            //     'attr' => [
            //         'class' => 'btn btn-primary my-2',
            //         ]
            //     ]); 
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
