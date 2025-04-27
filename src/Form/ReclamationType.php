<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints as Assert;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Email cannot be empty.']),
                    new Assert\Email(['message' => 'Please enter a valid email address.']),
                ],
            ])
            ->add('evenement', EntityType::class, [
                'class' => Evenement::class,
                'choice_label' => 'titre', // ✅ Changed from 'nom' to 'titre'
                'required' => true,
            ])
            ->add('subject', TextareaType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Subject cannot be empty.']),
                    new Assert\Length([
                        'max' => 255,
                        'maxMessage' => 'Subject cannot exceed {{ limit }} characters.',
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 4,
                    'id' => 'reclamation_subject',  // Change the id here
                ],
            ])
            
            ->add('rate', IntegerType::class, [
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Rate cannot be empty.']),
                    new Assert\Range([
                        'min' => 1,
                        'max' => 5,
                        'notInRangeMessage' => 'Rate should be between {{ min }} and {{ max }}.',
                    ])
                ],
                'attr' => [
                    'min' => 1,
                    'max' => 5,
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}