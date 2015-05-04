<?php

namespace Back\UniversityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CourseTitle
 *
 * @ORM\Table(name="wws_course_title")
 * @ORM\Entity
 */
class CourseTitle
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=11, scale=3)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="string", length=255)
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="deadLine", type="string", length=255)
     */
    private $deadLine;

    /**
     * @ORM\OneToMany(targetEntity="StartDate", mappedBy="courseTitle")
     * @ORM\OrderBy({"date" = "ASC"})
     */
    protected $startDates;

    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\Subject")
     */
    protected $subject;

    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\Qualification")
     */
    protected $qualification;

    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\StudyMode")
     */
    protected $studyMode;

    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\Level")
     */
    protected $level;

    /**
     * @ORM\ManyToOne(targetEntity="University", inversedBy="courseTitles")
     */
    protected $university;

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
     * Set description
     *
     * @param string $description
     * @return CourseTitle
     */
    public function setDescription($description)
    {
        $this->description=$description;

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
     * Set price
     *
     * @param string $price
     * @return CourseTitle
     */
    public function setPrice($price)
    {
        $this->price=$price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return number_format($this->price, 2, '.', '');
    }

    /**
     * Set duration
     *
     * @param string $duration
     * @return CourseTitle
     */
    public function setDuration($duration)
    {
        $this->duration=$duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return string 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set deadLine
     *
     * @param string $deadLine
     * @return CourseTitle
     */
    public function setDeadLine($deadLine)
    {
        $this->deadLine=$deadLine;

        return $this;
    }

    /**
     * Get deadLine
     *
     * @return string 
     */
    public function getDeadLine()
    {
        return $this->deadLine;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->startDates=new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add startDates
     *
     * @param \Back\UniversityBundle\Entity\StartDate $startDates
     * @return CourseTitle
     */
    public function addStartDate(\Back\UniversityBundle\Entity\StartDate $startDates)
    {
        $this->startDates[]=$startDates;

        return $this;
    }

    /**
     * Remove startDates
     *
     * @param \Back\UniversityBundle\Entity\StartDate $startDates
     */
    public function removeStartDate(\Back\UniversityBundle\Entity\StartDate $startDates)
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
     * Set subject
     *
     * @param \Back\ReferentielBundle\Entity\Subject $subject
     * @return CourseTitle
     */
    public function setSubject(\Back\ReferentielBundle\Entity\Subject $subject=null)
    {
        $this->subject=$subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return \Back\ReferentielBundle\Entity\Subject 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set qualification
     *
     * @param \Back\ReferentielBundle\Entity\Qualification $qualification
     * @return CourseTitle
     */
    public function setQualification(\Back\ReferentielBundle\Entity\Qualification $qualification=null)
    {
        $this->qualification=$qualification;

        return $this;
    }

    /**
     * Get qualification
     *
     * @return \Back\ReferentielBundle\Entity\Qualification 
     */
    public function getQualification()
    {
        return $this->qualification;
    }

    /**
     * Set studyMode
     *
     * @param \Back\ReferentielBundle\Entity\StudyMode $studyMode
     * @return CourseTitle
     */
    public function setStudyMode(\Back\ReferentielBundle\Entity\StudyMode $studyMode=null)
    {
        $this->studyMode=$studyMode;

        return $this;
    }

    /**
     * Get studyMode
     *
     * @return \Back\ReferentielBundle\Entity\StudyMode 
     */
    public function getStudyMode()
    {
        return $this->studyMode;
    }

    /**
     * Set level
     *
     * @param \Back\ReferentielBundle\Entity\Level $level
     * @return CourseTitle
     */
    public function setLevel(\Back\ReferentielBundle\Entity\Level $level=null)
    {
        $this->level=$level;

        return $this;
    }

    /**
     * Get level
     *
     * @return \Back\ReferentielBundle\Entity\Level 
     */
    public function getLevel()
    {
        return $this->level;
    }


    /**
     * Set university
     *
     * @param \Back\UniversityBundle\Entity\University $university
     * @return CourseTitle
     */
    public function setUniversity(\Back\UniversityBundle\Entity\University $university = null)
    {
        $this->university = $university;

        return $this;
    }

    /**
     * Get university
     *
     * @return \Back\UniversityBundle\Entity\University 
     */
    public function getUniversity()
    {
        return $this->university;
    }
}
