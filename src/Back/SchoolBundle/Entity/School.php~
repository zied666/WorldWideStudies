<?php

namespace Back\SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * School
 *
 * @ORM\Table(name="wws_school")
 * @ORM\Entity
 */
class School
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
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="shortDescription", type="text")
     */
    private $shortDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="longDescription", type="text")
     */
    private $longDescription;

    /**
     * @var integer
     *
     * @ORM\Column(name="reviews", type="integer")
     */
    private $reviews;

    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 5
     * )
     */
    private $note;

    /**
     * @var integer
     *
     * @ORM\Column(name="stars", type="integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 5
     * )
     */
    private $stars;

    /**
     * @ORM\OneToOne(targetEntity="Back\ReferentielBundle\Entity\Media", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image;
    
    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\City", inversedBy="schools")
     * @Assert\NotNull()
     */
    protected $city ;
    
    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\University", inversedBy="schools")
     * @Assert\NotNull()
     */
    protected $university ;
    
    /**
     * @ORM\OneToMany(targetEntity="Course", mappedBy="school")
     */
    protected $courses;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;


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
     * @return School
     */
    public function setName($name)
    {
        $this->name=$name;

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
     * Set shortDescription
     *
     * @param string $shortDescription
     * @return School
     */
    public function setShortDescription($shortDescription)
    {
        $this->shortDescription=$shortDescription;

        return $this;
    }

    /**
     * Get shortDescription
     *
     * @return string 
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * Set longDescription
     *
     * @param string $longDescription
     * @return School
     */
    public function setLongDescription($longDescription)
    {
        $this->longDescription=$longDescription;

        return $this;
    }

    /**
     * Get longDescription
     *
     * @return string 
     */
    public function getLongDescription()
    {
        return $this->longDescription;
    }

    /**
     * Set reviews
     *
     * @param integer $reviews
     * @return School
     */
    public function setReviews($reviews)
    {
        $this->reviews=$reviews;

        return $this;
    }

    /**
     * Get reviews
     *
     * @return integer 
     */
    public function getReviews()
    {
        return $this->reviews;
    }

    /**
     * Set note
     *
     * @param integer $note
     * @return School
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
     * Set stars
     *
     * @param integer $stars
     * @return School
     */
    public function setStars($stars)
    {
        $this->stars=$stars;

        return $this;
    }

    /**
     * Get stars
     *
     * @return integer 
     */
    public function getStars()
    {
        return $this->stars;
    }


    /**
     * Set image
     *
     * @param \Back\ReferentielBundle\Entity\Media $image
     * @return School
     */
    public function setImage(\Back\ReferentielBundle\Entity\Media $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Back\ReferentielBundle\Entity\Media 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set city
     *
     * @param \Back\ReferentielBundle\Entity\City $city
     * @return School
     */
    public function setCity(\Back\ReferentielBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \Back\ReferentielBundle\Entity\City 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set university
     *
     * @param \Back\ReferentielBundle\Entity\University $university
     * @return School
     */
    public function setUniversity(\Back\ReferentielBundle\Entity\University $university = null)
    {
        $this->university = $university;

        return $this;
    }

    /**
     * Get university
     *
     * @return \Back\ReferentielBundle\Entity\University 
     */
    public function getUniversity()
    {
        return $this->university;
    }


    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return School
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }
    
    /**
     * Is enables
     * 
     * @return boolean 
     */
    public function isEnabled()
    {
        return $this->enabled;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->courses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add courses
     *
     * @param \Back\SchoolBundle\Entity\Course $courses
     * @return School
     */
    public function addCourse(\Back\SchoolBundle\Entity\Course $courses)
    {
        $this->courses[] = $courses;

        return $this;
    }

    /**
     * Remove courses
     *
     * @param \Back\SchoolBundle\Entity\Course $courses
     */
    public function removeCourse(\Back\SchoolBundle\Entity\Course $courses)
    {
        $this->courses->removeElement($courses);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCourses()
    {
        return $this->courses;
    }
    
    /**
     * to string
     * 
     * @return string 
     */
    public function __toString()
    {
        return $this->name;
    }
}
