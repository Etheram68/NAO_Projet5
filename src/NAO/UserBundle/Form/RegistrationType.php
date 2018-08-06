<?php

namespace NAO\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        ->add('lastname', TextType::class, array(
            'attr' => array('placeholder' => 'Entrez votre nom'),
        ))
        ->add('firstname', TextType::class, array(
            'attr' => array('placeholder' => 'Entrez votre prénom'),
        ))
        ->add('username', TextType::class, array(
            'attr' => array('placeholder' => 'Choississez un pseudonyme'),
        ))
        ->add('email', EmailType::class, array(
            'attr' => array('placeholder' => 'Entrez votre email'),
        ))
        ->add('town', TextType::class, array(
            'attr' => array('placeholder' => 'Entrez votre ville'),
        ))
        ->add('presentation', TextareaType::class, array(
            'attr' => array('placeholder' => 'Décrivez vous en quelques mots…'),
        ))
        ->add('newsletter', CheckboxType::class, array('required' => false))
        ->add('rgpd', CheckboxType::class)

        ->add('plainPassword', RepeatedType::class, array(
            'type' => PasswordType::class,
            'options' => array(
                'translation_domain' => 'FOSUserBundle',
                'attr' => array(
                    'autocomplete' => 'new-password',
                ),
            ),
            'first_options' => array('label' => 'form.password'),
            'second_options' => array('label' => 'form.password_confirmation'),
            'invalid_message' => 'fos_user.password.mismatch',
        ))
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'nao_user_registration';
    }


}
