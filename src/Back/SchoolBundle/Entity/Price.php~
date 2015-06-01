<?php

namespace Back\SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Price
 *
 * @ORM\Table(name="wws_price")
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
     * @var integer
     *
     * @ORM\Column(name="weekStart", type="integer")
     * @Assert\Range( min = 1)
     */
    private $weekStart;

    /**
     * @var integer
     *
     * @ORM\Column(name="weekEnd", type="integer")
     * @Assert\Range( min = 1)
     */
    private $weekEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=11, scale=3)
     * @Assert\Range( min = 1)
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="Course", inversedBy="prices")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $course;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fix", type="boolean", nullable=true)
     */
    private $fix;

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
     * Set weekStart
     *
     * @param integer $weekStart
     * @return Price
     */
    public function setWeekStart($weekStart)
    {
        $this->weekStart=$weekStart;

        return $this;
    }

    /**
     * Get weekStart
     *
     * @return integer 
     */
    public function getWeekStart()
    {
        return $this->weekStart;
    }

    /**
     * Set weekEnd
     *
     * @param integer $weekEnd
     * @return Price
     */
    public function setWeekEnd($weekEnd)
    {
        $this->weekEnd=$weekEnd;

        return $this;
    }

    /**
     * Get weekEnd
     *
     * @return integer 
     */
    public function getWeekEnd()
    {
        return $this->weekEnd;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Price
     */
    public function setPrice($price)
    {
        $this->price=$price;

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
     * Set course
     *
     * @param \Back\SchoolBundle\Entity\Course $course
     * @return Price
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
     * to string
     * 
     * @return string 
     */
    public function __toString()
    {
        return '['.$this->weekStart.' .. '.$this->weekEnd.']';
    }

    /**
     * Set room
     *
     * @param \Back\SchoolBundle\Entity\Room $room
     * @return Price
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
     * Set fix
     *
     * @param boolean $fix
     * @return Price
     */
    public function setFix($fix)
    {
        $this->fix=$fix;

        return $this;
    }

    /**
     * Get fix
     *
     * @return boolean 
     */
    public function getFix()
    {
        return $this->fix;
    }

    public function shoxFix()
    {
        if($this->fix)
            return 'Price Fix';
        else
            return 'Per Week';
    }

    public function __clone()
    {
        if($this->id)
        {
            $this->id=null;
        }
    }

}
