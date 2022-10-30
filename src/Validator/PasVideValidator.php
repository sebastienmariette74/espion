<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasVideValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var App\Validator\PasVide $constraint */
        /* @var App\Entity\Mission $values */
        $values = $this->context->getRoot()->getData();
        $codeName = $values->getCodeName();
        dd($values);

        if (null === $codeName || '' === $codeName) {
            $this->context->buildViolation($constraint->message)
            // ->setParameter('{{ value }}', $value)
            ->addViolation();
        }


        // TODO: implement the validation here
        
    }
}
