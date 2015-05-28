<?php

namespace Back\SchoolBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Extra
 *
 * @ORM\Table(name="wws_extra")
 * @ORM\Entity
 */
class Extra
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
     * @ORM\Column(name="price", type="decimal", precision=11, scale=3)
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="date",nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="date",nullable=true)
     */
    private $endDate;

    /**
     * @var integer
     * 1:Course,2:accommodation
     * @ORM\Column(name="perWeek", type="integer" ,nullable=true)
     */
    private $perWeek;

    /**
     * @var boolean
     *
     * @ORM\Column(name="obligatory", type="boolean",nullable=true)
     */
    private $obligatory;
    
    /**
     * @ORM\ManyToOne(targetEntity="SchoolLocation", inversedBy="extras")
     * @Assert\NotNull()
     */
    protected $schoolLocation;


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
     * @return Extra
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * Set price
     *
     * @param string $price
     * @return Extra
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
        return $this->price;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Extra
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
     * @return Extra
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
     * Set obligatory
     *
     * @param boolean $obligatory
     * @return Extra
     */
    public function setObligatory($obligatory)
    {
        $this->obligatory = $obligatory;

        return $this;
    }

    /**
     * Get obligatory
     *
     * @return boolean 
     */
    public function getObligatory()
    {
        return $this->obligatory;
    }

    /**
     * Set schoolLocation
     *
     * @param \Back\SchoolBundle\Entity\SchoolLocation $schoolLocation
     * @return Extra
     */
    public function setSchoolLocation(\Back\SchoolBundle\Entity\SchoolLocation $schoolLocation = null)
    {
        $this->schoolLocation = $schoolLocation;

        return $this;
    }

    /**
     * Get schoolLocation
     *
     * @return \Back\SchoolBundle\Entity\SchoolLocation 
     */
    public function getSchoolLocation()
    {
        return $this->schoolLocation;
    }
    
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set perWeek
     *
     * @param integer $perWeek
     * @return Extra
     */
    public function setPerWeek($perWeek)
    {
        $this->perWeek = $perWeek;

        return $this;
    }

    /**
     * Get perWeek
     *
     * @return integer 
     */
    public function getPerWeek()
    {
        return $this->perWeek;
    }

    /**
     * Get perWeek
     *
     * @return integer 
     */
    public function showPerWeek()
    {
        if($this->perWeek==1)
            return 'Per week (school)';
        elseif($this->perWeek==2)
            return 'Per week (accommodation)';
        else
            return 'No';
    }
    
    public function __clone()
    {
        if ($this->id)
        {
            $this->id = null ;
        }
    }
}
