<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Eventspeaker;
use App\Repository\EventspeakerRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentSpeakerId = $options['currentSpeakerId'];
        $minDate = (new \DateTime('now'))->modify('+2 days')->setTime(0, 0); // Surlendemain à 00:00

        $builder
            ->add('titre')
            ->add('description')
            ->add('dateEvent', null, [
                'widget' => 'single_text',
                'attr' => [
                    'min' => $minDate->format('Y-m-d\TH:i'), // Désactive les dates avant le surlendemain
                ],
            ])
            ->add('lieu')
            ->add('nbPlace')
            ->add('prix')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'En cours' => 'en_cours',
                    'Dépassé' => 'depasse',
                    'Reporté' => 'reporte',
                ],
                'label' => 'Statut',
                'placeholder' => 'Sélectionner un statut', // Optional: empty option
                'required' => true, // Adjust based on your needs
                'attr' => ['class' => 'form-select'], // Consistent styling with other select boxes
            ])
            ->add('eventspeakerId', EntityType::class, [
                'class' => Eventspeaker::class,
                'choice_label' => function (Eventspeaker $speaker) {
                    return $speaker->getNom() . ' ' . $speaker->getPrenom();
                },
                'label' => 'Orateur',
                'required' => true,
                'placeholder' => false,
                'query_builder' => function (EventspeakerRepository $er) use ($currentSpeakerId) {
                    $qb = $er->createQueryBuilder('e')
                        ->orderBy('e.nom', 'ASC');
                    if ($currentSpeakerId) {
                        $qb->where('e.status = :status OR e.id = :currentSpeakerId')
                           ->setParameter('status', 'dispo')
                           ->setParameter('currentSpeakerId', $currentSpeakerId);
                    } else {
                        $qb->where('e.status = :status')
                           ->setParameter('status', 'dispo');
                    }
                    return $qb;
                },
                'attr' => ['class' => 'form-select'],
            ])
            ->add('img', FileType::class, [
                'label' => 'Image',
                'required' => false, // Optional: allow no file upload
                'mapped' => false, // Optional: if img is a string in entity, not a file
                'attr' => [
                    'class' => 'form-control-file', // For Bootstrap custom file input
                    'accept' => 'image/*', // Restrict to image files
                ],
            ])
            ->add('syncWithGoogle', CheckboxType::class, [
                'label' => 'Synchroniser avec Google Calendar',
                'required' => false,
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
            'currentSpeakerId' => null, // Define the custom option
        ]);

        $resolver->setAllowedTypes('currentSpeakerId', ['null', 'int']); // Allow null or integer
    }
}