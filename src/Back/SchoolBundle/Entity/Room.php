<?php

namespace Back\SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Room
 *
 * @ORM\Table(name="wws_rooms")
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
     * @ORM\OrderBy({"weekStart" = "ASC"})
     */
    protected $prices;

    /**
     * @ORM\OneToMany(targetEntity="PathwayPrice", mappedBy="room")
     * @ORM\OrderBy({"startDate" = "ASC"})
     */
    protected $pathwayPrices;

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
     * Set accommodation
     *
     * @param \Back\SchoolBundle\Entity\Accommodation $accommodation
     * @return Room
     */
    public function setAccommodation(\Back\SchoolBundle\Entity\Accommodation $accommodation=null)
    {
        $this->accommodation=$accommodation;

        return $this;
    }

    /**
     * Get accommodation
     *
     * @return \Back\SchoolBundle\Entity\Accommodation 
     */
    public function getAccommodation()
    {
        return $this->accommodation;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->prices=new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add prices
     *
     * @param \Back\SchoolBundle\Entity\Price $prices
     * @return Room
     */
    public function addPrice(\Back\SchoolBundle\Entity\Price $prices)
    {
        $this->prices[]=$prices;

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

    /**
     * to string
     * @return String 
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Add pathwayPrices
     *
     * @param \Back\SchoolBundle\Entity\PathwayPrice $pathwayPrices
     * @return Room
     */
    public function addPathwayPrice(\Back\SchoolBundle\Entity\PathwayPrice $pathwayPrices)
    {
        $this->pathwayPrices[]=$pathwayPrices;

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

    public function getMinWeek()
    {
        $min=999;
        if(count($this->prices) == 0)
            return 0;
        foreach($this->prices as $price)
        {
            if($price->getWeekStart() < $min)
                $min=$price->getWeekStart();
        }
        return $min;
    }

    public function getMaxWeek()
    {
        $max=0;
        if(count($this->prices) == 0)
            return 0;
        foreach($this->prices as $price)
        {
            if($price->getWeekEnd() > $max)
                $max=$price->getWeekEnd();
        }
        return $max;
    }

    public function calculePrice($week)
    {
        if(count($this->prices) == 0)
            return 0;
        foreach($this->prices as $price)
        {
            if($price->getWeekEnd() >= $week && $price->getWeekStart() <= $week)
            {
                if($price->getFix())
                    return number_format($price->getPrice(), $this->accommodation->getSchoolLocation()->getCurrency()->getScale(), '.', '');
                else
                    return number_format($price->getPrice() * $week, $this->accommodation->getSchoolLocation()->getCurrency()->getScale(), '.', '');
            }
        }
    }

    public function getFirstPathwayPrice()
    {
        if(count($this->pathwayPrices) != 0)
            return $this->pathwayPrices->first()->getId();
    }

    public function calculePathwayPrice($id)
    {
        if(count($this->pathwayPrices) == 0)
            return 0;
        foreach($this->pathwayPrices as $price)
        {
            if($price->getId() == $id)
                return number_format($price->getPrice(), $this->accommodation->getSchoolLocation()->getCurrency()->getScale(), '.', '');
        }
    }
}
