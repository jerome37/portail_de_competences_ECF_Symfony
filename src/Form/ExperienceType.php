<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Experience;
use App\Entity\TypeExperience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('function', TextType::class, [
                'label' => 'Fonction exercée'
            ])
            ->add('location', TextType::class, [
                'label' => 'Localisation'
            ])
            ->add('date_start', DateType::class, [
                'label' => 'Date de début',
                'widget' => 'single_text'
            ])
            ->add('date_end', DateType::class, [
                'label' => 'Date de fin',
                'widget' => 'single_text'
            ])
            ->add('description', TextType::class, [
                'label' => 'Description'
            ])
            ->add('context', TextType::class, [
                'label' => 'Contexte'
            ])
            ->add('achievement', TextType::class, [
                'label' => 'Réalisation(s)'
            ])
            ->add('tech_env', TextType::class, [
                'label' => 'Environnement technique'
            ])
            ->add('type', EntityType::class, [
                'label' => 'Type d\'expérience',
                'class' => TypeExperience::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('company', EntityType::class, [
                'label' => 'Nom de l\'entreprise',
                'class' => Company::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
