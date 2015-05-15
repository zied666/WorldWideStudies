<?php

namespace Back\UniversityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * University
 *
 * @ORM\Table(name="wws_university")
 * @ORM\Entity
 */
class University
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
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="nameUniversity", type="string", length=255)
     */
    private $nameUniversity;

    /**
     * @var integer
     *
     * @ORM\Column(name="rank", type="integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 100
     * )
     */
    private $rank;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var string
     * @Assert\Url()
     * @ORM\Column(name="site", type="string", length=255)
     */
    private $site;

    /**
     * @ORM\OneToOne(targetEntity="Back\ReferentielBundle\Entity\Media", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\City")
     * @Assert\NotNull()
     */
    protected $city;

    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\Currency")
     * @Assert\NotNull()
     */
    protected $currency;

    /**
     * @ORM\OneToMany(targetEntity="CourseTitle", mappedBy="university")
     */
    protected $courseTitles;

    /**
     * @ORM\OneToMany(targetEntity="Back\ReferentielBundle\Entity\Media", mappedBy="university")
     */
    protected $photos;

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
     * @return University
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
     * Set description
     *
     * @param string $description
     * @return University
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
     * Set enabled
     *
     * @param boolean $enabled
     * @return University
     */
    public function setEnabled($enabled)
    {
        $this->enabled=$enabled;

        return $this;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return University
     */
    public function isEnabled()
    {
        return $this->enabled;
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
     * Set site
     *
     * @param string $site
     * @return University
     */
    public function setSite($site)
    {
        $this->site=$site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string 
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set image
     *
     * @param \Back\ReferentielBundle\Entity\Media $image
     * @return University
     */
    public function setImage(\Back\ReferentielBundle\Entity\Media $image=null)
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
     * @return University
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
     * Set currency
     *
     * @param \Back\ReferentielBundle\Entity\Currency $currency
     * @return University
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
     * Set nameUniversity
     *
     * @param string $nameUniversity
     * @return University
     */
    public function setNameUniversity($nameUniversity)
    {
        $this->nameUniversity=$nameUniversity;

        return $this;
    }

    /**
     * Get nameUniversity
     *
     * @return string 
     */
    public function getNameUniversity()
    {
        return $this->nameUniversity;
    }

    /**
     * Set rank
     *
     * @param integer $rank
     * @return University
     */
    public function setRank($rank)
    {
        $this->rank=$rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return integer 
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->courseTitles=new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add courseTitles
     *
     * @param \Back\UniversityBundle\Entity\CourseTitle $courseTitles
     * @return University
     */
    public function addCourseTitle(\Back\UniversityBundle\Entity\CourseTitle $courseTitles)
    {
        $this->courseTitles[]=$courseTitles;

        return $this;
    }

    /**
     * Remove courseTitles
     *
     * @param \Back\UniversityBundle\Entity\CourseTitle $courseTitles
     */
    public function removeCourseTitle(\Back\UniversityBundle\Entity\CourseTitle $courseTitles)
    {
        $this->courseTitles->removeElement($courseTitles);
    }

    /**
     * Get courseTitles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCourseTitles()
    {
        return $this->courseTitles;
    }


    /**
     * Add photos
     *
     * @param \Back\ReferentielBundle\Entity\Media $photos
     * @return University
     */
    public function addPhoto(\Back\ReferentielBundle\Entity\Media $photos)
    {
        $this->photos[] = $photos;

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
    
    public function __toString()
    {
        return $this->name;
    }
}
