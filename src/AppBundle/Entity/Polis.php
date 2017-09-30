<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;


/**
 * Polis
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PolisRepository")
 *
 */
class Polis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $polis_id;

    /**
     * @ORM\Column(type="string")
     */
    private $polis_num;

    /**
     * @ORM\Column(type="date")
     */
    private $polis_date;

    /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="Polis", cascade={"persist"})
     * @ORM\JoinColumn(name="order", referencedColumnName="order_id")
     */
    private $order;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $sum;

    /**
     * @ORM\Column(type="string")
     */
    private $fio;

    /**
     * @ORM\Column(type="integer")
     */
    private $agent_id;

    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="Polis", cascade={"persist"})
     * @ORM\JoinColumn(name="company_id", referencedColumnName="company_id")
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
     * Get polis_id
     *
     * @return integer 
     */
    public function getPolisId()
    {
        return $this->polis_id;
    }

    /**
     * Set polis_num
     *
     * @param string $polisNum
     * @return Polis
     */
    public function setPolisNum($polisNum)
    {
        $this->polis_num = $polisNum;
    
        return $this;
    }

    /**
     * Get polis_num
     *
     * @return string 
     */
    public function getPolisNum()
    {
        return $this->polis_num;
    }

    /**
     * Set polis_date
     *
     * @param \DateTime $polisDate
     * @return Polis
     */
    public function setPolisDate($polisDate)
    {
        $this->polis_date = $polisDate;
    
        return $this;
    }

    /**
     * Get polis_date
     *
     * @return \DateTime 
     */
    public function getPolisDate()
    {
        return $this->polis_date;
    }

    /**
     * Set sum
     *
     * @param string $sum
     * @return Polis
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
    
        return $this;
    }

    /**
     * Get sum
     *
     * @return string 
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * Set fio
     *
     * @param string $fio
     * @return Polis
     */
    public function setFio($fio)
    {
        $this->fio = $fio;
    
        return $this;
    }

    /**
     * Get fio
     *
     * @return string 
     */
    public function getFio()
    {
        return $this->fio;
    }

    /**
     * Set agent_id
     *
     * @param integer $agentId
     * @return Polis
     */
    public function setAgentId($agentId)
    {
        $this->agent_id = $agentId;
    
        return $this;
    }

    /**
     * Get agent_id
     *
     * @return integer 
     */
    public function getAgentId()
    {
        return $this->agent_id;
    }

    /**
     * Set date_curr
     *
     * @param \DateTime $dateCurr
     * @return Polis
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
     * @return Polis
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
     * @return Polis
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
     * Set order
     *
     * @param \AppBundle\Entity\Order $order
     * @return Polis
     */
    public function setOrder(\AppBundle\Entity\Order $order = null)
    {
        $this->order = $order;
    
        return $this;
    }

    /**
     * Get order
     *
     * @return \AppBundle\Entity\Order 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set company_id
     *
     * @param \AppBundle\Entity\Company $companyId
     * @return Polis
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
