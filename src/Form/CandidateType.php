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
            ->add('firstName', TextType::class, ['required' => false])

            ->add('lastName', TextType::class, ['required' => false])

            ->add('address', TextType::class, ['required' => false])

            ->add('country', TextType::class, ['required' => false])

            ->add('nationality', TextType::class, ['required' => false])

            ->add('currentLocation', TextType::class, ['required' => false])

            ->add('placeOfBirth', TextType::class, ['required' => false])

            ->add('shortDescription', TextType::class, ['required' => false])

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
