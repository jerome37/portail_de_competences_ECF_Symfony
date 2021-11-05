<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email d\'entreprise'
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Role',
                'choices' => [
                    'Collaborateur' => 'ROLE_COLLABORATEUR',
                    'Commercial' => 'ROLE_COMMERCIAL' ,
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'label' => 'Roles',
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Mot de passe invalide',
                'first_options' => [
                        'label' => 'Votre mot de passe',
                ],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                ],
                'required' => true
            ])
            ->add('submit', SubmitType::class)
        ;

        $builder->get('roles')
                ->addModelTransformer(new CallbackTransformer(
                    function ($rolesArray) {
                        return count($rolesArray)? $rolesArray[0]: null;
                    },
                    function ($rolesString) {
                        return [$rolesString];
                    }
                ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
