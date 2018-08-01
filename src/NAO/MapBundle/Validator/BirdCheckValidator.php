<?php
namespace NAO\MapBundle\Validator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
class BirdCheckValidator extends ConstraintValidator
{
    protected $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public function validate($name, Constraint $constraint)
    {
        $latin_name = substr($name, ($p = strpos($name, '(')+1), strrpos($name, ')')-$p);
        $bird = $this->em->getRepository('NAOMapBundle:Taxref')->findOneBy(array('taxon_sc' => $latin_name));
        if(!$bird || empty(trim($name))) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}