<?php

namespace Back\SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Accommodation
 *
 * @ORM\Table(name="wws_accommodation")
 * @ORM\Entity
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     * @ORM\ManyToOne(targetEntity="School", inversedBy="accommodations")
     * @Assert\NotNull()
     */
    protected $school;
    
    /**
     * @ORM\OneToMany(targetEntity="Room", mappedBy="accommodation")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    protected $rooms;


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
     * Set description
     *
     * @param string $description
     * @return Accommodation
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
     * Set school
     *
     * @param \Back\SchoolBundle\Entity\School $school
     * @return Accommodation
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
     * Constructor
     */
    public function __construct()
    {
        $this->rooms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add rooms
     *
     * @param \Back\SchoolBundle\Entity\Room $rooms
     * @return Accommodation
     */
    public function addRoom(\Back\SchoolBundle\Entity\Room $rooms)
    {
        $this->rooms[] = $rooms;

        return $this;
    }

    /**
     * Remove rooms
     *
     * @param \Back\SchoolBundle\Entity\Room $rooms
     */
    public function removeRoom(\Back\SchoolBundle\Entity\Room $rooms)
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
    
    /**
     * get numbre prices
     * 
     * @return integer 
     */
    public function getNumberPrice()
    {
        $nbr=0;
        foreach($this->rooms as $room)
        {
            $nbr+=count($room->getPrices());
        }
        return $nbr;
    }
}
