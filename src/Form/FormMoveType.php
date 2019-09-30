<?php

namespace App\Form;

use App\Entity\ListMove;
use App\Entity\CategorieMove;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormMoveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('tutoriel')
            ->add('resume')
            ->add('difficulte')
            ->add('typemove', EntityType::class,[
                'class' => CategorieMove::class,
                'placeholder' => 'Selectionner une categorie',
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ListMove::class,
        ]);
    }
}
