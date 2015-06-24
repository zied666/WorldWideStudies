<?php

namespace Front\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Review
 *
 * @ORM\Table(name="wws_review")
 * @ORM\Entity
 */
class Review
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
     * @var \DateTime
     *
     * @ORM\Column(name="reviewDate", type="datetime")
     */
    private $reviewDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="validated", type="boolean", nullable=true)
     */
    private $validated;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer")
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity="Back\SchoolBundle\Entity\SchoolLocation", inversedBy="allReviews")
     */
    protected $schoolLocation;

    /**
     * @ORM\ManyToOne(targetEntity="Back\AccommodationBundle\Entity\Accommodation", inversedBy="allReviews")
     */
    protected $accommodation;

    /**
     * @ORM\ManyToOne(targetEntity="Back\UniversityBundle\Entity\CourseTitle", inversedBy="allReviews")
     */
    protected $courseTitle;

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
     * Set title
     *
     * @param string $title
     * @return Review
     */
    public function setTitle($title)
    {
        $this->title=$title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Review
     */
    public function setText($text)
    {
        $this->text=$text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set note
     *
     * @param integer $note
     * @return Review
     */
    public function setNote($note)
    {
        $this->note=$note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer 
     */
    public function getNote()
    {
        return $this->note;
    }


    /**
     * Set schoolLocation
     *
     * @param \Back\SchoolBundle\Entity\SchoolLocation $schoolLocation
     * @return Review
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
     * Set accommodation
     *
     * @param \Back\AccommodationBundle\Entity\Accommodation $accommodation
     * @return Review
     */
    public function setAccommodation(\Back\AccommodationBundle\Entity\Accommodation $accommodation = null)
    {
        $this->accommodation = $accommodation;

        return $this;
    }

    /**
     * Get accommodation
     *
     * @return \Back\AccommodationBundle\Entity\Accommodation 
     */
    public function getAccommodation()
    {
        return $this->accommodation;
    }

    /**
     * Set courseTitle
     *
     * @param \Back\UniversityBundle\Entity\CourseTitle $courseTitle
     * @return Review
     */
    public function setCourseTitle(\Back\UniversityBundle\Entity\CourseTitle $courseTitle = null)
    {
        $this->courseTitle = $courseTitle;

        return $this;
    }

    /**
     * Get courseTitle
     *
     * @return \Back\UniversityBundle\Entity\CourseTitle 
     */
    public function getCourseTitle()
    {
        return $this->courseTitle;
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
     * Set validated
     *
     * @param boolean $validated
     * @return Review
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get validated
     *
     * @return boolean 
     */
    public function getValidated()
    {
        return $this->validated;
    }



    /**
     * Set name
     *
     * @param string $name
     * @return Review
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set reviewDate
     *
     * @param \DateTime $reviewDate
     * @return Review
     */
    public function setReviewDate($reviewDate)
    {
        $this->reviewDate = $reviewDate;

        return $this;
    }

    /**
     * Get reviewDate
     *
     * @return \DateTime 
     */
    public function getReviewDate()
    {
        return $this->reviewDate;
    }
}
