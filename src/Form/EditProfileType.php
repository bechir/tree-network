<?php

/*
 * This file is part of the Tree Network application.
 *
 * (c) Bechir Ba <bechiirr71@gmail.com>
 */

namespace App\Form;

use App\Entity\User;
use App\Entity\Gender;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'required' => false,
                'label' => 'form.firstName',
            ])
            ->add('lastName', TextType::class, [
                'required' => false,
                'label' => 'form.lastName',
            ])
            ->add('phoneNumber', TextType::class, [
                'required' => false,
                'label' => 'form.phoneNumber',
            ])
            ->add('username', TextType::class, [
                'required' => false,
                'label' => 'form.username',
            ])
            ->add('gender', EntityType::class, [
                'class' => Gender::class,
                'choice_label' => 'name',
                'required' => false,
                'choice_translation_domain' => true,
                'placeholder' => 'Sexe'
            ])
            ->add('bornAt', TextType::class, [
                'required' => false,
                'label' => 'form.bornAt',
            ])
            ->add('birthPlace', TextType::class, [
                'required' => false,
                'label' => 'form.birthPlace',
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'form.description',
            ])
            ->add('avatar', UserAvatarType::class, [
                'required' => false,
            ])
        ;

        $builder->get('bornAt')
            ->addModelTransformer(new CallbackTransformer(
                function ($bornAtAsDate) {
                    return $bornAtAsDate ? $bornAtAsDate->format('d/m/Y') : '';
                },

                function ($bornAtAsString) {
                    if (empty($bornAtAsString)) {
                        return null;
                    }

                    return \DateTime::createFromFormat('d/m/Y', $bornAtAsString);
                }
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
