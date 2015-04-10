<?php

namespace Back\ReferentielBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="wws_country")
 * @ORM\Entity
 */
class Country
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
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=10)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity="City", mappedBy="country")
     */
    protected $Citys;

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
     * Set libelle
     *
     * @param string $libelle
     * @return Country
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Country
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }
    
    public function __toString()
    {
        return $this->libelle;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Citys = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add Citys
     *
     * @param \Back\ReferentielBundle\Entity\City $citys
     * @return Country
     */
    public function addCity(\Back\ReferentielBundle\Entity\City $citys)
    {
        $this->Citys[] = $citys;

        return $this;
    }

    /**
     * Remove Citys
     *
     * @param \Back\ReferentielBundle\Entity\City $citys
     */
    public function removeCity(\Back\ReferentielBundle\Entity\City $citys)
    {
        $this->Citys->removeElement($citys);
    }

    /**
     * Get Citys
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCitys()
    {
        return $this->Citys;
    }
}
