<?php

namespace App\Form;

use App\Entity\Status;
use App\Entity\Profile;
use App\Entity\Profession;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', EntityType::class, [
                'label' => 'Statut',
                'class' => Status::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('disponibility', ChoiceType::class, [
                'label' => 'Disponibilité',
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('profession', EntityType::class, [
                'label' => 'Profession',
                'class' => Profession::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('adress', TextType::class, [
                'label' => 'Voie'
            ])
            ->add('postal', IntegerType::class, [
                'label' => 'Code Postal'
            ])
            ->add('town', TextType::class, [
                'label' => 'Ville'
            ])
            ->add('phone', TelType::class, [
                'label' => 'N° de téléphone'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse mail'
            ])
            ->add('Ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
