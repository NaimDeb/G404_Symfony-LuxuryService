<?php

namespace App\Form;

use App\DTO\ContactDTO;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'First name',
            ])
            ->add('lastName', TextType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Last name',
            ])
            ->add('email', EmailType::class, [
                'empty_data' => '',
                'required' => true,
                'label' => 'Email',
            ])
            ->add('phoneNumber', TextType::class, [
                'empty_data' => '',
                'required' => false,
                'label' => 'Phone number',
            ])
            ->add('message', TextareaType::class, [
                'empty_data' => '',
                'required' => true,
                'attr' => [

                    'class' => 'materialize-textarea',
                    'name' => 'message',
                    'cols' => '50',
                    'rows' => '10',
                ],
                'label' => 'Leave us a message',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactDTO::class,
        ]);
    }
}
