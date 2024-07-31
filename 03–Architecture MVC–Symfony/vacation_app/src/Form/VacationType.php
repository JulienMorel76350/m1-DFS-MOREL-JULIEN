<?php

namespace App\Form;

use App\Entity\Vacation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VacationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Start Date',
            ])
            ->add('endDate', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'End Date',
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'RTT' => 'RTT',
                    'CP' => 'CP',
                    'Exceptional Leave' => 'Exceptional Leave',
                ],
                'label' => 'Type',
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Requested' => 'Requested',
                    'Validated' => 'Validated',
                    'Refused' => 'Refused',
                    'Cancelled' => 'Cancelled',
                ],
                'label' => 'Status',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Submit Vacation Request',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vacation::class,
        ]);
    }
}
