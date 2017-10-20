<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * InvoiceSignBtn
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InvoiceSignBtnRepository")
 *
 */
class InvoiceSignBtn
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $btn_id;

    /**
     * @ORM\Column(type="integer" )
     */
    private $invoice_sign_id;

    /**
     * @ORM\Column(type="integer" )
     */
    private $set_invoice_sign_id;

    /**
     * @ORM\Column(type="string" )
     */
    private $icon;

    /**
     * @ORM\Column(type="string" )
     */
    private $color;

    /**
     * @ORM\Column(type="string" )
     */
    private $btn_name;


    /**
     * Get btn_id
     *
     * @return integer 
     */
    public function getBtnId()
    {
        return $this->btn_id;
    }

    /**
     * Set invoice_sign_id
     *
     * @param integer $invoiceSignId
     * @return InvoiceSignBtn
     */
    public function setInvoiceSignId($invoiceSignId)
    {
        $this->invoice_sign_id = $invoiceSignId;
    
        return $this;
    }

    /**
     * Get invoice_sign_id
     *
     * @return integer 
     */
    public function getInvoiceSignId()
    {
        return $this->invoice_sign_id;
    }

    /**
     * Set set_invoice_sign_id
     *
     * @param integer $setInvoiceSignId
     * @return InvoiceSignBtn
     */
    public function setSetInvoiceSignId($setInvoiceSignId)
    {
        $this->set_invoice_sign_id = $setInvoiceSignId;
    
        return $this;
    }

    /**
     * Get set_invoice_sign_id
     *
     * @return integer 
     */
    public function getSetInvoiceSignId()
    {
        return $this->set_invoice_sign_id;
    }

    /**
     * Set icon
     *
     * @param string $icon
     * @return InvoiceSignBtn
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    
        return $this;
    }

    /**
     * Get icon
     *
     * @return string 
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return InvoiceSignBtn
     */
    public function setColor($color)
    {
        $this->color = $color;
    
        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set btn_name
     *
     * @param string $btnName
     * @return InvoiceSignBtn
     */
    public function setBtnName($btnName)
    {
        $this->btn_name = $btnName;
    
        return $this;
    }

    /**
     * Get btn_name
     *
     * @return string 
     */
    public function getBtnName()
    {
        return $this->btn_name;
    }
}
