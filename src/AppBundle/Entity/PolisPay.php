<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * PolisPay
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PolisPayRepository")
 *
 */
class PolisPay
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $polis_pay_id;

    /**
     * @ORM\ManyToOne(targetEntity="Pay", inversedBy="polispay", cascade={"persist"})
     * @ORM\JoinColumn(name="pay_id", referencedColumnName="pay_id", onDelete="CASCADE")
     */
    private $pay_id;

    /**
     * @ORM\ManyToOne(targetEntity="Polis", inversedBy="polispay", cascade={"persist"})
     * @ORM\JoinColumn(name="polis_id", referencedColumnName="polis_id", onDelete="CASCADE")
     */
    private $polis_id;

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
     * Get polis_pay_id
     *
     * @return integer 
     */
    public function getPolisPayId()
    {
        return $this->polis_pay_id;
    }

    /**
     * Set date_curr
     *
     * @param \DateTime $dateCurr
     * @return PolisPay
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
     * @return PolisPay
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
     * @return PolisPay
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
     * Set pay_id
     *
     * @param \AppBundle\Entity\Pay $payId
     * @return PolisPay
     */
    public function setPayId(\AppBundle\Entity\Pay $payId = null)
    {
        $this->pay_id = $payId;
    
        return $this;
    }

    /**
     * Get pay_id
     *
     * @return \AppBundle\Entity\Pay 
     */
    public function getPayId()
    {
        return $this->pay_id;
    }

    /**
     * Set polis_id
     *
     * @param \AppBundle\Entity\PolisPay $polisId
     * @return PolisPay
     */
    public function setPolisId(\AppBundle\Entity\PolisPay $polisId = null)
    {
        $this->polis_id = $polisId;
    
        return $this;
    }

    /**
     * Get polis_id
     *
     * @return \AppBundle\Entity\PolisPay 
     */
    public function getPolisId()
    {
        return $this->polis_id;
    }
}
