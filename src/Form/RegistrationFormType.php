<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class,[
                'label'=>'label.email'
            ])
            ->add('username', TextType::class,[
                'label'=>'label.username',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('fullName', TextType::class,[
                'label'=>'label.fullname'
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label'=>'label.agree_terms',
                'constraints' => [
                    new IsTrue([
                        'message' => 'registration.accept.terms',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
//                'invalid_message' => 'The password fields must match.',
                'options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'message.password.not_blank',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'message.password.length'. ' {{ limit }} '. 'text.characters',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                    'attr' => ['class' => 'password-field']
                ],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repita Password'],
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'attr' => ['autocomplete' => 'new-password'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
