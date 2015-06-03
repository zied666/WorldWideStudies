<?php

namespace Back\ReferentielBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Paypal
 *
 * @ORM\Table(name="wws_paypal")
 * @ORM\Entity
 */
class Paypal
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
     * @ORM\Column(name="account", type="string", length=255)
     */
    private $account;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="testMode", type="boolean", nullable=true)
     */
    private $testMode;


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
     * Set account
     *
     * @param string $account
     * @return Paypal
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return string 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set testMode
     *
     * @param boolean $testMode
     * @return Paypal
     */
    public function setTestMode($testMode)
    {
        $this->testMode = $testMode;

        return $this;
    }

    /**
     * Get testMode
     *
     * @return boolean 
     */
    public function getTestMode()
    {
        return $this->testMode;
    }
}
