<?php

namespace App\Form;

use App\Entity\Candidate;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        // Texts 
            ->add('firstName', TextType::class)

            ->add('lastName', TextType::class)

            ->add('address', TextType::class)

            ->add('country', TextType::class)

            ->add('nationality', TextType::class)

            ->add('currentLocation', TextType::class)

            ->add('placeOfBirth', TextType::class)

            ->add('shortDescription', TextType::class)

        // 

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
        ]);
    }
}
