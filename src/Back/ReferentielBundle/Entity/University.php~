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
}
