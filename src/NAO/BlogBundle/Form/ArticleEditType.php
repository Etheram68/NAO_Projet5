<?php
/**
 * Created by PhpStorm.
 * User: Arak
 * Date: 18/07/2018
 * Time: 21:18
 */

namespace NAO\BlogBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ArticleEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('date');
    }

    public function getParent()
    {
        return ArticleType::class;
    }

}