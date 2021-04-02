<?php

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="project")
 */
class Project
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /** 
     * @ORM\Column(type="string") 
     */
    protected $name;
    /**
     * @ORM\OneToMany(targetEntity="Student", mappedBy="project", cascade={"remove", "persist"})
     */
    private $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function addStudent(Student $student)
    {
        $this->students[] = $student;
        $student->setProject($this);
    }
    public function remStudent(Student $student) {
        $this->student->removeElement($student);
    }
    public function getStudents()
    {
        return $this->students;
    }
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}
