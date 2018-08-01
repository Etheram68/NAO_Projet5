<?php

namespace NAO\MapBundle\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CityCheckValidator extends ConstraintValidator
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function validate($city, Constraint $constraint)
    {
        $region     = explode(' (', $city);
        $cityName   = isset($region[0]) ? trim($region[0]) : null;

        if(!empty($city) && !is_null($cityName)){
            $city = $this->em->getRepository('NAOMapBundle:FranceRegion')->findOneBy(array('city' => $cityName));
            if(!$city) {
                $this->context->buildViolation($constraint->message)->addViolation();
            }
        }else{
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}