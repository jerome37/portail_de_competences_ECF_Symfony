<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\SkillLevel;
use App\Entity\ProfileSkill;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProfileSkillType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('skill', EntityType::class, [
                'label' => 'Compétences',
                'class' => Skill::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('level', EntityType::class, [
                'label' => 'Niveau de compétence',
                'class' => SkillLevel::class,
                'choice_label' => 'status',
                'expanded' => false,
                'multiple' => false,
            ])
            ->add('appreciation', ChoiceType::class, [
                'label' => 'Appréciez-vous cette compétence ?',
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'expanded' => false,
                'multiple' => false,
            ])
            // ->add('profile', EntityType::class, [
            //     'label' => 'Collaborateur',
            //     'class' => Profile::class,
            //     'choice_label' => 'lastname',
            //     'expanded' => true,
            //     'multiple' => false,
            // ])
            ->add('Ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProfileSkill::class,
        ]);
    }
}
