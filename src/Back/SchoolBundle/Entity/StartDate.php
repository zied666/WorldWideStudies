<?php

namespace Back\SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * StartDate
 *
 * @ORM\Table(name="wws_start_date")
 * @ORM\Entity
 */
class StartDate
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;
    
    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="startDates")
     */
    protected $course ;


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
     * @return StartDate
     */
    public function setDate($date)
    {
        $this->date = $date;

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
     * Set course
     *
     * @param \Back\SchoolBundle\Entity\Course $course
     * @return StartDate
     */
    public function setCourse(\Back\SchoolBundle\Entity\Course $course = null)
    {
        $this->course = $course;

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
    
    public function __clone()
    {
        if ($this->id)
        {
            $this->id = null ;
        }
    }
}
