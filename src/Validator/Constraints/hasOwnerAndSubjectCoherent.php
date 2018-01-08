<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class hasOwnerAndSubjectCoherent extends Constraint
{
    public $message = "You shouldn't be able to add a user with a subject which is not his. Please change the user or the subject.";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}