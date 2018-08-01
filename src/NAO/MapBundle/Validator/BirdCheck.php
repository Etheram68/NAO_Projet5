<?php

namespace NAO\MapBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class BirdCheck extends Constraint
{
    public $message  = "bird.wrong";
    public function validatedBy()
    {
        return 'app.bird.check';
    }
}