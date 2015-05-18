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
     * @ORM\ManyToOne(targetEntity="SchoolLocation", inversedBy="courses")
     * @Assert\NotNull()
     */
    protected $schoolLocation;
    
    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\Language")
     */
    protected $language ;
    
    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\Program")
     */
    protected $program ;
    
    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\SubjectSchoolLocation")
     */
    protected $subject ;
    
    /**
     * @ORM\OneToMany(targetEntity="StartDate", mappedBy="course")
     * @ORM\OrderBy({"date" = "ASC"})
     */
    protected $startDates;
    
    /**
     * @ORM\OneToMany(targetEntity="Price", mappedBy="course")
     * @ORM\OrderBy({"weekStart" = "ASC"})
     */
    protected $prices;
    
    /**
     * @ORM\OneToMany(targetEntity="PathwayPrice", mappedBy="course")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    protected $pathwayPrices;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text",nullable=true)
     */
    private $description;

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

    /**
     * Add prices
     *
     * @param \Back\SchoolBundle\Entity\Price $prices
     * @return Course
     */
    public function addPrice(\Back\SchoolBundle\Entity\Price $prices)
    {
        $this->prices[] = $prices;

        return $this;
    }

    /**
     * Remove prices
     *
     * @param \Back\SchoolBundle\Entity\Price $prices
     */
    public function removePrice(\Back\SchoolBundle\Entity\Price $prices)
    {
        $this->prices->removeElement($prices);
    }

    /**
     * Get prices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPrices()
    {
        return $this->prices;
    }
    
    public function __toString()
    {
        if($this->schoolLocation->getType()==1)
            return $this->name;
        else
            return $this->subject->getName();
    }

    /**
     * Set schoolLocation
     *
     * @param \Back\SchoolBundle\Entity\SchoolLocation $schoolLocation
     * @return Course
     */
    public function setSchoolLocation(\Back\SchoolBundle\Entity\SchoolLocation $schoolLocation = null)
    {
        $this->schoolLocation = $schoolLocation;

        return $this;
    }

    /**
     * Get schoolLocation
     *
     * @return \Back\SchoolBundle\Entity\SchoolLocation 
     */
    public function getSchoolLocation()
    {
        return $this->schoolLocation;
    }

    /**
     * Add pathwayPrices
     *
     * @param \Back\SchoolBundle\Entity\PathwayPrice $pathwayPrices
     * @return Course
     */
    public function addPathwayPrice(\Back\SchoolBundle\Entity\PathwayPrice $pathwayPrices)
    {
        $this->pathwayPrices[] = $pathwayPrices;

        return $this;
    }

    /**
     * Remove pathwayPrices
     *
     * @param \Back\SchoolBundle\Entity\PathwayPrice $pathwayPrices
     */
    public function removePathwayPrice(\Back\SchoolBundle\Entity\PathwayPrice $pathwayPrices)
    {
        $this->pathwayPrices->removeElement($pathwayPrices);
    }

    /**
     * Get pathwayPrices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPathwayPrices()
    {
        return $this->pathwayPrices;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Course
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set subject
     *
     * @param \Back\ReferentielBundle\Entity\SubjectSchoolLocation $subject
     * @return Course
     */
    public function setSubject(\Back\ReferentielBundle\Entity\SubjectSchoolLocation $subject = null)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return \Back\ReferentielBundle\Entity\SubjectSchoolLocation 
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
