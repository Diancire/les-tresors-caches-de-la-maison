<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class NewUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, [
                'constraints' => [
                    new Email([
                        'message' => 'L\'adresse email "{{ value }}" n\'est pas valide.',
                    ]),
                    new Regex([
                        'pattern' => '/@/',
                        'message' => 'L\'adresse email "{{ value }}" doit contenir le caractère "@".',
                    ]),
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => '', 
                'attr' => [
                    'placeholder' => 'Saisissez votre mot de passe',
                    'class' => 'form_container_content-element-input']
                ],
                'second_options' => ['label' => 'Confirmez le mot de passe', 
                    'attr' => [                        
                        'placeholder' => 'Confirmez votre mot de passe',
                        'class' => 'form_container_content-element-input']
                ],
                'invalid_message' => "Les mots de passe ne correspondent pas.",
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 12,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[-+!*$@%_#])/',
                        'message' => 'Votre mot de passe n\'est pas conforme'
                    ]),
                ],
            ])
            ->add('nickname')
            ->add('first_name')
            ->add('last_name')
            ->add('bio')
            // ->add('create_at')
            // ->add('avatar')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
