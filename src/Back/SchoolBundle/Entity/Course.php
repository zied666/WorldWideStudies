<?php

namespace Back\SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Course
 *
 * @ORM\Table(name="wws_course")
 * @ORM\Entity
 */
class Course
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="School", inversedBy="courses")
     * @Assert\NotNull()
     */
    protected $school;
    
    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\Language")
     */
    protected $language ;
    
    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\Program")
     */
    protected $program ;
    
    /**
     * @ORM\OneToMany(targetEntity="StartDate", mappedBy="course")
     */
    protected $startDates;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Course
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set school
     *
     * @param \Back\SchoolBundle\Entity\School $school
     * @return Course
     */
    public function setSchool(\Back\SchoolBundle\Entity\School $school = null)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return \Back\SchoolBundle\Entity\School 
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set language
     *
     * @param \Back\ReferentielBundle\Entity\Language $language
     * @return Course
     */
    public function setLanguage(\Back\ReferentielBundle\Entity\Language $language = null)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \Back\ReferentielBundle\Entity\Language 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set program
     *
     * @param \Back\ReferentielBundle\Entity\Program $program
     * @return Course
     */
    public function setProgram(\Back\ReferentielBundle\Entity\Program $program = null)
    {
        $this->program = $program;

        return $this;
    }

    /**
     * Get program
     *
     * @return \Back\ReferentielBundle\Entity\Program 
     */
    public function getProgram()
    {
        return $this->program;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->startDates = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add startDates
     *
     * @param \Back\SchoolBundle\Entity\StartDate $startDates
     * @return Course
     */
    public function addStartDate(\Back\SchoolBundle\Entity\StartDate $startDates)
    {
        $this->startDates[] = $startDates;

        return $this;
    }

    /**
     * Remove startDates
     *
     * @param \Back\SchoolBundle\Entity\StartDate $startDates
     */
    public function removeStartDate(\Back\SchoolBundle\Entity\StartDate $startDates)
    {
        $this->startDates->removeElement($startDates);
    }

    /**
     * Get startDates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStartDates()
    {
        return $this->startDates;
    }
}
