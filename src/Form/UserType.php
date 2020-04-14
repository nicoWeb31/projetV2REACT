<?php

namespace App\Form;


use App\Entity\User;
use App\Entity\CatergoryUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('name')
            ->add('prenom')
            ->add('adresse')
            ->add('codePostal')
            ->add('ville')
            ->add('password',PasswordType::class)
            ->add('verifPassword',PasswordType::class)
            ->add('mail')
            ->add('phone')
            ->add('imageFile',FileType::class,['required'=>false])
            //->add('roles')
            ->add('catergoryUsers',EntityType::class,[
                'class'=>CatergoryUser::class,
                'choice_label'=>'name',
                'multiple'=> true,
                'expanded' => true,///check-box choix multiple
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
