<?php

namespace Back\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AboutAs
 *
 * @ORM\Table(name="wws_front_aboutus")
 * @ORM\Entity
 */
class AboutAs
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
     * @ORM\Column(name="title1", type="string", length=255)
     */
    private $title1;

    /**
     * @var string
     *
     * @ORM\Column(name="text1", type="text")
     */
    private $text1;
    
    /**
     * @ORM\OneToOne(targetEntity="Back\ReferentielBundle\Entity\Media", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image1 ;

    /**
     * @var string
     *
     * @ORM\Column(name="title2", type="string", length=255)
     */
    private $title2;

    /**
     * @var string
     *
     * @ORM\Column(name="text2", type="text")
     */
    private $text2;
    
    /**
     * @ORM\OneToOne(targetEntity="Back\ReferentielBundle\Entity\Media", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image2 ;

    /**
     * @var string
     *
     * @ORM\Column(name="title3", type="string", length=255)
     */
    private $title3;

    /**
     * @var string
     *
     * @ORM\Column(name="text3", type="text")
     */
    private $text3;
    
    /**
     * @ORM\OneToOne(targetEntity="Back\ReferentielBundle\Entity\Media", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $image3 ;


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
     * Set title1
     *
     * @param string $title1
     * @return AboutAs
     */
    public function setTitle1($title1)
    {
        $this->title1 = $title1;

        return $this;
    }

    /**
     * Get title1
     *
     * @return string 
     */
    public function getTitle1()
    {
        return $this->title1;
    }

    /**
     * Set text1
     *
     * @param string $text1
     * @return AboutAs
     */
    public function setText1($text1)
    {
        $this->text1 = $text1;

        return $this;
    }

    /**
     * Get text1
     *
     * @return string 
     */
    public function getText1()
    {
        return $this->text1;
    }

    /**
     * Set title2
     *
     * @param string $title2
     * @return AboutAs
     */
    public function setTitle2($title2)
    {
        $this->title2 = $title2;

        return $this;
    }

    /**
     * Get title2
     *
     * @return string 
     */
    public function getTitle2()
    {
        return $this->title2;
    }

    /**
     * Set text2
     *
     * @param string $text2
     * @return AboutAs
     */
    public function setText2($text2)
    {
        $this->text2 = $text2;

        return $this;
    }

    /**
     * Get text2
     *
     * @return string 
     */
    public function getText2()
    {
        return $this->text2;
    }

    /**
     * Set title3
     *
     * @param string $title3
     * @return AboutAs
     */
    public function setTitle3($title3)
    {
        $this->title3 = $title3;

        return $this;
    }

    /**
     * Get title3
     *
     * @return string 
     */
    public function getTitle3()
    {
        return $this->title3;
    }

    /**
     * Set text3
     *
     * @param string $text3
     * @return AboutAs
     */
    public function setText3($text3)
    {
        $this->text3 = $text3;

        return $this;
    }

    /**
     * Get text3
     *
     * @return string 
     */
    public function getText3()
    {
        return $this->text3;
    }

    /**
     * Set image1
     *
     * @param \Back\ReferentielBundle\Entity\Media $image1
     * @return AboutAs
     */
    public function setImage1(\Back\ReferentielBundle\Entity\Media $image1 = null)
    {
        $this->image1 = $image1;

        return $this;
    }

    /**
     * Get image1
     *
     * @return \Back\ReferentielBundle\Entity\Media 
     */
    public function getImage1()
    {
        return $this->image1;
    }

    /**
     * Set image2
     *
     * @param \Back\ReferentielBundle\Entity\Media $image2
     * @return AboutAs
     */
    public function setImage2(\Back\ReferentielBundle\Entity\Media $image2 = null)
    {
        $this->image2 = $image2;

        return $this;
    }

    /**
     * Get image2
     *
     * @return \Back\ReferentielBundle\Entity\Media 
     */
    public function getImage2()
    {
        return $this->image2;
    }

    /**
     * Set image3
     *
     * @param \Back\ReferentielBundle\Entity\Media $image3
     * @return AboutAs
     */
    public function setImage3(\Back\ReferentielBundle\Entity\Media $image3 = null)
    {
        $this->image3 = $image3;

        return $this;
    }

    /**
     * Get image3
     *
     * @return \Back\ReferentielBundle\Entity\Media 
     */
    public function getImage3()
    {
        return $this->image3;
    }
}
