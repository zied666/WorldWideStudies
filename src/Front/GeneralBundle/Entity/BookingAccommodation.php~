<?php

namespace Front\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BookingAccommodation
 *
 * @ORM\Table(name="wws_booking_accommodation")
 * @ORM\Entity
 */
class BookingAccommodation
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
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Back\UserBundle\Entity\User", inversedBy="bookingsLanguageCourses")
     * @Assert\NotNull()
     */
    protected $client;

    /**
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\Currency")
     * @Assert\NotNull()
     */
    protected $currency;

    /**
     * @ORM\ManyToOne(targetEntity="Back\AccommodationBundle\Entity\Room")
     * @Assert\NotNull()
     */
    protected $room;

    /**
     * @ORM\ManyToOne(targetEntity="Back\AccommodationBundle\Entity\Price")
     * @Assert\NotNull()
     */
    protected $price;

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="decimal", precision=11, scale=3)
     */
    private $total;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startingDate", type="date")
     */
    private $startingDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bookingDate", type="datetime")
     */
    private $bookingDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateTrasaction", type="datetime", nullable=true)
     */
    private $dateTrasaction;

    /**
     * @var string
     *
     * @ORM\Column(name="idTransaction", type="string", length=255, nullable=true)
     */
    private $idTransaction;

    /**
     * @var array
     *
     * @ORM\Column(name="data_paypal", type="array", nullable=true)
     */
    private $paypalData;

    /**
     * @ORM\OneToMany(targetEntity="Back\BookingBundle\Entity\Status", mappedBy="bookingAccommodation")
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $otherStatus;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->paypalData=array();
    }

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
     * Set startingDate
     *
     * @param \DateTime $startingDate
     * @return BookingAccommodation
     */
    public function setStartingDate($startingDate)
    {
        $this->startingDate=$startingDate;

        return $this;
    }

    /**
     * Get startingDate
     *
     * @return \DateTime 
     */
    public function getStartingDate()
    {
        return $this->startingDate;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return BookingAccommodation
     */
    public function setStatus($status)
    {
        $this->status=$status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set total
     *
     * @param string $total
     * @return BookingAccommodation
     */
    public function setTotal($total)
    {
        $this->total=$total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set client
     *
     * @param \Back\UserBundle\Entity\User $client
     * @return BookingAccommodation
     */
    public function setClient(\Back\UserBundle\Entity\User $client=null)
    {
        $this->client=$client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \Back\UserBundle\Entity\User 
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set currency
     *
     * @param \Back\ReferentielBundle\Entity\Currency $currency
     * @return BookingAccommodation
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
     * Set room
     *
     * @param \Back\AccommodationBundle\Entity\Room $room
     * @return BookingAccommodation
     */
    public function setRoom(\Back\AccommodationBundle\Entity\Room $room=null)
    {
        $this->room=$room;

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

    /**
     * Set price
     *
     * @param \Back\AccommodationBundle\Entity\Price $price
     * @return BookingAccommodation
     */
    public function setPrice(\Back\AccommodationBundle\Entity\Price $price=null)
    {
        $this->price=$price;

        return $this;
    }

    /**
     * Get price
     *
     * @return \Back\AccommodationBundle\Entity\Price 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set bookingDate
     *
     * @param \DateTime $bookingDate
     * @return BookingAccommodation
     */
    public function setBookingDate($bookingDate)
    {
        $this->bookingDate=$bookingDate;

        return $this;
    }

    /**
     * Get bookingDate
     *
     * @return \DateTime 
     */
    public function getBookingDate()
    {
        return $this->bookingDate;
    }

    /**
     * Set dateTrasaction
     *
     * @param \DateTime $dateTrasaction
     * @return BookingAccommodation
     */
    public function setDateTrasaction($dateTrasaction)
    {
        $this->dateTrasaction=$dateTrasaction;

        return $this;
    }

    /**
     * Get dateTrasaction
     *
     * @return \DateTime 
     */
    public function getDateTrasaction()
    {
        return $this->dateTrasaction;
    }

    /**
     * Set idTransaction
     *
     * @param string $idTransaction
     * @return BookingAccommodation
     */
    public function setIdTransaction($idTransaction)
    {
        $this->idTransaction=$idTransaction;

        return $this;
    }

    /**
     * Get idTransaction
     *
     * @return string 
     */
    public function getIdTransaction()
    {
        return $this->idTransaction;
    }

    /**
     * Set paypalData
     *
     * @param array $paypalData
     * @return BookingAccommodation
     */
    public function setPaypalData($paypalData)
    {
        $this->paypalData=$paypalData;

        return $this;
    }

    /**
     * Get paypalData
     *
     * @return array 
     */
    public function getPaypalData()
    {
        return $this->paypalData;
    }

    public function showStatus()
    {
        if($this->status == 1)
            return 'Unpaid';
        if($this->status == 2)
            return 'Paid';
    }

    /**
     * Add otherStatus
     *
     * @param \Back\BookingBundle\Entity\Status $otherStatus
     * @return BookingAccommodation
     */
    public function addOtherStatus(\Back\BookingBundle\Entity\Status $otherStatus)
    {
        $this->otherStatus[]=$otherStatus;

        return $this;
    }

    /**
     * Remove otherStatus
     *
     * @param \Back\BookingBundle\Entity\Status $otherStatus
     */
    public function removeOtherStatus(\Back\BookingBundle\Entity\Status $otherStatus)
    {
        $this->otherStatus->removeElement($otherStatus);
    }

    /**
     * Get otherStatus
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOtherStatus()
    {
        return $this->otherStatus;
    }

    public function __toString()
    {
        return $this->id.'.';
    }
    
    public function showLastStatus()
    {
        if(count($this->otherStatus)!=0)
        {
            return $this->otherStatus->last()->getStatus().' ('.$this->otherStatus->last()->getUser().')';
        }
        return '';
    }

}
