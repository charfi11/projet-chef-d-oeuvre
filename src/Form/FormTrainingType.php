<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Groupe;
use App\Entity\ListMove;
use App\Entity\Training;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FormTrainingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('lieu')
            ->add('duree')
            ->add('commentaire', TextareaType::class)
            ->add('selectMove', EntityType::class ,[
                 'class' => Listmove::class,
                 'choice_label' => 'name',
                'multiple' => true,
                'mapped' => false,
                'label' => 'Selectionner des mouvements'
                ]);
                
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Training::class,
        ]);
    }
}
