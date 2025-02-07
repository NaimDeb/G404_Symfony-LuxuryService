<?php

namespace App\Form;

use App\Entity\Candidate;
use App\Entity\Gender;
use App\Entity\JobCategory;
use App\Entity\User;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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

            // Bool
            ->add('availibility', CheckboxType::class, [
                'required' => false,
                'label' => 'Available for work ?',
            ])

            // Dates

            ->add('birthDate', DateType::class, ['required' => false, 'attr' => [
                'class' => 'datepicker'
                ]])


            // Lists of other classes

            ->add('gender', EntityType::class, [
                'class' => Gender::class,
                'placeholder' => 'Choose your gender...',
                'required' => false,
            ])

            ->add('jobCategory', EntityType::class, [
                'class' => JobCategory::class,
                'placeholder' => 'Choose the sector you work in...',
            ])

            // Choices

            ->add('experience', ChoiceType::class, [
                'choices' => [
                    '0 - 6 month' => '0 - 6 month',
                    '6 month - 1 year' => '6 month - 1 year',
                    '1 - 2 years' => '1 - 2 years',
                    '2+ years' => '2+ years',
                    '5+ years' => '5+ years',
                    '10+ years' => '10+ years',
                ]])


            // Files


            ->add('passportFile', FileType::class, [
                'required' => false,
            ])
            
            ->add('curriculumVitaeFile', FileType::class, [
                'required' => false,
            ])

            ->add('profilePictureFile', FileType::class, [
                'required' => false,
            ])
            

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
