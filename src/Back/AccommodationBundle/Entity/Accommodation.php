<?php

namespace Back\AccommodationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Accommodation
 *
 * @ORM\Table(name="wws_big_accommodation")
 * @ORM\Entity(repositoryClass="Front\GeneralBundle\Entity\AccommodationRepository")
 */
class Accommodation
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
     * @var string
     *
     * @ORM\Column(name="firstPayment", type="decimal", precision=11, scale=3)
     */
    private $firstPayment;

    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\TypeAccommodation")
     * @Assert\NotNull()
     */
    protected $typeAccommodation;

    /**
     * @ORM\OneToMany(targetEntity="Room", mappedBy="accommodation")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    protected $rooms;
    
    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\Currency")
     * @Assert\NotNull()
     */
    protected $currency ;
    
    /**
     * @ORM\OneToMany(targetEntity="Back\ReferentielBundle\Entity\Media", mappedBy="accommodation")
     */
    protected $photos;

    /**
     * @ORM\OneToOne(targetEntity="Back\ReferentielBundle\Entity\Media", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image;
    
    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\City", inversedBy="schoolLocations")
     * @Assert\NotNull()
     */
    protected $city ;
    
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
     * @return Accommodation
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
     * @return Accommodation
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
     * @return Accommodation
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
     * Set firstPayment
     *
     * @param string $firstPayment
     * @return Accommodation
     */
    public function setFirstPayment($firstPayment)
    {
        $this->firstPayment=$firstPayment;

        return $this;
    }

    /**
     * Get firstPayment
     *
     * @return string 
     */
    public function getFirstPayment()
    {
        return $this->firstPayment;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rooms = new \Doctrine\Common\Collections\ArrayCollection();
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set typeAccommodation
     *
     * @param \Back\ReferentielBundle\Entity\TypeAccommodation $typeAccommodation
     * @return Accommodation
     */
    public function setTypeAccommodation(\Back\ReferentielBundle\Entity\TypeAccommodation $typeAccommodation = null)
    {
        $this->typeAccommodation = $typeAccommodation;

        return $this;
    }

    /**
     * Get typeAccommodation
     *
     * @return \Back\ReferentielBundle\Entity\TypeAccommodation 
     */
    public function getTypeAccommodation()
    {
        return $this->typeAccommodation;
    }

    /**
     * Set currency
     *
     * @param \Back\ReferentielBundle\Entity\Currency $currency
     * @return Accommodation
     */
    public function setCurrency(\Back\ReferentielBundle\Entity\Currency $currency = null)
    {
        $this->currency = $currency;

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
     * Add photos
     *
     * @param \Back\ReferentielBundle\Entity\Media $photos
     * @return Accommodation
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

    /**
     * Set image
     *
     * @param \Back\ReferentielBundle\Entity\Media $image
     * @return Accommodation
     */
    public function setImage(\Back\ReferentielBundle\Entity\Media $image = null)
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
     * @return Accommodation
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
     * Set enabled
     *
     * @param boolean $enabled
     * @return Accommodation
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
     * Add rooms
     *
     * @param \Back\AccommodationBundle\Entity\Room $rooms
     * @return Accommodation
     */
    public function addRoom(\Back\AccommodationBundle\Entity\Room $rooms)
    {
        $this->rooms[] = $rooms;

        return $this;
    }

    /**
     * Remove rooms
     *
     * @param \Back\AccommodationBundle\Entity\Room $rooms
     */
    public function removeRoom(\Back\AccommodationBundle\Entity\Room $rooms)
    {
        $this->rooms->removeElement($rooms);
    }

    /**
     * Get rooms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRooms()
    {
        return $this->rooms;
    }
    
    public function getCountPrice()
    {
        $i=0;
        foreach($this->rooms as $room)
        {
            $i+=count($room->getPrices());
        }
        return $i;
    }
}
