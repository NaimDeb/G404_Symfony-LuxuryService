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
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;

class CandidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        // Texts 
            ->add('firstName', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'first_name',
                ],
                'label' => 'First name',
            ])

            ->add('lastName', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'last_name',
                ],
                'label' => 'Last name',
            ])

            ->add('address', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'address',
                ],
                'label' => 'Address',
            ])

            ->add('country', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'country',
                ],
                'label' => 'Country',
            ])

            ->add('nationality', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'nationality',
                ],
                'label' => 'Nationality',
            ])

            ->add('currentLocation', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'current_location',
                ],
                'label' => 'Current location',
            ])

            ->add('placeOfBirth', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'place_of_birth',
                ],
                'label' => 'Place of birth',
            ])

            ->add('shortDescription', TextType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'short_description',
                ],
                'label' => 'Short description',
            ])

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
                'attr' => [
                    'id' => 'gender'
                ],
                'label' => 'Gender',
                'label_attr' => [ 'class' => 'active'],
                'placeholder' => 'Choose your gender...',
            ])

            ->add('jobCategory', EntityType::class, [
                'class' => JobCategory::class,
                'placeholder' => 'Choose the sector you work in...',
                'required' => false,
                'attr' => [
                    'id' => 'job_sector'
                ],
                'label' => 'Interest in job sector',
                'label_attr' => [ 'class' => 'active'],
                'placeholder' => 'Choose an option...'
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
                'mapped' => false,
                'required' => false,
                'constraints' => [
                        new File([
                        'maxSize' => '20M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF or image',
                    ])
                ],
                'attr' => [
                    'accept' => '.jpg,.jpeg,.png,.gif,.pdf',
                    'id' => 'cv',
                ]
            ])
            
            ->add('curriculumVitaeFile', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '20M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF or image',
                    ])
                ],
                'attr' => [
                    'accept' => '.jpg,.jpeg,.png,.gif,.pdf',
                    'id' => 'cv',
                ]
            ])

            ->add('profilePictureFile', FileType::class,[
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '20M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image document',
                    ])
                ],
                'attr' => [
                    'accept' => '.jpg,.jpeg,.png,.gif',
                    'id' => 'photo',
                ]
                ])

            // Account


            ->add('email', EmailType::class, [
                'required' => false,
                'mapped' => false,
                'label' => 'Email',
                'attr' => [
                    'id' => 'email',
                    'class' => 'form-control',
                ],
            ])
            ->add('newPassword', RepeatedType::class, [
                'mapped' => false,
                'required' => false,
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'New Password',
                    'attr' => [
                        'class' => 'form-control',
                        'id' => 'password',
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirm New Password',
                    'attr' => [
                        'class' => 'form-control',
                        'id' => 'password_repeat',
                    ],
                ],
                'invalid_message' => 'The password fields must match.',
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
            ])






            // UpdatedAt eventlistener
            ->addEventListener(FormEvents::POST_SUBMIT, $this->setUpdatedAt(...));
            

        // 

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
        ]);
    }

    private function setUpdatedAt(FormEvent $event): void
    {
        $candidate = $event->getData();
        if ($candidate instanceof Candidate) {
            $candidate->setUpdatedAt(new \DateTimeImmutable());
        }
    }


}
