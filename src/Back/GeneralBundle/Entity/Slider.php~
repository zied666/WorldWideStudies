<?php

namespace Back\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Slider
 *
 * @ORM\Table(name="wws_front_slider")
 * @ORM\Entity
 */
class Slider
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
     * @ORM\OneToOne(targetEntity="Back\ReferentielBundle\Entity\Media", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image ;

    /**
     * @var integer
     *
     * @ORM\Column(name="ordre", type="integer")
     */
    private $ordre;


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
     * Set ordre
     *
     * @param integer $ordre
     * @return Slider
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return integer 
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set image
     *
     * @param \Back\ReferentielBundle\Entity\Media $image
     * @return Slider
     */
    public function setImage(\Back\ReferentielBundle\Entity\Media $image = null)
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
}
