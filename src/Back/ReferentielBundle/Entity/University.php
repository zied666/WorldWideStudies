<?php

namespace Back\ReferentielBundle\Entity ;

use Doctrine\ORM\Mapping as ORM ;

/**
 * University
 *
 * @ORM\Table(name="wws_university")
 * @ORM\Entity
 */
class University
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id ;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name ;

    /**
     * @ORM\OneToOne(targetEntity="Media", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image ;
    
    /**
     * @ORM\OneToMany(targetEntity="Back\SchoolBundle\Entity\School", mappedBy="university")
     */
    protected $schools;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id ;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return University
     */
    public function setName($name)
    {
        $this->name = $name ;

        return $this ;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name ;
    }


    /**
     * Set image
     *
     * @param \Back\ReferentielBundle\Entity\Media $image
     * @return University
     */
    public function setImage(\Back\ReferentielBundle\Entity\Media $image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Back\ReferentielBundle\Entity\Media 
     */
    public function getImage()
    {
        return $this->image;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->schools = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add schools
     *
     * @param \Back\SchoolBundle\Entity\School $schools
     * @return University
     */
    public function addSchool(\Back\SchoolBundle\Entity\School $schools)
    {
        $this->schools[] = $schools;

        return $this;
    }

    /**
     * Remove schools
     *
     * @param \Back\SchoolBundle\Entity\School $schools
     */
    public function removeSchool(\Back\SchoolBundle\Entity\School $schools)
    {
        $this->schools->removeElement($schools);
    }

    /**
     * Get schools
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSchools()
    {
        return $this->schools;
    }
    
    /**
     * to string
     * @return string 
     */
    public function __toString()
    {
        return $this->name;
    }
}
