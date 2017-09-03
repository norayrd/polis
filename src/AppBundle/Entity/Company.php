<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Company
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompanyRepository")
 *
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $company_id;

    /**
     * @ORM\Column(type="string", unique=true )
     */
    private $comp_name;

    /**
     * 1 - Insurance company; 2 - Agent Company
     * @ORM\Column(type="string", columnDefinition="ENUM('1', '2')" )
     */
    private $type;

    /**
     * Maximal polis count limit
     * @ORM\Column(type="integer", options={"defoult": "12"} )
     */
    private $polis_count_limit;

    /**
     * @ORM\Column(type="datetime", options={"default": "0000-00-00 00:00:00"} )
     */
    private $date_begin_fact;

    /**
     * @ORM\Column(type="datetime", options={"default": "9999-12-31 23:59:59"})
     */
    private $date_end_fact;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $actual_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $user_id2;



    /**
     * Get company_id
     *
     * @return integer 
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * Set comp_name
     *
     * @param string $compName
     * @return Company
     */
    public function setCompName($compName)
    {
        $this->comp_name = $compName;
    
        return $this;
    }

    /**
     * Get comp_name
     *
     * @return string 
     */
    public function getCompName()
    {
        return $this->comp_name;
    }

    /**
     * Set date_begin_fact
     *
     * @param \DateTime $dateBeginFact
     * @return Company
     */
    public function setDateBeginFact($dateBeginFact)
    {
        $this->date_begin_fact = $dateBeginFact;
    
        return $this;
    }

    /**
     * Get date_begin_fact
     *
     * @return \DateTime 
     */
    public function getDateBeginFact()
    {
        return $this->date_begin_fact;
    }

    /**
     * Set date_end_fact
     *
     * @param \DateTime $dateEndFact
     * @return Company
     */
    public function setDateEndFact($dateEndFact)
    {
        $this->date_end_fact = $dateEndFact;

        return $this;
    }

    /**
     * Get date_end_fact
     *
     * @return \DateTime 
     */
    public function getDateEndFact()
    {
        return $this->date_end_fact;
    }

    /**
     * Set actual_id
     *
     * @param integer $actualId
     * @return Company
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
     * Set user_id1
     *
     * @param integer $userId1
     * @return Company
     */
    public function setUserId1($userId1)
    {
        $this->user_id1 = $userId1;
    
        return $this;
    }

    /**
     * Get user_id1
     *
     * @return integer 
     */
    public function getUserId1()
    {
        return $this->user_id1;
    }

    /**
     * Set user_id2
     *
     * @param integer $userId2
     * @return Company
     */
    public function setUserId2($userId2)
    {
        $this->user_id2 = $userId2;
    
        return $this;
    }

    /**
     * Get user_id2
     *
     * @return integer 
     */
    public function getUserId2()
    {
        return $this->user_id2;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Company
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
     * Set polis_count_limit
     *
     * @param string $polisCountLimit
     * @return Company
     */
    public function setPolisCountLimit($polisCountLimit)
    {
        $this->polis_count_limit = $polisCountLimit;
    
        return $this;
    }

    /**
     * Get polis_count_limit
     *
     * @return string 
     */
    public function getPolisCountLimit()
    {
        return $this->polis_count_limit;
    }
}
