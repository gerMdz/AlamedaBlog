<?php

namespace App\Form;

use App\Entity\Moderator;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModeratorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isActive', CheckboxType::class,[
                'label'=>'generic.active',
                'attr' => [
                    'form-control'
                ]
            ])
            ->add('person', EntityType::class, [
                'class'=>User::class,
                'label'=>'label.moderator',
                'placeholder' => 'action.create_moderator',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Moderator::class,
        ]);
    }
}
