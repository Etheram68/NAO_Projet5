<?php

namespace NAO\MapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\File;

class ObservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('place', TextType::class, array(
                'attr'  => array( 'class' => 'autocomplete'),
            ))
            ->add('latitude', HiddenType::class)
            ->add('longitude', HiddenType::class)
            ->add('watched', DateTimeType::class, array(
                'attr'      => array( 'class' => 'datepicker', 'autocomplete' => 'off', 'readonly' => true),
                'widget'    => 'single_text',
                'format'    => 'dd/MM/yyyy',
                'with_seconds'  => false,
                'with_minutes'  => false,
            ))
            ->add('taxref', TaxrefType::class)
            ->add('individuals', ChoiceType::class, array(
                'attr'  => array( 'class' => '', 'autocomplete' => 'off'),
                'choice_translation_domain' => false,
                'choices'  => array(
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    5 => 5,
                    6 => 6,
                    7 => 7,
                    8 => 8,
                    9 => 9,
                    '10+' => 10,
                ),
            ))
            ->add('comments', TextareaType::class, array(
                'attr'          => array( 'class' => 'materialize-textarea '),
                'required'      => false
            ))
            ->add('imagepath', FileType::class, array(
                'label'         => false,
                'mapped'        => false,
                'data_class'    => null,
                'required'      => false,
                'attr'          => array('class' => 'upload'),
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/gif',
                            'image/png'
                        ],
                        'mimeTypesMessage'  => 'avatar_format',
                        'maxSizeMessage'    => 'avatar_size',
                    ])
                ]
            ))
            ->add('save_draft', SubmitType::class,
                [
                    'attr' => array('class' => 'btn waves-effect white min-pad'),
                    'label' => 'Sauvegarder le brouillon',
                    'translation_domain' => 'messages',
                ]
            )
            ->add('save_published', SubmitType::class,
                [
                    'attr' => array('class' => 'btn waves-effect min-pad'),
                    'label' => 'Soumettre l\'observation',
                    'translation_domain' => 'messages',
                ]
            )
        ;
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'error_bubbling' => true
        ));
    }

    public function getName()
    {
        return 'observation_form';
    }
}