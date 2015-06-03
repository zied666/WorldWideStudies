<?php

namespace Back\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @Assert\NotBlank(message="Please enter your first name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="The first name is too short.",
     *     maxMessage="The first name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @Assert\NotBlank(message="Please enter your last name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="The first last name is too short.",
     *     maxMessage="The first last name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @Assert\NotBlank(message="Please enter your phone.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="The phone is too short.",
     *     maxMessage="The phone is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $phone;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     *
     * @Assert\NotBlank(message="Please enter your address.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max="255",
     *     minMessage="The address is too short.",
     *     maxMessage="The address is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $address;

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
        $this->bookingsLanguageCourses[]=$bookingsLanguageCourses;

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

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName=$firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName=$lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone=$phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return User
     */
    public function setAddress($address)
    {
        $this->address=$address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    public function __toString()
    {
        if(is_null($this->firstName) && is_null($this->lastName))
            return parent::__toString();
        else
            return $this->firstName.' '.$this->lastName;
    }

}
