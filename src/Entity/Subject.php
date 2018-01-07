<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubjectRepository")
 * @UniqueEntity("name")
 */
class Subject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotNull()
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Grade", mappedBy="subject", cascade={"remove"})
     *
     * @var ArrayCollection
     */
    protected $grades;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="taughtSubjects")
     *
     * @var ArrayCollection
     * @ORM\JoinTable(name="teachers")
     */
    protected $teachers;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="learnedSubjects")
     *
     * @ORM\JoinTable(name="students")
     * @var ArrayCollection
     */
    protected $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->teachers = new ArrayCollection();
        $this->grades = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection
     */
    public function getGrades(): ArrayCollection
    {
        return $this->grades;
    }

    /**
     * @param ArrayCollection $grades
     */
    public function setGrades(ArrayCollection $grades): void
    {
        $this->grades = $grades;
    }

    /**
     * @return ArrayCollection
     */
    public function getTeachers(): ArrayCollection
    {
        return $this->teachers;
    }

    /**
     * @param ArrayCollection $teachers
     */
    public function setTeachers(ArrayCollection $teachers): void
    {
        $this->teachers = $teachers;
    }

    /**
     * @return ArrayCollection
     */
    public function getStudents(): ArrayCollection
    {
        return $this->students;
    }

    /**
     * @param ArrayCollection $students
     */
    public function setStudents(ArrayCollection $students): void
    {
        $this->students = $students;
    }

    //--------------------------------------  adders and removers ----------------------------------------------------//

    /**
     * @param Grade $grade
     */
    public function addGrade($grade)
    {
        $this->grades->add($grade);
        // uncomment if you want to update other side
        //$grade->setSubject($this);
    }

    /**
     * @param User $teacher
     */
    public function addTeacher($teacher)
    {
        $this->teachers->add($teacher);
        // uncomment if you want to update other side
        //$teacher->addTaughtSubject($this);
    }

    /**
     * @param User $teacher
     */
    public function removeTeacher($teacher)
    {
        $this->teachers->removeElement($teacher);
        // uncomment if you want to update other side
        //$teacher->removeTaughtSubject($this);
    }

    /**
     * @param User $student
     */
    public function addStudent($student)
    {
        $this->students->add($student);
        // uncomment if you want to update other side
        //$student->addLearnedSubject($this);
    }

    /**
     * @param User $student
     */
    public function removeStudent($student)
    {
        $this->students->removeElement($student);
        // uncomment if you want to update other side
        //$student->removeLearnedSubject($this);
    }
}
