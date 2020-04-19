<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\CatergoryUser;
use PhpParser\Parser\Multiple;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditUserAdminType extends AbstractType
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
            ->add('mail',EmailType::class)
            ->add('phone')
            ->add('roles',ChoiceType::class,[
                'choices'=>[

                    'Utilisateurs' =>'ROLE_USER',
                    'Membre actif'=> 'ROLE_MEMBRE',
                    'Admin'=> 'ROLE_ADMIN'
                ],
                'expanded' =>true,
                'multiple' => true,
                'label'=>'Rôles'
            ])
            ->add('catergoryUsers',EntityType::class,[
                'class'=>CatergoryUser::class,
                'choice_label'=>'name',
                'multiple'=> true,
                'expanded' => true,
                'label'=>'Carégories :'///check-box choix multiple
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
