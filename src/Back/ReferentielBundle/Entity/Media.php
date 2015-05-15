<?php

namespace Back\ReferentielBundle\Entity ;

use Doctrine\ORM\Mapping as ORM ;
use Symfony\Component\validator\Constraints as Assert ;

/**
 * Media
 *
 * @ORM\Table("wws_media")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Media
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
     * @var \DateTime
     * 
     * @ORM\COlumn(name="updated_at",type="datetime", nullable=true) 
     */
    private $updateAt ;
    
    /**
     * @ORM\ManyToOne(targetEntity="Back\SchoolBundle\Entity\SchoolLocation", inversedBy="photos")
     */
    protected $schoolLocation ;
    
    /**
     * @ORM\ManyToOne(targetEntity="Back\AccommodationBundle\Entity\Accommodation", inversedBy="photos")
     */
    protected $accommodation ;
    
    /**
     * @ORM\ManyToOne(targetEntity="Back\UniversityBundle\Entity\University", inversedBy="photos")
     */
    protected $university ;

    /**
     * @ORM\PostLoad()
     */
    public function postLoad()
    {
        $this->updateAt = new \DateTime() ;
    }

    /**
     * @ORM\Column(type="string",length=255, nullable=true) 
     */
    private $path ;
    public $file ;

    public function getUploadRootDir()
    {
        return __dir__ . '/../../../../web/uploads' ;
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path ;
    }

    public function getAssetPath()
    {
        return 'uploads/' . $this->path ;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate() 
     */
    public function preUpload()
    {
        $this->tempFile = $this->getAbsolutePath() ;
        $this->oldFile = $this->getPath() ;
        $this->updateAt = new \DateTime() ;

        if (null !== $this->file)
            $this->path = sha1(uniqid(mt_rand() , true)) . '.' . $this->file->guessExtension() ;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate() 
     */
    public function upload()
    {
        if (null !== $this->file)
        {
            $this->file->move($this->getUploadRootDir() , $this->path) ;
            unset($this->file) ;

            if ($this->oldFile != null)
                unlink($this->tempFile) ;
        }
    }

    /**
     * @ORM\PreRemove() 
     */
    public function preRemoveUpload()
    {
        $this->tempFile = $this->getAbsolutePath() ;
    }

    /**
     * @ORM\PostRemove() 
     */
    public function removeUpload()
    {
        if (file_exists($this->tempFile))
            unlink($this->tempFile) ;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id ;
    }

    public function getPath()
    {
        return $this->path ;
    }

    public function getName()
    {
        return $this->name ;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     * @return Media
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt ;

        return $this ;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime 
     */
    public function getUpdateAt()
    {
        return $this->updateAt ;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Media
     */
    public function setName($name)
    {
        $this->name = $name ;

        return $this ;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Media
     */
    public function setPath($path)
    {
        $this->path = $path ;

        return $this ;
    }


    /**
     * Set schoolLocation
     *
     * @param \Back\SchoolBundle\Entity\SchoolLocation $schoolLocation
     * @return Media
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

    /**
     * Set accommodation
     *
     * @param \Back\AccommodationBundle\Entity\Accommodation $accommodation
     * @return Media
     */
    public function setAccommodation(\Back\AccommodationBundle\Entity\Accommodation $accommodation = null)
    {
        $this->accommodation = $accommodation;

        return $this;
    }

    /**
     * Get accommodation
     *
     * @return \Back\AccommodationBundle\Entity\Accommodation, 
     */
    public function getAccommodation()
    {
        return $this->accommodation;
    }

    /**
     * Set university
     *
     * @param \Back\UniversityBundle\Entity\University $university
     * @return Media
     */
    public function setUniversity(\Back\UniversityBundle\Entity\University $university = null)
    {
        $this->university = $university;

        return $this;
    }

    /**
     * Get university
     *
     * @return \Back\UniversityBundle\Entity\University 
     */
    public function getUniversity()
    {
        return $this->university;
    }
}
