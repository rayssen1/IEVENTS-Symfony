<?php

namespace App\Form;

use App\Entity\Reponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Message cannot be empty.',
                    ]),
                    new Assert\Length([
                        'max' => 200,
                        'maxMessage' => 'Message must not exceed 200 characters.',
                    ]),
                ],
                'attr' => [
                    'maxlength' => 200,
                    'class' => 'form-control',
                    'placeholder' => 'Enter your message (max 200 characters)',
                ],
            ])
            ->add('email', EmailType::class, [
                'mapped' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Email is required.',
                    ]),
                    new Assert\Email([
                        'message' => 'Please enter a valid email address.',
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'e.g., user@mail.com',
                ],
            ])
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'TREATED' => 'TREATED',
                    'IN_PROGRESS' => 'IN_PROGRESS',
                    'NOT_TREATED' => 'NOT_TREATED',
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('dateRep', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reponse::class,
        ]);
    }
}
