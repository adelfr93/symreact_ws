<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,array(
                'required' => true
            ))
            /* ->add('roles', ChoiceType::class, [
                'choices'  => [
                    'Utilisateur' => "ROLE_USER",
                    'Administrateur' => "ROLE_ADMIN",                   
                ],
     
            ]) */
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('attr' => array('placeholder'=>'Mot de passe','class'=>'form-control'),'label'=>false),
                'second_options' => array('attr' => array('placeholder'=>'Confirmation mot de passe','class'=>'form-control'),'label'=>false),
                'required'=>$options['required'],'label'=>false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
