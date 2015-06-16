<?php

namespace Back\BookingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Status
 *
 * @ORM\Table(name="wws_booking_status")
 * @ORM\Entity
 */
class Status
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
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\Status")
     * @Assert\NotNull()
     */
    protected $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="observation", type="text")
     */
    private $observation;

    /**
     * @ORM\ManyToOne(targetEntity="Back\UserBundle\Entity\User")
     * @Assert\NotNull()
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Front\GeneralBundle\Entity\BookingLanguageCourse", inversedBy="otherStatus")
     */
    protected $bookingLanguageCourse;
    
    /**
     * @ORM\ManyToOne(targetEntity="Front\GeneralBundle\Entity\FormStep1", inversedBy="otherStatus")
     */
    protected $formStep1;

    /**
     * @ORM\ManyToOne(targetEntity="Front\GeneralBundle\Entity\BookingAccommodation", inversedBy="otherStatus")
     */
    protected $bookingAccommodation;

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
     * Set date
     *
     * @param \DateTime $date
     * @return Status
     */
    public function setDate($date)
    {
        $this->date=$date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set observation
     *
     * @param string $observation
     * @return Status
     */
    public function setObservation($observation)
    {
        $this->observation=$observation;

        return $this;
    }

    /**
     * Get observation
     *
     * @return string 
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * Set status
     *
     * @param \Back\ReferentielBundle\Entity\Status $status
     * @return Status
     */
    public function setStatus(\Back\ReferentielBundle\Entity\Status $status=null)
    {
        $this->status=$status;

        return $this;
    }

    /**
     * Get status
     *
     * @return \Back\ReferentielBundle\Entity\Status 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set user
     *
     * @param \Back\UserBundle\Entity\User $user
     * @return Status
     */
    public function setUser(\Back\UserBundle\Entity\User $user=null)
    {
        $this->user=$user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Back\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Set bookingLanguageCourse
     *
     * @param \Front\GeneralBundle\Entity\BookingLanguageCourse $bookingLanguageCourse
     * @return Status
     */
    public function setBookingLanguageCourse(\Front\GeneralBundle\Entity\BookingLanguageCourse $bookingLanguageCourse = null)
    {
        $this->bookingLanguageCourse = $bookingLanguageCourse;

        return $this;
    }

    /**
     * Get bookingLanguageCourse
     *
     * @return \Front\GeneralBundle\Entity\BookingLanguageCourse 
     */
    public function getBookingLanguageCourse()
    {
        return $this->bookingLanguageCourse;
    }

    /**
     * Set bookingAccommodation
     *
     * @param \Front\GeneralBundle\Entity\BookingAccommodation $bookingAccommodation
     * @return Status
     */
    public function setBookingAccommodation(\Front\GeneralBundle\Entity\BookingAccommodation $bookingAccommodation = null)
    {
        $this->bookingAccommodation = $bookingAccommodation;

        return $this;
    }

    /**
     * Get bookingAccommodation
     *
     * @return \Front\GeneralBundle\Entity\BookingAccommodation 
     */
    public function getBookingAccommodation()
    {
        return $this->bookingAccommodation;
    }

    /**
     * Set formStep1
     *
     * @param \Front\GeneralBundle\Entity\FormStep1 $formStep1
     * @return Status
     */
    public function setFormStep1(\Front\GeneralBundle\Entity\FormStep1 $formStep1 = null)
    {
        $this->formStep1 = $formStep1;

        return $this;
    }

    /**
     * Get formStep1
     *
     * @return \Front\GeneralBundle\Entity\FormStep1 
     */
    public function getFormStep1()
    {
        return $this->formStep1;
    }
}
