<?php
/**
 * Created by PhpStorm.
 * User: Arak
 * Date: 23/07/2018
 * Time: 20:50
 */

namespace NAO\BlogBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('date');
    }
    public function getParent()
    {
        return CommentType::class;
    }
}