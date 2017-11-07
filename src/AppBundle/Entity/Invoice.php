<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;


/**
 * Invoice
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InvoiceRepository")
 *
 */
class Invoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $invoice_id;

    /**
     * @ORM\Column(type="date")
     */
    private $invoice_date;
    
    /**
     * @ORM\ManyToOne(targetEntity="InvoiceType", inversedBy="Invoice", cascade={"persist"})
     * @ORM\JoinColumn(name="invoice_type", referencedColumnName="invoice_type_id", nullable=false)
     */
    private $invoice_type;
    
    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="Invoice", cascade={"persist"})
     * @ORM\JoinColumn(name="company_from", referencedColumnName="company_id")
     */
    private $company_from;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="Invoice", cascade={"persist"})
     * @ORM\JoinColumn(name="user_from", referencedColumnName="id")
     */
    private $user_from;

    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="Invoice", cascade={"persist"})
     * @ORM\JoinColumn(name="company_to", referencedColumnName="company_id")
     */
    private $company_to;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="Invoice", cascade={"persist"})
     * @ORM\JoinColumn(name="user_to", referencedColumnName="id")
     */
    private $user_to;
    
    /**
     * @ORM\ManyToOne(targetEntity="InvoiceSign", inversedBy="Invoice", cascade={"persist"})
     * @ORM\JoinColumn(name="invoice_sign", referencedColumnName="invoice_sign_id")
     */
    private $invoice_sign;
    
    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="Invoice", cascade={"persist"})
     * @ORM\JoinColumn(name="company_create", referencedColumnName="company_id")
     */
    private $company_create;
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="Invoice", cascade={"persist"})
     * @ORM\JoinColumn(name="user_create", referencedColumnName="id")
     */
    private $user_create;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $fio_to;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $fio_from;

    /**
     * @ORM\OneToMany(targetEntity="InvoiceData", mappedBy="invoice", cascade={"persist"})
     */
    private $invoiceData;

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
     * Get invoice_id
     *
     * @return integer 
     */
    public function getInvoiceId()
    {
        return $this->invoice_id;
    }

    /**
     * Set invoice_date
     *
     * @param \DateTime $invoiceDate
     * @return Invoice
     */
    public function setInvoiceDate($invoiceDate)
    {
        $this->invoice_date = $invoiceDate;
    
        return $this;
    }

    /**
     * Get invoice_date
     *
     * @return \DateTime 
     */
    public function getInvoiceDate()
    {
        return $this->invoice_date;
    }

    /**
     * Set date_curr
     *
     * @param \DateTime $dateCurr
     * @return Invoice
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
     * @return Invoice
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
     * @return Invoice
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
     * Set invoice_type
     *
     * @param \AppBundle\Entity\InvoiceType $invoiceType
     * @return Invoice
     */
    public function setInvoiceType(\AppBundle\Entity\InvoiceType $invoiceType)
    {
        $this->invoice_type = $invoiceType;
    
        return $this;
    }

    /**
     * Get invoice_type
     *
     * @return \AppBundle\Entity\InvoiceType 
     */
    public function getInvoiceType()
    {
        return $this->invoice_type;
    }

    /**
     * Set company_from
     *
     * @param \AppBundle\Entity\Company $companyFrom
     * @return Invoice
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
     * @return Invoice
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
     * @return Invoice
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
     * @return Invoice
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
     * Set invoice_sign
     *
     * @param \AppBundle\Entity\InvoiceSign $invoiceSign
     * @return Invoice
     */
    public function setInvoiceSign(\AppBundle\Entity\InvoiceSign $invoiceSign = null)
    {
        $this->invoice_sign = $invoiceSign;
    
        return $this;
    }

    /**
     * Get invoice_sign
     *
     * @return \AppBundle\Entity\InvoiceSign 
     */
    public function getInvoiceSign()
    {
        return $this->invoice_sign;
    }

    /**
     * Set company_create
     *
     * @param \AppBundle\Entity\Company $companyCreate
     * @return Invoice
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
     * @return Invoice
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

    /**
     * Set fio_to
     *
     * @param string $fioTo
     * @return Invoice
     */
    public function setFioTo($fioTo)
    {
        $this->fio_to = $fioTo;
    
        return $this;
    }

    /**
     * Get fio_to
     *
     * @return string 
     */
    public function getFioTo()
    {
        return $this->fio_to;
    }

    /**
     * Set fio_from
     *
     * @param string $fioFrom
     * @return Invoice
     */
    public function setFioFrom($fioFrom)
    {
        $this->fio_from = $fioFrom;
    
        return $this;
    }

    /**
     * Get fio_from
     *
     * @return string 
     */
    public function getFioFrom()
    {
        return $this->fio_from;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->invoiceData = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add invoiceData
     *
     * @param \AppBundle\Entity\InvoiceData $invoiceData
     * @return Invoice
     */
    public function addInvoiceDatum(\AppBundle\Entity\InvoiceData $invoiceData)
    {
        $this->invoiceData[] = $invoiceData;
    
        return $this;
    }

    /**
     * Remove invoiceData
     *
     * @param \AppBundle\Entity\InvoiceData $invoiceData
     */
    public function removeInvoiceDatum(\AppBundle\Entity\InvoiceData $invoiceData)
    {
        $this->invoiceData->removeElement($invoiceData);
    }

    /**
     * Get invoiceData
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInvoiceData()
    {
        return $this->invoiceData;
    }
}
