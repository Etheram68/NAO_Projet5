<?php

namespace NAO\MapBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use NAO\MapBundle\Validator\BirdCheck;

class TaxrefType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('customname', TextType::class, array(
                'attr'      => array( 'class' => '', 'autocomplete' => 'off'),
                'label'     => false,
                'constraints' => [
                    new BirdCheck()
                ]
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'NAO\MapBundle\Entity\Taxref',
        ));
    }
}