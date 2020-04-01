<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Photo;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('subTitle')
            ->add('content')
            ->add('createdAt')
            ->add('category',EntityType::class,[
                'class'=> Category::class,
                'choice_label'=> 'name'

            ])
            ->add('photos',EntityType::class,[
                'class'=>Photo::class,           //choix de la classe
                'choice_label'=> 'url',          //choix du labelle
                'multiple'=> true               //choix multiple
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
