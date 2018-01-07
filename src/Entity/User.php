<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Grade", mappedBy="owner", cascade={"remove"})
     * @var ArrayCollection
     */
    protected $grades;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Subject", inversedBy="teachers")
     * @var ArrayCollection
     *
     * @ORM\JoinTable(name="teachers")
     */
    protected $taughtSubjects;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Subject", inversedBy="students")
     * @var ArrayCollection
     *
     * @ORM\JoinTable(name="students")
     */
    protected $learnedSubjects;

    /**
     * @return mixed
     */
    public function getGrades()
    {
        return $this->grades;
    }

    /**
     * @param mixed $grades
     */
    public function setGrades($grades): void
    {
        $this->grades = $grades;
    }

    /**
     * @return mixed
     */
    public function getTaughtSubjects()
    {
        return $this->taughtSubjects;
    }

    /**
     * @param mixed $taughtSubjects
     */
    public function setTaughtSubjects($taughtSubjects): void
    {
        $this->taughtSubjects = $taughtSubjects;
    }

    /**
     * @return mixed
     */
    public function getLearnedSubjects()
    {
        return $this->learnedSubjects;
    }

    /**
     * @param mixed $learnedSubjects
     */
    public function setLearnedSubjects($learnedSubjects): void
    {
        $this->learnedSubjects = $learnedSubjects;
    }

    //--------------------------------------  adders and removers ----------------------------------------------------//

    /**
     * @param mixed $grade
     */
    public function addGrade($grade)
    {
        $this->grades->add($grade);
        // uncomment if you want to update other side
        //$grade->setUser($this);
    }

    /**
     * @param Subject $taughtSubject
     */
    public function addTaughtSubject($taughtSubject)
    {
        $this->taughtSubjects->add($taughtSubject);
        // uncomment if you want to update other side
        //$taughtSubject->addTeacher($this);
    }

    /**
     * @param mixed $taughtSubject
     */
    public function removeTaughtSubject($taughtSubject)
    {
        $this->taughtSubjects->removeElement($taughtSubject);
        // uncomment if you want to update other side
        //$taughtSubject->setUser(null);
    }

    /**
     * @param mixed $learnedSubject
     */
    public function addLearnedSubject($learnedSubject)
    {
        $this->learnedSubjects->add($learnedSubject);
        // uncomment if you want to update other side
        //$learnedSubject->setUser($this);
    }

    /**
     * @param mixed $learnedSubject
     */
    public function removeLearnedSubject($learnedSubject)
    {
        $this->learnedSubjects->removeElement($learnedSubject);
        // uncomment if you want to update other side
        //$learnedSubject->setUser(null);
    }


}
