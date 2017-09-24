<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * IKey
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IKeyRepository")
 *
 */
class IKey
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $i_key;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     */
    private $company_id;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $date_curr;

    /**
     * @ORM\Column(type="json_array")
     */
    private $data = array();

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

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
     * Set i_key
     *
     * @param string $iKey
     * @return IKey
     */
    public function setIKey($iKey)
    {
        $this->i_key = $iKey;
    
        return $this;
    }

    /**
     * Get i_key
     *
     * @return string 
     */
    public function getIKey()
    {
        return $this->i_key;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return IKey
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set date_curr
     *
     * @param DateTime $dateCurr
     * @return IKey
     */
    public function setDateCurr($dateCurr)
    {
        $this->date_curr = $dateCurr;
    
        return $this;
    }

    /**
     * Get date_curr
     *
     * @return DateTime 
     */
    public function getDateCurr()
    {
        return $this->date_curr;
    }

    /**
     * Set data
     *
     * @param array $data
     * @return IKey
     */
    public function setData($data)
    {
        $this->data = $data;
    
        return $this;
    }

    /**
     * Get data
     *
     * @return array 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set company_id
     *
     * @param integer $companyId
     * @return IKey
     */
    public function setCompanyId($companyId)
    {
        $this->company_id = $companyId;
    
        return $this;
    }

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
     * Set user_id
     *
     * @param integer $userId
     * @return IKey
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
