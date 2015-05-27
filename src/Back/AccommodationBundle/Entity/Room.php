<?php

namespace Back\AccommodationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Room
 *
 * @ORM\Table(name="wws_big_rooms")
 * @ORM\Entity
 */
class Room
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
     * @ORM\ManyToOne(targetEntity="Accommodation", inversedBy="rooms")
     */
    protected $accommodation;

    /**
     * @ORM\OneToMany(targetEntity="Price", mappedBy="room")
     * @ORM\OrderBy({"startDate" = "ASC"})
     */
    protected $prices;

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
     * @return Room
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
     * @return Room
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
     * Constructor
     */
    public function __construct()
    {
        $this->prices=new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * to string
     * @return String 
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set accommodation
     *
     * @param \Back\AccommodationBundle\Entity\Accommodation $accommodation
     * @return Room
     */
    public function setAccommodation(\Back\AccommodationBundle\Entity\Accommodation $accommodation=null)
    {
        $this->accommodation=$accommodation;

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
     * Add prices
     *
     * @param \Back\AccommodationBundle\Entity\Price $prices
     * @return Room
     */
    public function addPrice(\Back\AccommodationBundle\Entity\Price $prices)
    {
        $this->prices[]=$prices;

        return $this;
    }

    /**
     * Remove prices
     *
     * @param \Back\AccommodationBundle\Entity\Price $prices
     */
    public function removePrice(\Back\AccommodationBundle\Entity\Price $prices)
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

    public function getFirstPrice()
    {
        if(count($this->prices) != 0)
            return $this->prices->first()->getId();
    }

    public function calculePrice($id)
    {
        if(count($this->prices) == 0)
            return 0;
        foreach($this->prices as $price)
        {
            if($price->getId() == $id)
                return number_format($price->getPrice(), $this->accommodation->getCurrency()->getScale(), '.', '');
        }
    }

}
