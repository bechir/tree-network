<?php

namespace App\Form;

use App\Entity\Gender;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LinkedUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'form.firstName'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'form.lastName'
            ])
            // ->add('bornAt', TextType::class, [
            //     'required' => false,
            //     'label' => 'form.bornAt'
            // ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'form.description'
            ])
            // ->add('birthPlace', TextType::class, [
            //     'required' => false,
            //     'label' => 'form.birthPlace'
            // ])
            ->add('gender', EntityType::class, [
                'class' => Gender::class,
                'choice_label' => 'name',
                'choice_translation_domain' => true,
                'required' => false,
                'placeholder' => 'form.select'
            ])
            ->add('avatar', UserAvatarType::class, [
                'required' => false,
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
