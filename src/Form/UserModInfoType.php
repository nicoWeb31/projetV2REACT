<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserModInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('username')
            ->add('name')
            ->add('prenom')
            ->add('adresse')
            ->add('codePostal')
            ->add('ville')
            // ->add('password')
            //->add('mail')
            ->add('phone')
            ->add('photo')
            // ->add('roles')
            //->add('updated_at')
            // ->add('activationToken')
            // ->add('resetToken')
            // ->add('catergoryUsers')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
