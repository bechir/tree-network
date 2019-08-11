<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Gender;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'required' => false,
                'label' => 'form.firstName'
            ])
            ->add('lastName', TextType::class, [
                'required' => false,
                'label' => 'form.lastName'
            ])
            ->add('phoneNumber', TextType::class, [
                'required' => false,
                'label' => 'form.phoneNumber'
            ])
            ->add('username', TextType::class, [
                'required' => false,
                'label' => 'form.username'
            ])
            ->add('gender', EntityType::class, [
                'class' => Gender::class,
                'choice_label' => 'name',
                'required' => false,
                'choice_translation_domain' => true
            ])
            ->add('bornAt', TextType::class, [
                'required' => false,
                'label' => 'form.bornAt'
            ])
            ->add('birthPlace', TextType::class, [
                'required' => false,
                'label' => 'form.birthPlace'
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'form.description'
            ])
            // ->add('avatar', UserAvatarType::class, [
            //     'required' => false,
            //     'label' => 'form.d'
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
