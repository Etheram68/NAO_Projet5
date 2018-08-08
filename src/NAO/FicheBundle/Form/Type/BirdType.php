<?php

namespace NAO\FicheBundle\Form\Type;

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

class BirdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('size', TextType::class, array(
                'required'       => false,
                'label'          => 'Taille'
            ))
            ->add('weight', TextType::class, array(
                'required'       => false,
                'label'          => 'Poids'
            ))
            ->add('color',TextType::class, array(
                'required'       => false,
                'label'          => 'Principal Couleur'
            ))
            ->add('feature', TextareaType::class, array(
                'required'       => false,
                'label'          => 'Information complémentaire'
            ))
            ->add('taxref', TaxrefType::class)
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
        return 'bird_form';
    }
}