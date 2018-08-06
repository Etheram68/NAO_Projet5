<?php

namespace NAO\MapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use NAO\MapBundle\Validator\BirdCheck;
use Symfony\Component\Validator\Constraints\File;

class RejectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reason', TextareaType::class,
                [
                    'label'         => ' ',
                    'attr'          => array( 'class' => 'materialize-textarea '),
                    'required'      => true
                ]
            )
            ->add('warn_admin', CheckboxType::class,
                [
                    'mapped'    => true,
                    'label'     => false,
                    'required' => false,
                    'attr'  => array( 'class' => 'filled-in')
                ]
            )
            ->add('cancel', ResetType::class,
                [
                    'attr' => array('class' => 'btn white waves-effect'),
                    'label' => 'cancel',
                    'translation_domain' => 'messages',
                ]
            )
            ->add('confirm', SubmitType::class,
                [
                    'attr' => array('class' => 'btn waves-effect modal-trigger', 'href' => '#action-reject'),
                    'label' => 'confirm',
                    'translation_domain' => 'messages',
                ]
            );
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