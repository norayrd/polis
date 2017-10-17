<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Orders
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrdersRepository")
 *
 */
class Orders
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $order_id;

    /**
     * @ORM\Column(type="date" )
     */
    private $order_date;

    /**
     * @ORM\ManyToOne(targetEntity="OrderType", inversedBy="Orders", cascade={"persist"})
     * @ORM\JoinColumn(name="order_type", referencedColumnName="order_type_id", nullable=false)
     */
    private $order_type;
    
    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="Orders", cascade={"persist"})
     * @ORM\JoinColumn(name="company_from", referencedColumnName="company_id")
     */
    private $company_from;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="Orders", cascade={"persist"})
     * @ORM\JoinColumn(name="user_from", referencedColumnName="id")
     */
    private $user_from;

    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="Orders", cascade={"persist"})
     * @ORM\JoinColumn(name="company_to", referencedColumnName="company_id")
     */
    private $company_to;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="Orders", cascade={"persist"})
     * @ORM\JoinColumn(name="user_to", referencedColumnName="id")
     */
    private $user_to;
    
    /**
     * @ORM\ManyToOne(targetEntity="OrderSign", inversedBy="Orders", cascade={"persist"})
     * @ORM\JoinColumn(name="order_sign", referencedColumnName="order_sign_id")
     */
    private $order_sign;

    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="Orders", cascade={"persist"})
     * @ORM\JoinColumn(name="company_create", referencedColumnName="company_id")
     */
    private $company_create;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="Orders", cascade={"persist"})
     * @ORM\JoinColumn(name="user_create", referencedColumnName="id")
     */
    private $user_create;

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
     * Get order_id
     *
     * @return integer 
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * Get order_id
     *
     * @return integer 
     */
    public function setOrderIdToNull()
    {
        $this->id = null;
    
        return $this;
    }



    /**
     * Set order_date
     *
     * @param \DateTime $orderDate
     * @return Orders
     */
    public function setOrderDate($orderDate)
    {
        $this->order_date = $orderDate;
    
        return $this;
    }

    /**
     * Get order_date
     *
     * @return \DateTime 
     */
    public function getOrderDate()
    {
        return $this->order_date;
    }

    /**
     * Set date_curr
     *
     * @param \DateTime $dateCurr
     * @return Orders
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
     * @return Orders
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
     * @return Orders
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
     * Set order_type
     *
     * @param \AppBundle\Entity\OrderType $orderType
     * @return Orders
     */
    public function setOrderType(\AppBundle\Entity\OrderType $orderType)
    {
        $this->order_type = $orderType;
    
        return $this;
    }

    /**
     * Get order_type
     *
     * @return \AppBundle\Entity\OrderType 
     */
    public function getOrderType()
    {
        return $this->order_type;
    }

    /**
     * Set company_from
     *
     * @param \AppBundle\Entity\Company $companyFrom
     * @return Orders
     */
    public function setCompanyFrom(\AppBundle\Entity\Company $companyFrom = null)
    {
        $this->company_from = $companyFrom;
    
        return $this;
    }

    /**
     * Get company_from
     *
     * @return \AppBundle\Entity\Company 
     */
    public function getCompanyFrom()
    {
        return $this->company_from;
    }

    /**
     * Set user_from
     *
     * @param \AppBundle\Entity\User $userFrom
     * @return Orders
     */
    public function setUserFrom(\AppBundle\Entity\User $userFrom = null)
    {
        $this->user_from = $userFrom;
    
        return $this;
    }

    /**
     * Get user_from
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUserFrom()
    {
        return $this->user_from;
    }

    /**
     * Set company_to
     *
     * @param \AppBundle\Entity\Company $companyTo
     * @return Orders
     */
    public function setCompanyTo(\AppBundle\Entity\Company $companyTo = null)
    {
        $this->company_to = $companyTo;
    
        return $this;
    }

    /**
     * Get company_to
     *
     * @return \AppBundle\Entity\Company 
     */
    public function getCompanyTo()
    {
        return $this->company_to;
    }

    /**
     * Set user_to
     *
     * @param \AppBundle\Entity\User $userTo
     * @return Orders
     */
    public function setUserTo(\AppBundle\Entity\User $userTo = null)
    {
        $this->user_to = $userTo;
    
        return $this;
    }

    /**
     * Get user_to
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUserTo()
    {
        return $this->user_to;
    }

    /**
     * Set order_sign
     *
     * @param \AppBundle\Entity\OrderSign $orderSign
     * @return Orders
     */
    public function setOrderSign(\AppBundle\Entity\OrderSign $orderSign = null)
    {
        $this->order_sign = $orderSign;
    
        return $this;
    }

    /**
     * Get order_sign
     *
     * @return \AppBundle\Entity\OrderSign 
     */
    public function getOrderSign()
    {
        return $this->order_sign;
    }

    /**
     * Set company_create
     *
     * @param \AppBundle\Entity\Company $companyCreate
     * @return Orders
     */
    public function setCompanyCreate(\AppBundle\Entity\Company $companyCreate = null)
    {
        $this->company_create = $companyCreate;
    
        return $this;
    }

    /**
     * Get company_create
     *
     * @return \AppBundle\Entity\Company 
     */
    public function getCompanyCreate()
    {
        return $this->company_create;
    }

    /**
     * Set user_create
     *
     * @param \AppBundle\Entity\User $userCreate
     * @return Orders
     */
    public function setUserCreate(\AppBundle\Entity\User $userCreate = null)
    {
        $this->user_create = $userCreate;
    
        return $this;
    }

    /**
     * Get user_create
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUserCreate()
    {
        return $this->user_create;
    }
}
