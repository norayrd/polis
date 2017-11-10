<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;


/**
 * InvoiceData
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InvoiceDataRepository")
 *
 */
class InvoiceData
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $invoice_data_id;

    /**
     * @ORM\ManyToOne(targetEntity="Invoice", inversedBy="InvoiceData", cascade={"persist"})
     * @ORM\JoinColumn(name="invoice", referencedColumnName="invoice_id", nullable=false)
     */
    private $invoice;

    /**
     * @ORM\ManyToOne(targetEntity="InvoiceDataType", inversedBy="InvoiceData", cascade={"persist"})
     * @ORM\JoinColumn(name="invoice_data_type", referencedColumnName="invoice_data_type_id", nullable=false)
     */
    private $invoice_data_type;
    
    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="InvoiceData", cascade={"persist"})
     * @ORM\JoinColumn(name="company", referencedColumnName="company_id")
     */
    private $company;
    
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nomen;

    /**
     * @ORM\Column(type="string")
     */
    private $title;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $number_from;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $number_to;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_from;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_to;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $fio;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2)
     */
    private $cost;

    /**
     * @ORM\Column(type="integer")
     */
    private $count;

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
     * Get invoice_data_id
     *
     * @return integer 
     */
    public function getInvoiceDataId()
    {
        return $this->invoice_data_id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return InvoiceData
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
     * Set number_from
     *
     * @param string $numberFrom
     * @return InvoiceData
     */
    public function setNumberFrom($numberFrom)
    {
        $this->number_from = $numberFrom;
    
        return $this;
    }

    /**
     * Get number_from
     *
     * @return string 
     */
    public function getNumberFrom()
    {
        return $this->number_from;
    }

    /**
     * Set number_to
     *
     * @param string $numberTo
     * @return InvoiceData
     */
    public function setNumberTo($numberTo)
    {
        $this->number_to = $numberTo;
    
        return $this;
    }

    /**
     * Get number_to
     *
     * @return string 
     */
    public function getNumberTo()
    {
        return $this->number_to;
    }

    /**
     * Set fio
     *
     * @param string $fio
     * @return InvoiceData
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
     * Set cost
     *
     * @param string $cost
     * @return InvoiceData
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    
        return $this;
    }

    /**
     * Get cost
     *
     * @return string 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set count
     *
     * @param integer $count
     * @return InvoiceData
     */
    public function setCount($count)
    {
        $this->count = $count;
    
        return $this;
    }

    /**
     * Get count
     *
     * @return integer 
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set date_curr
     *
     * @param \DateTime $dateCurr
     * @return InvoiceData
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
     * @return InvoiceData
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
     * @return InvoiceData
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
     * Set invoice_data_type
     *
     * @param \AppBundle\Entity\InvoiceDataType $invoiceDataType
     * @return InvoiceData
     */
    public function setInvoiceDataType(\AppBundle\Entity\InvoiceDataType $invoiceDataType)
    {
        $this->invoice_data_type = $invoiceDataType;
    
        return $this;
    }

    /**
     * Get invoice_data_type
     *
     * @return \AppBundle\Entity\InvoiceDataType 
     */
    public function getInvoiceDataType()
    {
        return $this->invoice_data_type;
    }

    /**
     * Set company
     *
     * @param \AppBundle\Entity\Company $company
     * @return InvoiceData
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

    /**
     * Set nomen
     *
     * @param \AppBundle\Entity\Nomen $nomen
     * @return InvoiceData
     */
    public function setNomen(\AppBundle\Entity\Nomen $nomen = null)
    {
        $this->nomen = $nomen;
    
        return $this;
    }

    /**
     * Get nomen
     *
     * @return \AppBundle\Entity\Nomen 
     */
    public function getNomen()
    {
        return $this->nomen;
    }

    /**
     * Set date_from
     *
     * @param \DateTime $dateFrom
     * @return InvoiceData
     */
    public function setDateFrom($dateFrom)
    {
        $this->date_from = $dateFrom;
    
        return $this;
    }

    /**
     * Get date_from
     *
     * @return \DateTime 
     */
    public function getDateFrom()
    {
        return $this->date_from;
    }

    /**
     * Set date_to
     *
     * @param \DateTime $dateTo
     * @return InvoiceData
     */
    public function setDateTo($dateTo)
    {
        $this->date_to = $dateTo;
    
        return $this;
    }

    /**
     * Get date_to
     *
     * @return \DateTime 
     */
    public function getDateTo()
    {
        return $this->date_to;
    }

    /**
     * Set invoice
     *
     * @param \AppBundle\Entity\Invoice $invoice
     * @return InvoiceData
     */
    public function setInvoice(\AppBundle\Entity\Invoice $invoice)
    {
        $this->invoice = $invoice;
    
        return $this;
    }

    /**
     * Get invoice
     *
     * @return \AppBundle\Entity\Invoice 
     */
    public function getInvoice()
    {
        return $this->invoice;
    }
}
