<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Reservation;
use App\Entity\User;
use App\Repository\ArticleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbPlaceChild', NumberType::class, [
                'label'=> 'Nombre de places enfant:'
            ])
            ->add('nbPlaceAdult', NumberType::class, [
                'label'=> 'Nombre de places adulte :'
            ])
            ->add('createdAt', DateTimeType::class)
            ->add('articles', EntityType::class, [
                'label' => 'évènement que je réserve:',
                'class' => Article::class,
                'query_builder' => function(ArticleRepository $articleRepo) {
                    return $articleRepo
                        ->createQueryBuilder('a')
                        ->where('a.resaOpen = true');
                } ,
                'choice_label' => 'subject',
                'required' => true
            ])
            ->add('user', EntityType::class, ['class' => User::class])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
