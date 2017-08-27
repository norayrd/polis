<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Account
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AccountRepository")
 *
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $account_id;

    /**
     * @ORM\Column(type="string" )
     */
    private $acc_name;

    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="Account", cascade={"persist"})
     * @ORM\JoinColumn(name="company_id", referencedColumnName="company_id", onDelete="CASCADE")
     */
    private $company_id;

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
     * Get account_id
     *
     * @return integer 
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     * Set acc_name
     *
     * @param string $accName
     * @return Account
     */
    public function setAccName($accName)
    {
        $this->acc_name = $accName;
    
        return $this;
    }

    /**
     * Get acc_name
     *
     * @return string 
     */
    public function getAccName()
    {
        return $this->acc_name;
    }

    /**
     * Set date_curr
     *
     * @param \DateTime $dateCurr
     * @return Account
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
     * @return Account
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
     * @return Account
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
     * Set company_id
     *
     * @param \AppBundle\Entity\Company $companyId
     * @return Account
     */
    public function setCompanyId(\AppBundle\Entity\Company $companyId = null)
    {
        $this->company_id = $companyId;
    
        return $this;
    }

    /**
     * Get company_id
     *
     * @return \AppBundle\Entity\Company 
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }
}
