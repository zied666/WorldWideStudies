<?php

namespace Back\HotelTunisieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\validator\Constraints as Assert;

/**
 * Media
 *
 * @ORM\Table("ost_media")
 * @ORM\Entity
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
    private $id;

    /**
     * @var \DateTime
     * 
     * @ORM\COlumn(name="updated_at",type="datetime", nullable=true) 
     */
    private $updateAt;

    /**
     * @ORM\ManyToOne(targetEntity="Ville", inversedBy="images")
     * @ORM\JoinColumn(name="ville_id", referencedColumnName="id", nullable=true)
     */
    protected $ville;

    /**
     * @ORM\ManyToOne(targetEntity="Hotel", inversedBy="images")
     * @ORM\JoinColumn(name="Hotel_id", referencedColumnName="id", nullable=true)
     */
    protected $hotel;

    /**
     * @ORM\PostLoad()
     */
    public function postLoad()
    {
        $this->updateAt=new \DateTime();
    }

    /**
     * @ORM\Column(type="integer", options={"default":1}, nullable=true) 
     */
    public $type;

    /**
     * @ORM\Column(type="string",length=255, nullable=true) 
     */
    public $path;
    
    
    public $file;

    /**
     * @ORM\Column(type="integer") 
     */
    public $ordre;

    public function getUploadRootDir()
    {
        return __dir__.'/../../../../web/'.$this->getDirectory();
    }

    public function getDirectory()
    {
        if($this->hotel)
            return 'uploads/hotel';
        if($this->ville)
            return 'uploads/ville';
        else
            return 'uploads';
    }

    public function getAssetPath()
    {
        return $this->getDirectory().'/'.$this->path;
    }

    public function getAbsolutePath()
    {
        return null===$this->path?null:$this->getUploadRootDir().'/'.$this->path;
    }

    /**
     * @ORM\Prepersist()
     * @ORM\Preupdate() 
     */
    public function preUpload()
    {
        $this->tempFile=$this->getAbsolutePath();
        $this->oldFile=$this->getPath();
        $this->updateAt=new \DateTime();

        if(null!==$this->file)
            $this->path=sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate() 
     */
    public function upload()
    {
        if(null!==$this->file)
        {
            $this->file->move($this->getUploadRootDir(), $this->path);
            unset($this->file);
            if($this->oldFile!=null&&file_exists($this->tempFile))
                unlink($this->tempFile);
        }
    }

    /**
     * @ORM\PreRemove() 
     */
    public function preRemoveUpload()
    {
        $this->tempFile=$this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove() 
     */
    public function removeUpload()
    {
        if(file_exists($this->tempFile))
            unlink($this->tempFile);
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getType()
    {
        return $this->type;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     * @return Media
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt=$updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime 
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Media
     */
    public function setType($type)
    {
        $this->type=$type;

        return $this;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Media
     */
    public function setPath($path)
    {
        $this->path=$path;

        return $this;
    }

    /**
     * Set ville
     *
     * @param \Back\HotelTunisieBundle\Entity\ville $ville
     * @return Media
     */
    public function setVille(\Back\HotelTunisieBundle\Entity\ville $ville=null)
    {
        $this->ville=$ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return \Back\HotelTunisieBundle\Entity\ville 
     */
    public function getVille()
    {
        return $this->ville;
    }
    
    
    public function showType()
    {
        if($this->type==1)
            return 'Pricipale';
        if($this->type==2)
            return 'Album';
        
    }


    /**
     * Set ordre
     *
     * @param \ordre $ordre
     * @return Media
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return \ordre 
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * Set hotel
     *
     * @param \Back\HotelTunisieBundle\Entity\Hotel $hotel
     * @return Media
     */
    public function setHotel(\Back\HotelTunisieBundle\Entity\Hotel $hotel = null)
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * Get hotel
     *
     * @return \Back\HotelTunisieBundle\Entity\Hotel 
     */
    public function getHotel()
    {
        return $this->hotel;
    }
}
