<?php

namespace Back\ReferentielBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Qualification
 *
 * @ORM\Table(name="wws_qualification")
 * @ORM\Entity
 */
class Qualification
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
     * @ORM\ManyToOne(targetEntity="Back\ReferentielBundle\Entity\Level")
     */
    protected $level;

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
     * @return Qualification
     */
    public function setName($name)
    {
        $this->name=$name;

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
     * To string
     * @return string 
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set level
     *
     * @param \Back\ReferentielBundle\Entity\Level $level
     * @return Qualification
     */
    public function setLevel(\Back\ReferentielBundle\Entity\Level $level=null)
    {
        $this->level=$level;

        return $this;
    }

    /**
     * Get level
     *
     * @return \Back\ReferentielBundle\Entity\Level 
     */
    public function getLevel()
    {
        return $this->level;
    }

}
