<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Pay
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PayRepository")
 *
 */
class Pay
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $pay_id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $number;

    /**
     * @ORM\Column(type="date")
     */
    private $date_bank;

    /**
     * @ORM\Column(type="date")
     */
    private $date_client;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $sumpay;

    /**
     * @ORM\ManyToOne(targetEntity="Currency", inversedBy="pay", cascade={"persist"})
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="currency_id", onDelete="CASCADE")
     */
    private $currency_id;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('0', '1')" )
     */
    private $type;


    /**
     * @ORM\ManyToOne(targetEntity="Pay", inversedBy="pay", cascade={"persist"})
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="pay_id")
     */
    private $parent_id;

    /**
     * @ORM\ManyToOne(targetEntity="Account", inversedBy="pay", cascade={"persist"})
     * @ORM\JoinColumn(name="account_id", referencedColumnName="account_id", onDelete="CASCADE")
     */
    private $account_id;

    /**
     * @ORM\Column(type="string")
     */
    private $fiopay;

    /**
     * @ORM\Column(type="string")
     */
    private $aimpay;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_curr;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $actual_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;
  

    /**
     * Get pay_id
     *
     * @return integer 
     */
    public function getPayId()
    {
        return $this->pay_id;
    }

    /**
     * Set number
     *
     * @param string $number
     * @return Pay
     */
    public function setNumber($number)
    {
        $this->number = $number;
    
        return $this;
    }

    /**
     * Get number
     *
     * @return string 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set date_bank
     *
     * @param \DateTime $dateBank
     * @return Pay
     */
    public function setDateBank($dateBank)
    {
        $this->date_bank = $dateBank;
    
        return $this;
    }

    /**
     * Get date_bank
     *
     * @return \DateTime 
     */
    public function getDateBank()
    {
        return $this->date_bank;
    }

    /**
     * Set date_client
     *
     * @param \DateTime $dateClient
     * @return Pay
     */
    public function setDateClient($dateClient)
    {
        $this->date_client = $dateClient;
    
        return $this;
    }

    /**
     * Get date_client
     *
     * @return \DateTime 
     */
    public function getDateClient()
    {
        return $this->date_client;
    }

    /**
     * Set sumpay
     *
     * @param string $sumpay
     * @return Pay
     */
    public function setSumpay($sumpay)
    {
        $this->sumpay = $sumpay;
    
        return $this;
    }

    /**
     * Get sumpay
     *
     * @return string 
     */
    public function getSumpay()
    {
        return $this->sumpay;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Pay
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set fiopay
     *
     * @param string $fiopay
     * @return Pay
     */
    public function setFiopay($fiopay)
    {
        $this->fiopay = $fiopay;
    
        return $this;
    }

    /**
     * Get fiopay
     *
     * @return string 
     */
    public function getFiopay()
    {
        return $this->fiopay;
    }

    /**
     * Set aimpay
     *
     * @param string $aimpay
     * @return Pay
     */
    public function setAimpay($aimpay)
    {
        $this->aimpay = $aimpay;
    
        return $this;
    }

    /**
     * Get aimpay
     *
     * @return string 
     */
    public function getAimpay()
    {
        return $this->aimpay;
    }

    /**
     * Set date_curr
     *
     * @param \DateTime $dateCurr
     * @return Pay
     */
    public function setDateCurr($dateCurr)
    {
        $this->date_curr = $dateCurr;
    
        return $this;
    }

    /**
     * Get date_curr
     *
     * @return \DateTime 
     */
    public function getDateCurr()
    {
        return $this->date_curr;
    }

    /**
     * Set actual_id
     *
     * @param integer $actualId
     * @return Pay
     */
    public function setActualId($actualId)
    {
        $this->actual_id = $actualId;
    
        return $this;
    }

    /**
     * Get actual_id
     *
     * @return integer 
     */
    public function getActualId()
    {
        return $this->actual_id;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     * @return Pay
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;
    
        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set currency_id
     *
     * @param \AppBundle\Entity\Currency $currencyId
     * @return Pay
     */
    public function setCurrencyId(\AppBundle\Entity\Currency $currencyId = null)
    {
        $this->currency_id = $currencyId;
    
        return $this;
    }

    /**
     * Get currency_id
     *
     * @return \AppBundle\Entity\Currency 
     */
    public function getCurrencyId()
    {
        return $this->currency_id;
    }

    /**
     * Set account_id
     *
     * @param \AppBundle\Entity\Account $accountId
     * @return Pay
     */
    public function setAccountId(\AppBundle\Entity\Account $accountId = null)
    {
        $this->account_id = $accountId;
    
        return $this;
    }

    /**
     * Get account_id
     *
     * @return \AppBundle\Entity\Account 
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     * Set parent_id
     *
     * @param \AppBundle\Entity\Pay $parentId
     * @return Pay
     */
    public function setParentId(\AppBundle\Entity\Pay $parentId = null)
    {
        $this->parent_id = $parentId;
    
        return $this;
    }

    /**
     * Get parent_id
     *
     * @return \AppBundle\Entity\Pay 
     */
    public function getParentId()
    {
        return $this->parent_id;
    }
}
