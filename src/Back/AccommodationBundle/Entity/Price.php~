<?php

namespace Back\AccommodationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Price
 *
 * @ORM\Table(name="wws_accomodation_pathway_price")
 * @ORM\Entity
 */
class Price
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
     * @ORM\Column(name="price", type="decimal", precision=11, scale=3)
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="date", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="date" , nullable=true)
     */
    private $endDate;
    
    /**
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="prices")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * 
     */
    protected $room;


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
     * Set price
     *
     * @param string $price
     * @return Price
     */
    public function setPrice($price)
    {
        $this->price = $price;

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
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Price
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Price
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
    
    /**
     * get number of week between two dates
     * 
     * @return integer
     */
    public function getNumbrerWeeks()
    {
        $nbrJours=$dureesejour = (strtotime($this->endDate->format("Y-m-d")) - strtotime($this->startDate->format("Y-m-d")));
        return round($nbrJours/86400/7);
    }

    /**
     * Set room
     *
     * @param \Back\AccommodationBundle\Entity\Room $room
     * @return Price
     */
    public function setRoom(\Back\AccommodationBundle\Entity\Room $room = null)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get room
     *
     * @return \Back\AccommodationBundle\Entity\Room 
     */
    public function getRoom()
    {
        return $this->room;
    }
    
    public function __toString()
    {
        return $this->startDate->format('d/m/Y').' to '.$this->endDate->format('d/m/Y');
    }
}
