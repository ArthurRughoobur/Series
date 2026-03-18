<?php

namespace App\Form;

use App\Entity\Serie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SerieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom :',
                'attr' => [
                    'class' => 'michel'
                ]
            ])
            ->add('overview', TextareaType::class)
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Ended' => 'ended',
                    'Returning' => 'returning',
                    'Canceled' => 'canceled'
                ],
                'expanded' => false,
                'multiple' => false
            ])
            ->add('vote')
            ->add('popularity')
            ->add('genres', ChoiceType::class, [
                'choices' => [
                    'Drama' => 'drama',
                    'SF' => 'sf',
                    'Comedy' => 'comedy',
                    'Fantasy' => 'fantasy'
                ]
            ])
            ->add('firstAirDate', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('lastAirDate', DateType::class)
            ->add('backdrop', FileType::class, [
                'mapped' => false
            ])
            ->add('poster')
            ->add('tmdbId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Serie::class,
            'required' => false,
//            'csrf_protection' => false
        ]);
    }
}
