<?php

namespace App\Form;

use App\Entity\Link;
use App\Entity\LinkCategory;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];
        if(!$user) {
            throw new \Exception("The user must be logged in");
        }

        $builder
            ->add('linkCategory', EntityType::class, [
                'class' => LinkCategory::class,
                'choice_label' => 'name',
                'choice_translation_domain' => true,
                'query_builder' => function(EntityRepository $er) use($user) {
                    return $er->createQueryBuilder('l')
                        ->where('l.gender = :gender')
                        ->setParameter('gender', $user->getGender())
                    ;
                }
            ])
            ->add('inverse', LinkedUserType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Link::class,
            'user' => null
        ]);
    }
}
