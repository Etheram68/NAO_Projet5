<?php
namespace NAO\MapBundle\Validator;
use Symfony\Component\Validator\Constraint;
/**
 * @Annotation
 */
class CityCheck extends Constraint
{
    public $message  = "city.wrong";
    public function validatedBy()
    {
        return 'app.city.check';
    }
}