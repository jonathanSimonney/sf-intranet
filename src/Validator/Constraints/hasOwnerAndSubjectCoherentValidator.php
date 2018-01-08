<?php

namespace App\Validator\Constraints;


use App\Entity\Grade;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class hasOwnerAndSubjectCoherentValidator extends ConstraintValidator
{
    /**
     * @param Grade $grade
     * @param Constraint $constraint
     */
    public function validate($grade, Constraint $constraint)
    {
        $studentLearnedSubject = $grade->getOwner()->getLearnedSubjects();
        $gradeSubject = $grade->getSubject();
        /** @var $studentLearnedSubject ArrayCollection */
        if (!$studentLearnedSubject->contains($gradeSubject)) {
            $this->context->buildViolation($constraint->message)
                ->atPath('owner')
                ->addViolation();
        }
    }
}