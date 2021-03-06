<?php

namespace Back\SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * School
 *
 * @ORM\Table(name="wws_school_location")
 * @ORM\Entity(repositoryClass="Front\GeneralBundle\Entity\SchoolLocationRepository")
 */
class SchoolLocation
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
     * @var integer
     * 1:language, 2: pathway
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity="Back\ReferentielBundle\Entity\Media", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\City", inversedBy="schoolLocations")
     * @Assert\NotNull()
     */
    protected $city;

    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\School", inversedBy="schoolLocations")
     * @Assert\NotNull()
     */
    protected $school;

    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\Currency")
     * @Assert\NotNull()
     */
    protected $currency;

    /**
     * @ORM\OneToMany(targetEntity="Course", mappedBy="schoolLocation")
     */
    protected $courses;

    /**
     * @ORM\OneToMany(targetEntity="Back\ReferentielBundle\Entity\Media", mappedBy="schoolLocation")
     */
    protected $photos;

    /**
     * @ORM\OneToMany(targetEntity="Accommodation", mappedBy="schoolLocation")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    protected $accommodations;

    /**
     * @ORM\OneToMany(targetEntity="Extra", mappedBy="schoolLocation")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    protected $extras;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="homepage", type="boolean", nullable=true)
     */
    private $homepage;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=11, scale=3)
     * @Assert\Range( min = 1)
     */
    private $avgPrice;

    /**
     * @ORM\OneToMany(targetEntity="Front\GeneralBundle\Entity\Review", mappedBy="schoolLocation")
     */
    protected $allReviews;

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
        $this->image=$image;

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
    public function setCity(\Back\ReferentielBundle\Entity\City $city=null)
    {
        $this->city=$city;

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
     * Set enabled
     *
     * @param boolean $enabled
     * @return School
     */
    public function setEnabled($enabled)
    {
        $this->enabled=$enabled;

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
        $this->courses=new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add courses
     *
     * @param \Back\SchoolBundle\Entity\Course $courses
     * @return School
     */
    public function addCourse(\Back\SchoolBundle\Entity\Course $courses)
    {
        $this->courses[]=$courses;

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

    /**
     * Add accommodations
     *
     * @param \Back\SchoolBundle\Entity\Accommodation $accommodations
     * @return School
     */
    public function addAccommodation(\Back\SchoolBundle\Entity\Accommodation $accommodations)
    {
        $this->accommodations[]=$accommodations;

        return $this;
    }

    /**
     * Remove accommodations
     *
     * @param \Back\SchoolBundle\Entity\Accommodation $accommodations
     */
    public function removeAccommodation(\Back\SchoolBundle\Entity\Accommodation $accommodations)
    {
        $this->accommodations->removeElement($accommodations);
    }

    /**
     * Get accommodations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAccommodations()
    {
        return $this->accommodations;
    }

    /**
     * Set school
     *
     * @param \Back\ReferentielBundle\Entity\School $school
     * @return SchoolLocation
     */
    public function setSchool(\Back\ReferentielBundle\Entity\School $school=null)
    {
        $this->school=$school;

        return $this;
    }

    /**
     * Get school
     *
     * @return \Back\ReferentielBundle\Entity\School 
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Add extras
     *
     * @param \Back\SchoolBundle\Entity\Extra $extras
     * @return SchoolLocation
     */
    public function addExtra(\Back\SchoolBundle\Entity\Extra $extras)
    {
        $this->extras[]=$extras;

        return $this;
    }

    /**
     * Remove extras
     *
     * @param \Back\SchoolBundle\Entity\Extra $extras
     */
    public function removeExtra(\Back\SchoolBundle\Entity\Extra $extras)
    {
        $this->extras->removeElement($extras);
    }

    /**
     * Get extras
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExtras()
    {
        return $this->extras;
    }

    /**
     * Add photos
     *
     * @param \Back\ReferentielBundle\Entity\Media $photos
     * @return SchoolLocation
     */
    public function addPhoto(\Back\ReferentielBundle\Entity\Media $photos)
    {
        $this->photos[]=$photos;

        return $this;
    }

    /**
     * Remove photos
     *
     * @param \Back\ReferentielBundle\Entity\Media $photos
     */
    public function removePhoto(\Back\ReferentielBundle\Entity\Media $photos)
    {
        $this->photos->removeElement($photos);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return SchoolLocation
     */
    public function setType($type)
    {
        $this->type=$type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    public function showType()
    {
        if($this->type == 1)
            return "Language course";
        else
            return "Pathway programs";
    }

    /**
     * Set currency
     *
     * @param \Back\ReferentielBundle\Entity\Currency $currency
     * @return SchoolLocation
     */
    public function setCurrency(\Back\ReferentielBundle\Entity\Currency $currency=null)
    {
        $this->currency=$currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return \Back\ReferentielBundle\Entity\Currency 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set avgPrice
     *
     * @param string $avgPrice
     * @return SchoolLocation
     */
    public function setAvgPrice($avgPrice)
    {
        $this->avgPrice=$avgPrice;

        return $this;
    }

    /**
     * Get avgPrice
     *
     * @return string 
     */
    public function getAvgPrice()
    {
        if(!is_null($this->currency))
            return number_format($this->avgPrice, $this->currency->getScale(), '.', '');
        else
            return $this->avgPrice;
    }


    /**
     * Set homepage
     *
     * @param boolean $homepage
     * @return SchoolLocation
     */
    public function setHomepage($homepage)
    {
        $this->homepage = $homepage;

        return $this;
    }

    /**
     * Get homepage
     *
     * @return boolean 
     */
    public function getHomepage()
    {
        return $this->homepage;
    }
    
    public function __clone()
    {
        if ($this->id)
        {
            $this->id = null ;
            $this->name='(Clone) '.$this->name;
            $this->enabled=FALSE;
            if ($this->image != null)
                $this->image = clone $this->image ;
        }
    }

    /**
     * Add allReviews
     *
     * @param \Front\GeneralBundle\Entity\Review $allReviews
     * @return SchoolLocation
     */
    public function addAllReview(\Front\GeneralBundle\Entity\Review $allReviews)
    {
        $this->allReviews[] = $allReviews;

        return $this;
    }

    /**
     * Remove allReviews
     *
     * @param \Front\GeneralBundle\Entity\Review $allReviews
     */
    public function removeAllReview(\Front\GeneralBundle\Entity\Review $allReviews)
    {
        $this->allReviews->removeElement($allReviews);
    }

    /**
     * Get allReviews
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAllReviews()
    {
        return $this->allReviews;
    }
}
