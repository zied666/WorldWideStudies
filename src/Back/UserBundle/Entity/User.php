<?php

namespace Back\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="wws_user")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Front\GeneralBundle\Entity\BookingLanguageCourse", mappedBy="client")
     */
    protected $bookingsLanguageCourses;

    public function __construct()
    {
        parent::__construct();
        // your own logic
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
     * Add bookingsLanguageCourses
     *
     * @param \Front\GeneralBundle\Entity\BookingLanguageCourse $bookingsLanguageCourses
     * @return User
     */
    public function addBookingsLanguageCourse(\Front\GeneralBundle\Entity\BookingLanguageCourse $bookingsLanguageCourses)
    {
        $this->bookingsLanguageCourses[] = $bookingsLanguageCourses;

        return $this;
    }

    /**
     * Remove bookingsLanguageCourses
     *
     * @param \Front\GeneralBundle\Entity\BookingLanguageCourse $bookingsLanguageCourses
     */
    public function removeBookingsLanguageCourse(\Front\GeneralBundle\Entity\BookingLanguageCourse $bookingsLanguageCourses)
    {
        $this->bookingsLanguageCourses->removeElement($bookingsLanguageCourses);
    }

    /**
     * Get bookingsLanguageCourses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBookingsLanguageCourses()
    {
        return $this->bookingsLanguageCourses;
    }
}
