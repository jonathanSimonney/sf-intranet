<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as CustomAssert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GradeRepository")
 * @CustomAssert\hasOwnerAndSubjectCoherent
 */
class Grade
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     *
     * @Assert\Range(
     *      min = 0,
     *      max = 20,
     *      invalidMessage="You must enter a grade between 0 and 20"
     * )
     *
     * @var int
     * @ORM\Column(type="integer")
     */
    private $value;

    /**
     * @var string
     *
     * @Assert\NotNull()
     * @ORM\Column(type="string")
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="grades")
     */
    private $owner;

    /**
    * @ORM\ManyToOne(targetEntity="App\Entity\User")
    */
    private $givenBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Subject", inversedBy="grades")
     */
    private $subject;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getGivenBy()
    {
        return $this->givenBy;
    }

    /**
     * @param mixed $givenBy
     */
    public function setGivenBy($givenBy): void
    {
        $this->givenBy = $givenBy;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }

    public function __toString()
    {
        return $this->value.'/20';
    }
}
