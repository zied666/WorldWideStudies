<?php

namespace Front\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * BookingLanguageCourse
 *
 * @ORM\Table(name="wws_booking_language_course")
 * @ORM\Entity
 */
class BookingLanguageCourse
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
     * @ORM\ManyToOne(targetEntity="Back\SchoolBundle\Entity\Course")
     * @Assert\NotNull()
     */
    protected $course;

    /**
     * @var integer
     *
     * @ORM\Column(name="weekCourse", type="integer")
     */
    private $weekCourse;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startingDateCourse", type="date")
     */
    private $startingDateCourse;

    /**
     * @var string
     *
     * @ORM\Column(name="total_course", type="decimal", precision=11, scale=3)
     */
    private $totalCourse;

    /**
     * @ORM\ManyToOne(targetEntity="Back\SchoolBundle\Entity\Room")
     * @Assert\NotNull()
     */
    protected $room;

    /**
     * @var integer
     *
     * @ORM\Column(name="weekAccommodation", type="integer",nullable=true)
     */
    private $weekAccommodation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startingDateAccommodation", type="date" ,nullable=true)
     */
    private $startingDateAccommodation;

    /**
     * @var string
     *
     * @ORM\Column(name="total_accommodation", type="decimal", precision=11, scale=3, nullable=true)
     */
    private $totalAccommodation;

    /**
     * @ORM\ManyToMany(targetEntity="Back\SchoolBundle\Entity\Extra")
     * @ORM\JoinTable(name="wws_booking_language_course_extras",
     *      joinColumns={@ORM\JoinColumn(name="bookinglanguagecourse_id", referencedColumnName="id" ,onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="extra_id", referencedColumnName="id")}
     * )
     */
    protected $extras;

    /**
     * @var string
     *
     * @ORM\Column(name="total_extra", type="decimal", precision=11, scale=3, nullable=true)
     */
    private $totalExtra;

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="decimal", precision=11, scale=3)
     */
    private $total;

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
     * @ORM\Column(name="data", type="array")
     */
    private $paypalData;

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
     * Set weekCourse
     *
     * @param integer $weekCourse
     * @return BookingLanguageCourse
     */
    public function setWeekCourse($weekCourse)
    {
        $this->weekCourse=$weekCourse;

        return $this;
    }

    /**
     * Get weekCourse
     *
     * @return integer 
     */
    public function getWeekCourse()
    {
        return $this->weekCourse;
    }

    /**
     * Set startingDateCourse
     *
     * @param \DateTime $startingDateCourse
     * @return BookingLanguageCourse
     */
    public function setStartingDateCourse($startingDateCourse)
    {
        $this->startingDateCourse=$startingDateCourse;

        return $this;
    }

    /**
     * Get startingDateCourse
     *
     * @return \DateTime 
     */
    public function getStartingDateCourse()
    {
        return $this->startingDateCourse;
    }

    /**
     * Set weekAccommodation
     *
     * @param integer $weekAccommodation
     * @return BookingLanguageCourse
     */
    public function setWeekAccommodation($weekAccommodation)
    {
        $this->weekAccommodation=$weekAccommodation;

        return $this;
    }

    /**
     * Get weekAccommodation
     *
     * @return integer 
     */
    public function getWeekAccommodation()
    {
        return $this->weekAccommodation;
    }

    /**
     * Set startingDateAccommodation
     *
     * @param \DateTime $startingDateAccommodation
     * @return BookingLanguageCourse
     */
    public function setStartingDateAccommodation($startingDateAccommodation)
    {
        $this->startingDateAccommodation=$startingDateAccommodation;

        return $this;
    }

    /**
     * Get startingDateAccommodation
     *
     * @return \DateTime 
     */
    public function getStartingDateAccommodation()
    {
        return $this->startingDateAccommodation;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->extras=new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set client
     *
     * @param \Back\UserBundle\Entity\User $client
     * @return BookingLanguageCourse
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
     * @return BookingLanguageCourse
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
     * Set course
     *
     * @param \Back\SchoolBundle\Entity\Course $course
     * @return BookingLanguageCourse
     */
    public function setCourse(\Back\SchoolBundle\Entity\Course $course=null)
    {
        $this->course=$course;

        return $this;
    }

    /**
     * Get course
     *
     * @return \Back\SchoolBundle\Entity\Course 
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set room
     *
     * @param \Back\SchoolBundle\Entity\Room $room
     * @return BookingLanguageCourse
     */
    public function setRoom(\Back\SchoolBundle\Entity\Room $room=null)
    {
        $this->room=$room;

        return $this;
    }

    /**
     * Get room
     *
     * @return \Back\SchoolBundle\Entity\Room 
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * Add extras
     *
     * @param \Back\SchoolBundle\Entity\Extra $extras
     * @return BookingLanguageCourse
     */
    public function addExtra(\Back\SchoolBundle\Entity\Extra $extras)
    {
        $this->extras[]=$extras;

        return $this;
    }

    /**
     * Set totalCourse
     *
     * @param string $totalCourse
     * @return BookingLanguageCourse
     */
    public function setTotalCourse($totalCourse)
    {
        $this->totalCourse=$totalCourse;

        return $this;
    }

    /**
     * Get totalCourse
     *
     * @return string 
     */
    public function getTotalCourse()
    {
        return $this->totalCourse;
    }

    /**
     * Set totalAccommodation
     *
     * @param string $totalAccommodation
     * @return BookingLanguageCourse
     */
    public function setTotalAccommodation($totalAccommodation)
    {
        $this->totalAccommodation=$totalAccommodation;

        return $this;
    }

    /**
     * Get totalAccommodation
     *
     * @return string 
     */
    public function getTotalAccommodation()
    {
        return $this->totalAccommodation;
    }

    /**
     * Set totalExtra
     *
     * @param string $totalExtra
     * @return BookingLanguageCourse
     */
    public function setTotalExtra($totalExtra)
    {
        $this->totalExtra=$totalExtra;

        return $this;
    }

    /**
     * Get totalExtra
     *
     * @return string 
     */
    public function getTotalExtra()
    {
        return $this->totalExtra;
    }

    /**
     * Set total
     *
     * @param string $total
     * @return BookingLanguageCourse
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
     * Set status
     *
     * @param integer $status
     * @return BookingLanguageCourse
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
     * Set bookingDate
     *
     * @param \DateTime $bookingDate
     * @return BookingLanguageCourse
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
     * Set dateTrasaction
     *
     * @param \DateTime $dateTrasaction
     * @return BookingLanguageCourse
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
     * @return BookingLanguageCourse
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
     * @return BookingLanguageCourse
     */
    public function setPaypalData($paypalData)
    {
        $this->paypalData = $paypalData;

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
}
