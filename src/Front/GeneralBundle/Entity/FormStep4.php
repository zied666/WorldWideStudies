<?php

namespace Front\GeneralBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormStep4
 *
 * @ORM\Table(name="wws_form_step4")
 * @ORM\Entity
 */
class FormStep4
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
     * @var boolean
     *
     * @ORM\Column(name="specialNeeds", type="boolean", nullable=true)
     */
    private $specialNeeds;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="text",nullable=true)
     */
    private $comments;

    /**
     * @var boolean
     *
     * @ORM\Column(name="term1", type="boolean")
     */
    private $term1;

    /**
     * @var boolean
     *
     * @ORM\Column(name="term2", type="boolean")
     */
    private $term2;

    /**
     * @ORM\OneToOne(targetEntity="FormStep3", mappedBy="formStep4")
     * */
    private $formStep3;

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
     * Set specialNeeds
     *
     * @param boolean $specialNeeds
     * @return FormStep4
     */
    public function setSpecialNeeds($specialNeeds)
    {
        $this->specialNeeds=$specialNeeds;

        return $this;
    }

    /**
     * Get specialNeeds
     *
     * @return boolean 
     */
    public function getSpecialNeeds()
    {
        return $this->specialNeeds;
    }

    /**
     * Set comments
     *
     * @param string $comments
     * @return FormStep4
     */
    public function setComments($comments)
    {
        $this->comments=$comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set term1
     *
     * @param boolean $term1
     * @return FormStep4
     */
    public function setTerm1($term1)
    {
        $this->term1=$term1;

        return $this;
    }

    /**
     * Get term1
     *
     * @return boolean 
     */
    public function getTerm1()
    {
        return $this->term1;
    }

    /**
     * Set term2
     *
     * @param boolean $term2
     * @return FormStep4
     */
    public function setTerm2($term2)
    {
        $this->term2=$term2;

        return $this;
    }

    /**
     * Get term2
     *
     * @return boolean 
     */
    public function getTerm2()
    {
        return $this->term2;
    }

    /**
     * Set formStep3
     *
     * @param \Front\GeneralBundle\Entity\FormStep3 $formStep3
     * @return FormStep4
     */
    public function setFormStep3(\Front\GeneralBundle\Entity\FormStep3 $formStep3=null)
    {
        $this->formStep3=$formStep3;

        return $this;
    }

    /**
     * Get formStep3
     *
     * @return \Front\GeneralBundle\Entity\FormStep3 
     */
    public function getFormStep3()
    {
        return $this->formStep3;
    }

    public function showSpecialNeeds()
    {
        if($this->specialNeeds)
            return 'Yes';
        else
            return 'No';
    }
}
