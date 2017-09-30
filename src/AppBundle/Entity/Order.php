<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Order
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
 *
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $order_id;

    /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="Order", cascade={"persist"})
     * @ORM\JoinColumn(name="parent", referencedColumnName="order_id")
     */
    private $parent;
    
    /**
     * @ORM\Column(type="string" )
     */
    private $numbers;

    /**
     * @ORM\Column(type="string" )
     */
    private $pay_numbers;

    /**
     * @ORM\Column(type="date" )
     */
    private $date_begin;

    /**
     * @ORM\Column(type="date" )
     */
    private $date_end;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('10', '20', '30', '40', '50', '60', '110', '120', '130', '140', '150', '160')" )
     * 10 - приход
     * 20 - дозаказ
     * 30 - реестр полисов
     * 40 - возврат чистых
     * 50 - возврат порченых
     * 60 - утерянные
     * 110 - приход (между своими)
     * 120 - дозаказ (между своими)
     * 130 - реестр полисов (между своими)
     * 140 - возврат чистых (между своими)
     * 150 - возврат порченых (между своими)
     * 160 - утерянные (между своими)
     */
    private $type;
    
    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="Order", cascade={"persist"})
     * @ORM\JoinColumn(name="company_from", referencedColumnName="company_id")
     */
    private $company_from;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="Order", cascade={"persist"})
     * @ORM\JoinColumn(name="user_from", referencedColumnName="id")
     */
    private $user_from;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('0', '1')" )
     * 10 - запрос
     * 20 - отказ
     * 30 - добро
     * 40 - отправлено
     * 50 - получено
     */
    private $user_sign_from;
    
    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="Order", cascade={"persist"})
     * @ORM\JoinColumn(name="company_to", referencedColumnName="company_id")
     */
    private $company_to;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="Order", cascade={"persist"})
     * @ORM\JoinColumn(name="user_to", referencedColumnName="id")
     */
    private $user_to;
    
    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('0', '1')" )
     */
    private $user_sign_to;

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
     * Set numbers
     *
     * @param string $numbers
     * @return Order
     */
    public function setNumbers($numbers)
    {
        $this->numbers = $numbers;
    
        return $this;
    }

    /**
     * Get numbers
     *
     * @return string 
     */
    public function getNumbers()
    {
        return $this->numbers;
    }

    /**
     * Set pay_numbers
     *
     * @param string $payNumbers
     * @return Order
     */
    public function setPayNumbers($payNumbers)
    {
        $this->pay_numbers = $payNumbers;
    
        return $this;
    }

    /**
     * Get pay_numbers
     *
     * @return string 
     */
    public function getPayNumbers()
    {
        return $this->pay_numbers;
    }

    /**
     * Set date_begin
     *
     * @param \DateTime $dateBegin
     * @return Order
     */
    public function setDateBegin($dateBegin)
    {
        $this->date_begin = $dateBegin;
    
        return $this;
    }

    /**
     * Get date_begin
     *
     * @return \DateTime 
     */
    public function getDateBegin()
    {
        return $this->date_begin;
    }

    /**
     * Set date_end
     *
     * @param \DateTime $dateEnd
     * @return Order
     */
    public function setDateEnd($dateEnd)
    {
        $this->date_end = $dateEnd;
    
        return $this;
    }

    /**
     * Get date_end
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->date_end;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Order
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
     * Set user_sign_from
     *
     * @param string $userSignFrom
     * @return Order
     */
    public function setUserSignFrom($userSignFrom)
    {
        $this->user_sign_from = $userSignFrom;
    
        return $this;
    }

    /**
     * Get user_sign_from
     *
     * @return string 
     */
    public function getUserSignFrom()
    {
        return $this->user_sign_from;
    }

    /**
     * Set user_sign_to
     *
     * @param string $userSignTo
     * @return Order
     */
    public function setUserSignTo($userSignTo)
    {
        $this->user_sign_to = $userSignTo;
    
        return $this;
    }

    /**
     * Get user_sign_to
     *
     * @return string 
     */
    public function getUserSignTo()
    {
        return $this->user_sign_to;
    }

    /**
     * Set date_curr
     *
     * @param \DateTime $dateCurr
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * Set company_from
     *
     * @param \AppBundle\Entity\Company $companyFrom
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * @return Order
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
     * Set parent
     *
     * @param \AppBundle\Entity\Order $parent
     * @return Order
     */
    public function setParent(\AppBundle\Entity\Order $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return \AppBundle\Entity\Order 
     */
    public function getParent()
    {
        return $this->parent;
    }
}
