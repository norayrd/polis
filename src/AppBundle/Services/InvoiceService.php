<?php

namespace AppBundle\Services;

use AppBundle\Entity\InvoiceData;
use DateTime;

class InvoiceService {
    
    private $em;
    private $logger;
    private $container;
    
    public function __construct($logger, $em, $container ) {

        $this->em = $em;
        $this->logger = $logger;
        $this->container = $container;

    }

    public function cloneEntity( $user, $pEntity) {
        
        $oldEntity = clone $pEntity;
        $this->em->detach($oldEntity);
        
        return $oldEntity;
    }
    
    public function getInvoiceList( $user ) {
        
        $qb = $this->em->createQueryBuilder();
        
        $qb->select('i')
            ->from('AppBundle:Invoice', 'i')
            ->where('(i.actual_id is null)'
                    .'and (  (i.company_create=:company_id)'
                    .'     or(i.company_from=:company_id)'
                    .'     or(i.company_to = :company_id and i.invoice_sign>0)'
                    .'    )'
                    )
            ->setParameter('company_id', $user->getCompany()->getCompanyId());
        
        return $qb->getQuery()->getResult();

    }

    public function getInvoiceById( $user, $pinvoiceId) {
        
        $invoice = array();
                
        if (is_numeric($pinvoiceId)) {
            $invoice = $this->em->getRepository('AppBundle:Invoice') -> findOneBy(array('invoice_id' => $pinvoiceId));
        }

        return $invoice;
    }
    
    public function getInvoiceSignById( $user, $invoiceSignId) {

        return $this->em->getRepository('AppBundle:InvoiceSign') -> findOneBy(array('invoice_sign_id' => $invoiceSignId));
    }

    public function getInvoiceSignBtnById( $user, $btnId) {

        return $this->em->getRepository('AppBundle:InvoiceSignBtn') -> findOneBy(array('btn_id' => $btnId));
    }

    public function saveInvoice( $user, $pInvoice, $oldInvoice = null) {
        
        if (is_object($oldInvoice)) {
            $oldInvoice->setActualId($pInvoice->getInvoiceId());
            $this->em->persist($oldInvoice);
        }

        $pInvoice->setDateCurr(new DateTime());
        $pInvoice->setUserId($user->getId());
        
        $this->em->persist($pInvoice);
        $this->em->flush();

        return true;
    }

    public function getInvoiceTypeById( $user, $invoiceTypeId) {

        return $this->em->getRepository('AppBundle:InvoiceType') -> findOneBy(array('invoice_type_id' => $invoiceTypeId));
    }
    
    public function saveInvoiceContent( $user,  $invoice, $invoiceContent) {
        
        //var_dump($invoiceContent);exit;
        
        if (is_object($invoice) && is_object($invoiceContent) && (count($invoiceContent)>0)) {
            
            $invoiceDataType1 = $this->em->getRepository('AppBundle:InvoiceDataType') -> findOneBy(array('invoice_data_type_id' => 1));
            $invoiceDataType2 = $this->em->getRepository('AppBundle:InvoiceDataType') -> findOneBy(array('invoice_data_type_id' => 2));
            
            foreach ($invoiceContent as $key => $invC) {
                $invoiceData = new InvoiceData();
                
                //var_dump($invC->sel);
                
                if ( isset($invC->sel->deleted) && ($invC->sel->deleted==1) ) { //deleting
                    
                    if (isset($invC ->invoiceDataId->value)) {
                    
                        $invoiceData = $this->em->getRepository('AppBundle:InvoiceData') -> findOneBy(array('invoice_data_id' => $invC ->invoiceDataId ->value));
                        if (is_object($invoiceData)) {
                            $oldInvoiceData = $this->cloneEntity($user, $invoiceData);
                            $oldInvoiceData ->setActualId($invoiceData->getInvoiceDataId());
                            $this -> em->persist($oldInvoiceData);

                            $invoiceData ->setActualId($invoiceData->getInvoiceDataId());
                            $invoiceData ->setDateCurr(new DateTime());
                            $invoiceData ->setUserId($user->getId());
                            $this -> em->persist($invoiceData);
                        }
                    }
                    
                } else if (isset($invC ->invoiceDataId->value)) { //updating
                    
                    $invoiceData = $this->em->getRepository('AppBundle:InvoiceData') -> findOneBy(array('invoice_data_id' => $invC ->invoiceDataId ->value));
                    
                    if (is_object($invoiceData)) {
                        $oldInvoiceData = $this->cloneEntity($user, $invoiceData);
                        $oldInvoiceData ->setActualId($invoiceData->getInvoiceDataId());

                        $invoiceData ->setInvoiceDataType($invoiceDataType1);
                        $invoiceData ->setTitle( $invC ->title ->text);

                        if (isset($invC ->fio ->text)) {
                            $invoiceData ->setFio( $invC ->fio ->text);
                        }
                        
                        $invoiceData ->setNumberFrom($invC ->numberFrom ->value);
                        $invoiceData ->setNumberTo($invC ->numberTo ->value);

                        if ($invC ->dateFrom ->value !== '') {
                            $invoiceData ->setDateFrom(new DateTime( $invC ->dateFrom ->value ) );
                        } else {
                            $invoiceData ->setDateFrom(null);
                        }
                        
                        if ($invC ->dateTo ->value !== '') {
                            $invoiceData ->setDateTo(new DateTime( $invC ->dateTo ->value ));
                        } else {
                            $invoiceData ->setDateTo(null);
                        }
                        
                        $invoiceData ->setCost($invC ->cost ->text);
                        $invoiceData ->setCount($invC ->count ->text);

                        if ($invC ->type ->value == 1) {
                            $invoiceData ->setInvoiceDataType($invoiceDataType1);
                        } else if ($invC ->type ->value == 2) {
                            $invoiceData ->setInvoiceDataType($invoiceDataType2);
                        } else {
                            $invoiceData ->setInvoiceDataType(null);
                        }

                        $invoiceData ->setDateCurr(new DateTime());
                        $invoiceData ->setUserId($user->getId());
                        
                        //if ($oldInvoiceData != $invoiceData) {
                            $this -> em->persist($oldInvoiceData);
                            $this->em->persist($invoiceData);
                        //}

                    }

                } else if (!isset($invC ->invoiceDataId->value)) {  //inserting
                
                    $company = $this->em->getRepository('AppBundle:Company') -> findOneBy(array('company_id' => $invC->company->value));

                    $invoiceData ->setInvoice($invoice);
                    $invoiceData ->setInvoiceDataType($invoiceDataType1);
                    $invoiceData ->setCompany($company);
                    $invoiceData ->setNomenId( $invC ->sel ->nomen);
                    $invoiceData ->setTitle( $invC ->title ->text);
                    
                    if (isset($invC ->sel ->parent)) {
                        $invoiceData ->setParentId( $invC ->sel ->parent);
                    }

                    if (isset($invC ->fio ->text)) {
                        $invoiceData ->setFio( $invC ->fio ->text);
                    }

                    $invoiceData ->setNumberFrom($invC ->numberFrom ->value);
                    $invoiceData ->setNumberTo($invC ->numberTo ->value);
                    
                    if ($invC ->dateFrom ->value !== '') {
                        $invoiceData ->setDateFrom(new DateTime( $invC ->dateFrom ->value ) );
                    } else {
                        $invoiceData ->setDateFrom(null);
                    }

                    if ($invC ->dateTo ->value !== '') {
                        $invoiceData ->setDateTo(new DateTime( $invC ->dateTo ->value ));
                    } else {
                        $invoiceData ->setDateTo(null);
                    }

                    $invoiceData ->setCost($invC ->cost ->text);
                    $invoiceData ->setCount($invC ->count ->text);
                    
                    if ($invC ->type ->value == 1) {
                        $invoiceData ->setInvoiceDataType($invoiceDataType1);
                    } else if ($invC ->type ->value == 2) {
                        $invoiceData ->setInvoiceDataType($invoiceDataType2);
                    } else {
                        $invoiceData ->setInvoiceDataType(null);
                    }
                    
                    $invoiceData ->setDateCurr(new DateTime());
                    $invoiceData ->setUserId($user->getId());
                    
                    $this->em->persist($invoiceData);
                
                }
            }
        }
        
        $this->em->flush();

        return true;
    }
                    
    public function getBackReasonById( $user, $backReasonId) {

        return $this->em->getRepository('AppBundle:BackReason') -> findOneBy(array('back_reason_id' => $backReasonId));
    }
    
    public function getBackReasonList( $user) {

        return $this->em->getRepository('AppBundle:BackReason') -> findBy(array());
    }

}
