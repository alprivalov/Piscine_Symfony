<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                ->add('username',TextType::class, [
                    'label' => 'Username',
                    'required'=> true,
                    'constraints'=>[ 
                        new Assert\NotBlank(['message'=> 'Username obligatoire']),
                    ]
                ])
                ->add('name',TextType::class, [
                    'label' => 'Name',
                    'required'=> true,
                    'constraints'=>[ 
                        new Assert\NotBlank(['message'=> 'Name obligatoire']),
                    ]
                ])
                ->add('email',EmailType::class, [
                    'label' => 'Email',
                    'required'=> true,
                    'constraints'=>[
                        new Assert\Email(['message'=> 'Error']),
                        new Assert\NotBlank(['message' => 'Email obligatoire']),
                    ]
                ])

                ->add('enable',CheckboxType::class, [
                    'label' => 'Enable',
                    'required'=> true,
                ])
                ->add('birthdate',DateType::class, [
                    'label' => 'Birthdate',
                    'required'=> true,
                    'constraints'=>[ new Assert\NotBlank(['message'=> 'Birthdate obligatoire'])]
                ])
                ->add('address',TextType::class, [
                    'label' => 'Address',
                    'required'=> true,
                    'constraints'=>[ new Assert\NotBlank(['message'=> 'Address obligatoire'])]
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            // Configure your form options here
        ]);
    }
}
