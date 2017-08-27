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
     * @ORM\Column(type="string" )
     */
    private $comp_name;

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
     * Set date_curr
     *
     * @param \DateTime $dateCurr
     * @return Company
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
     * Set user_id
     *
     * @param integer $userId
     * @return Company
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
