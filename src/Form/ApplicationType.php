<?php

namespace App\Form;

use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
    /**
     * Permet d'avoir la configuration de base d'un champ
     *
     * @param string $label
     * @param string $placeholer
     * @return array
     */
    public function getConfiguration($label, $placeholer, $class)
    {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholer,
                'class' => $class,
            ]
        ];
    }
}
