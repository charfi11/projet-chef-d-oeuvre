<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\CategorieEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('date')
            ->add('lieu')
            ->add('commentaire', TextareaType::class)
            ->add('typeEvent', EntityType::class,[
                'class' => CategorieEvent::class,
                'placeholder' => 'Selectionner une categorie',
                'choice_label' => 'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
