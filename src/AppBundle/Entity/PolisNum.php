<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * PolisNum
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PolisNumRepository")
 *
 */
class PolisNum
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $polis_num_id;

    /**
     * @ORM\Column(type="string" )
     */
    private $num_start;

    /**
     * @ORM\Column(type="string" )
     */
    private $num_end;

    /**
     * @ORM\Column(type="date" )
     */
    private $date_begin;

    /**
     * @ORM\Column(type="date" )
     */
    private $date_end;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('0', '1')" )
     */
    private $closed;

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
     * Get polis_num_id
     *
     * @return integer 
     */
    public function getPolisNumId()
    {
        return $this->polis_num_id;
    }

    /**
     * Set num_start
     *
     * @param string $numStart
     * @return PolisNum
     */
    public function setNumStart($numStart)
    {
        $this->num_start = $numStart;
    
        return $this;
    }

    /**
     * Get num_start
     *
     * @return string 
     */
    public function getNumStart()
    {
        return $this->num_start;
    }

    /**
     * Set num_end
     *
     * @param string $numEnd
     * @return PolisNum
     */
    public function setNumEnd($numEnd)
    {
        $this->num_end = $numEnd;
    
        return $this;
    }

    /**
     * Get num_end
     *
     * @return string 
     */
    public function getNumEnd()
    {
        return $this->num_end;
    }

    /**
     * Set date_begin
     *
     * @param \DateTime $dateBegin
     * @return PolisNum
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
     * @return PolisNum
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
     * Set closed
     *
     * @param string $closed
     * @return PolisNum
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;
    
        return $this;
    }

    /**
     * Get closed
     *
     * @return string 
     */
    public function getClosed()
    {
        return $this->closed;
    }

    /**
     * Set date_curr
     *
     * @param \DateTime $dateCurr
     * @return PolisNum
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
     * @return PolisNum
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
     * @return PolisNum
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
}
