<?php

namespace Back\ReferentielBundle\Entity ;

use Doctrine\ORM\Mapping as ORM ;

/**
 * City
 *
 * @ORM\Table(name="wws_city")
 * @ORM\Entity
 */
class City
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
     * @ORM\Column(name="libelle", type="string", length=50)
     */
    private $libelle ;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="Citys")
     * @ORM\OrderBy({"libelle" = "ASC"})
     */
    protected $country ;

    /**
     * @ORM\OneToOne(targetEntity="Media", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $image ;
    
    /**
     * @ORM\OneToMany(targetEntity="Back\SchoolBundle\Entity\School", mappedBy="city")
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
     * Set libelle
     *
     * @param string $libelle
     * @return City
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle ;

        return $this ;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle ;
    }

    public function __toString()
    {
        return $this->libelle ;
    }

    /**
     * Set country
     *
     * @param \Back\ReferentielBundle\Entity\Country $country
     * @return City
     */
    public function setCountry(\Back\ReferentielBundle\Entity\Country $country = null)
    {
        $this->country = $country ;

        return $this ;
    }

    /**
     * Get country
     *
     * @return \Back\ReferentielBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country ;
    }

    /**
     * Set image
     *
     * @param \Back\ReferentielBundle\Entity\Media $image
     * @return City
     */
    public function setImage(\Back\ReferentielBundle\Entity\Media $image)
    {
        $this->image = $image ;

        return $this ;
    }

    /**
     * Get image
     *
     * @return \Back\ReferentielBundle\Entity\Media 
     */
    public function getImage()
    {
        return $this->image ;
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
     * @return City
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
}
