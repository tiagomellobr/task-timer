<?php

namespace App\Form;

use App\Entity\Timer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TimerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('task', EntityType::class, [
                'class' => 'App\Entity\Task',
                'choice_label' => 'title',
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('startRecord', DateTimeType::class, [
                'required' => true,
                'label' => false,
                'widget'=>'single_text',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Start Date Time*'
                ]
            ])
            ->add('endRecord', DateTimeType::class, [
                'required' => false,
                'label' => false,
                'widget'=>'single_text',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'End Date Time'
                ]
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary btn-block'
                ]
            ])            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Timer::class,
        ]);
    }
}
