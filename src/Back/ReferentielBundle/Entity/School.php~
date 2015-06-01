<?php

namespace Back\ReferentielBundle\Entity ;

use Doctrine\ORM\Mapping as ORM ;

/**
 * School
 *
 * @ORM\Table(name="wws_school")
 * @ORM\Entity
 */
class School
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
     * @ORM\JoinColumn(nullable=true)
     */
    private $image ;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     * @ORM\OneToMany(targetEntity="Back\SchoolBundle\Entity\SchoolLocation", mappedBy="school")
     */
    protected $schoolLocations;

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
     * @return School
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
     * @return School
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
     * to string
     * @return string 
     */
    public function __toString()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->schoolLocations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add schoolLocations
     *
     * @param \Back\SchoolBundle\Entity\SchoolLocation $schoolLocations
     * @return School
     */
    public function addSchoolLocation(\Back\SchoolBundle\Entity\SchoolLocation $schoolLocations)
    {
        $this->schoolLocations[] = $schoolLocations;

        return $this;
    }

    /**
     * Remove schoolLocations
     *
     * @param \Back\SchoolBundle\Entity\SchoolLocation $schoolLocations
     */
    public function removeSchoolLocation(\Back\SchoolBundle\Entity\SchoolLocation $schoolLocations)
    {
        $this->schoolLocations->removeElement($schoolLocations);
    }

    /**
     * Get schoolLocations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSchoolLocations()
    {
        return $this->schoolLocations;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return School
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}
