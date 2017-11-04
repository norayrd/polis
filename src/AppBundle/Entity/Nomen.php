<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;


/**
 * Nomen
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NomenRepository")
 *
 */
class Nomen
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $nomen_id;

    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="Nomen", cascade={"persist"})
     * @ORM\JoinColumn(name="company", referencedColumnName="company_id")
     */
    private $company;
    
    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $form;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $form_pack;

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
     * Get nomen_id
     *
     * @return integer 
     */
    public function getNomenId()
    {
        return $this->nomen_id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Nomen
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set form
     *
     * @param array $form
     * @return Nomen
     */
    public function setForm($form)
    {
        $this->form = $form;
    
        return $this;
    }

    /**
     * Get form
     *
     * @return array 
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Set form_pack
     *
     * @param array $formPack
     * @return Nomen
     */
    public function setFormPack($formPack)
    {
        $this->form_pack = $formPack;
    
        return $this;
    }

    /**
     * Get form_pack
     *
     * @return array 
     */
    public function getFormPack()
    {
        return $this->form_pack;
    }

    /**
     * Set date_curr
     *
     * @param \DateTime $dateCurr
     * @return Nomen
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
     * @return Nomen
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
     * @return Nomen
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
     * Set company
     *
     * @param \AppBundle\Entity\Company $company
     * @return Nomen
     */
    public function setCompany(\AppBundle\Entity\Company $company = null)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get company
     *
     * @return \AppBundle\Entity\Company 
     */
    public function getCompany()
    {
        return $this->company;
    }
}
