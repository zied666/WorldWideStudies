<?php

namespace Front\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormStep3
 *
 * @ORM\Table(name="wws_form_step3")
 * @ORM\Entity
 */
class FormStep3
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
     * @var integer
     *
     * @ORM\Column(name="sourceFunding", type="integer")
     */
    private $sourceFunding;

    /**
     * @var string
     *
     * @ORM\Column(name="addressLine1", type="string", length=255)
     */
    private $addressLine1;

    /**
     * @var string
     *
     * @ORM\Column(name="addressLine2", type="string", length=255,nullable=true)
     */
    private $addressLine2;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=255,nullable=true)
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="postal", type="string", length=255,nullable=true)
     */
    private $postal;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @var boolean
     *
     * @ORM\Column(name="currently", type="boolean", nullable=true)
     */
    private $currently;

    /**
     * @ORM\OneToOne(targetEntity="FormStep2", mappedBy="formStep3")
     * */
    private $formStep2;

    /**
     * @ORM\OneToOne(targetEntity="FormStep4", inversedBy="formStep3")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * */
    private $formStep4;

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
     * Set sourceFunding
     *
     * @param integer $sourceFunding
     * @return FormStep3
     */
    public function setSourceFunding($sourceFunding)
    {
        $this->sourceFunding=$sourceFunding;

        return $this;
    }

    /**
     * Get sourceFunding
     *
     * @return integer 
     */
    public function getSourceFunding()
    {
        return $this->sourceFunding;
    }

    /**
     * Set addressLine1
     *
     * @param string $addressLine1
     * @return FormStep3
     */
    public function setAddressLine1($addressLine1)
    {
        $this->addressLine1=$addressLine1;

        return $this;
    }

    /**
     * Get addressLine1
     *
     * @return string 
     */
    public function getAddressLine1()
    {
        return $this->addressLine1;
    }

    /**
     * Set addressLine2
     *
     * @param string $addressLine2
     * @return FormStep3
     */
    public function setAddressLine2($addressLine2)
    {
        $this->addressLine2=$addressLine2;

        return $this;
    }

    /**
     * Get addressLine2
     *
     * @return string 
     */
    public function getAddressLine2()
    {
        return $this->addressLine2;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return FormStep3
     */
    public function setCity($city)
    {
        $this->city=$city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return FormStep3
     */
    public function setRegion($region)
    {
        $this->region=$region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set postal
     *
     * @param string $postal
     * @return FormStep3
     */
    public function setPostal($postal)
    {
        $this->postal=$postal;

        return $this;
    }

    /**
     * Get postal
     *
     * @return string 
     */
    public function getPostal()
    {
        return $this->postal;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return FormStep3
     */
    public function setCountry($country)
    {
        $this->country=$country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set currently
     *
     * @param boolean $currently
     * @return FormStep3
     */
    public function setCurrently($currently)
    {
        $this->currently=$currently;

        return $this;
    }

    /**
     * Get currently
     *
     * @return boolean 
     */
    public function getCurrently()
    {
        return $this->currently;
    }

    /**
     * Set formStep2
     *
     * @param \Front\GeneralBundle\Entity\FormStep2 $formStep2
     * @return FormStep3
     */
    public function setFormStep2(\Front\GeneralBundle\Entity\FormStep2 $formStep2=null)
    {
        $this->formStep2=$formStep2;

        return $this;
    }

    /**
     * Get formStep2
     *
     * @return \Front\GeneralBundle\Entity\FormStep2 
     */
    public function getFormStep2()
    {
        return $this->formStep2;
    }

    /**
     * Set formStep4
     *
     * @param \Front\GeneralBundle\Entity\FormStep4 $formStep4
     * @return FormStep3
     */
    public function setFormStep4(\Front\GeneralBundle\Entity\FormStep4 $formStep4=null)
    {
        $this->formStep4=$formStep4;

        return $this;
    }

    /**
     * Get formStep4
     *
     * @return \Front\GeneralBundle\Entity\FormStep4 
     */
    public function getFormStep4()
    {
        return $this->formStep4;
    }

}
