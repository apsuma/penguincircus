<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Keywords;
use App\Entity\Theme;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', TextType::class, [
                'label' => 'titre'
            ])
            ->add('description', TextareaType::class)
            ->add('picture', TextType::class, [
                'label' => 'url du visuel',
                'required' => false
            ])
            ->add('inFront', CheckboxType::class, [
                'label' => 'article à la Une (nb max : 3)',
                'required' => false
            ])
            ->add('resaOpen', CheckboxType::class, [
                'label' => 'Réservation ouverte',
                'required' => false
            ])
            ->add('showDate', DateType::class, [
                'label' => 'Si la réservation est ouverte, date de l\'évènement',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('keywords', EntityType::class, [
                'label' => 'mots-clés :',
                'class' => Keywords::class,
                'choice_label'=> 'name',
                'required' => false,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('themes', EntityType::class, [
                'label' => 'thème(s):',
                'class' => Theme::class,
                'choice_label' => 'name',
                'required' => true,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('authorOf', EntityType::class, [
                'label' => 'auteur : ',
                'class' => User::class,
                'choice_label' => 'lastName',
                'required' => false
            ])
            ->add('favUsers', EntityType::class, [
                'label' => 'en favori',
                'class' => User::class,
                'choice_label' => 'lastName',
                'required' => false,
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
