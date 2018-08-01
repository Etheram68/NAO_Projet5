<?php

namespace NAO\MapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObservationChoiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reject', ResetType::class,
                [
                    'attr' => array('class' => 'btn white waves-effect'),
                    'label' => 'reject',
                    'translation_domain' => 'messages',
                ]
            )
            ->add('validate', SubmitType::class,
                [
                    'attr' => array('class' => 'btn waves-effect confirm modal-trigger', 'href' => '#action-validate'),
                    'label' => 'validate',
                    'translation_domain' => 'messages',
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }
}