<?php

namespace Back\ReferentielBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Currency
 *
 * @ORM\Table(name="wws_currency")
 * @ORM\Entity
 */
class Currency
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
     * @ORM\Column(name="code", type="string", length=100)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="symbol", type="string", length=3)
     */
    private $symbol;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="scale", type="integer")
     */
    private $scale;

    /**
     * @ORM\OneToMany(targetEntity="Country", mappedBy="currency")
     */
    protected $countries;


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
     * @return Currency
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
     * Set symbol
     *
     * @param string $symbol
     * @return Currency
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * Get symbol
     *
     * @return string 
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Currency
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
        return $this->name.' - '.$this->code;
    }

    /**
     * Set scale
     *
     * @param integer $scale
     * @return Currency
     */
    public function setScale($scale)
    {
        $this->scale = $scale;

        return $this;
    }

    /**
     * Get scale
     *
     * @return integer 
     */
    public function getScale()
    {
        return $this->scale;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->countries = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add countries
     *
     * @param \Back\ReferentielBundle\Entity\Country $countries
     * @return Currency
     */
    public function addCountry(\Back\ReferentielBundle\Entity\Country $countries)
    {
        $this->countries[] = $countries;

        return $this;
    }

    /**
     * Remove countries
     *
     * @param \Back\ReferentielBundle\Entity\Country $countries
     */
    public function removeCountry(\Back\ReferentielBundle\Entity\Country $countries)
    {
        $this->countries->removeElement($countries);
    }

    /**
     * Get countries
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCountries()
    {
        return $this->countries;
    }
}
