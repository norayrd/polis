<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Invoice;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{

    /**
     * @Route("/invoice-list", name="invoice_list")
     */
    public function invoiceListAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $userRoles = array();
        
        if (!$is_guest) {
            $userRoles = $this->getUser() -> getRoles();
        }
        
        if ($is_guest || empty($userRoles)) {
            return $this->redirect('/desktop');
        }

        $invoiceService = $this->get("invoice_service");

        $invoiceList = $invoiceService ->getInvoiceList($this->getUser());
        
        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'АКТы и Отчеты', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('invoice/invoice_list.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'pinvoicelist' => $invoiceList,
        ));
        
        
    }
    
    /**
     * @Route("/invoice-view", name="invoice_view")
     */
    public function invoiceViewAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $pinvoiceId = $request ->get("pinvoiceid");
        $ptype = $request ->get("type");
        
        $companyService = $this->get("company_service");
        $invoiceService = $this->get("invoice_service");
        $personService = $this->get("person_service");
        
        //--------------------------
        //access rights
        // submit button
        $can_view_all = true;
        $can_view_self = true;
        $can_edit = true;
        
        //--------------------------
        
        $pinvoice = $invoiceService ->getInvoiceById($this->getUser(), $pinvoiceId );
        if (is_numeric($pinvoiceId) && is_object($pinvoice)) {
            $ptype = $pinvoice->getInvoiceType()->getInvoiceTypeId();
        }
        
        $isCenter = ($this->getUser()->getCompany()->getType() == 1);
        $isAgent = ($this->getUser()->getCompany()->getType() == 3);
        $myCompany = $this->getUser()->getCompany();
        $myParentCompany = $this->getUser()->getCompany()->getParent();
        
        $iCreater = is_object($pinvoice) && ($pinvoice->getCompanyCreate()->getCompanyId() == $myCompany->getCompanyId());

        
        $agentCompanyList = $companyService ->getAgentCompanyes($this->getUser());
        $insuranceCompanyList = $companyService ->getInsuranceCompanyes($this->getUser());

        if ( is_object($pinvoice) && !$iCreater ) {
            $fromCompanyList = array($pinvoice ->getCompanyFrom());
            $toCompanyList = array($pinvoice ->getCompanyTo());

        } elseif ($isCenter) {
        
            if ($ptype == '10') {
                $fromCompanyList = $insuranceCompanyList;
                $toCompanyList = array($myCompany);

            } elseif ($ptype == '20') {
                $fromCompanyList = array($myCompany);
                $toCompanyList = $insuranceCompanyList;

            } elseif ($ptype == '30') {
                $fromCompanyList = array($myCompany);
                $toCompanyList = $agentCompanyList;

            } elseif ($ptype == '40') {
                $fromCompanyList = $agentCompanyList;
                $toCompanyList = array($myCompany);

            } elseif ($ptype == '50') {
                $fromCompanyList = $agentCompanyList;
                $toCompanyList = array($myCompany);

            } elseif ($ptype == '60') {
                $fromCompanyList = array($myCompany);
                $toCompanyList = $insuranceCompanyList;

            }
            
        } elseif ($isAgent) {
        
            if ($ptype == '30') {
                $fromCompanyList = array($myParentCompany);
                $toCompanyList = array($myCompany);

            } elseif ($ptype == '40') {
                $fromCompanyList = array($myCompany);
                $toCompanyList = array($myParentCompany);

            } elseif ($ptype == '50') {
                $fromCompanyList = array($myCompany);
                $toCompanyList = array($myParentCompany);

            }
        }
        
        $submitBtn1 = null;
        $submitBtn2 = null;
        $submitBtn3 = null;
        $submitBtn4 = null;
        
        
        $ourInvoice = ($pinvoice) && ($pinvoice->getCompanyCreate()->getCompanyId() == $this->getUser()->getCompany()->getCompanyId() );
        if ($pinvoice) {
            $invoiceSignId = $pinvoice->getInvoiceSign()->getInvoiceSignId();
        } else {
            $invoiceSignId = null;
        }
        
        
        if ($pinvoiceId == 'new') {
            $submitBtn1 = $invoiceService ->getInvoiceSignBtnById($this->getUser(),0);
            $submitBtn2 = $invoiceService ->getInvoiceSignBtnById($this->getUser(),10);
            
        } else if (
                ($pinvoiceId > 0) && 
                is_object($pinvoice) &&
                ($invoiceSignId == -10) && 
                $ourInvoice
                ) {

            $submitBtn1 = $invoiceService ->getInvoiceSignBtnById($this->getUser(),-11);
            
        } else if (
                ($pinvoiceId > 0) && 
                is_object($pinvoice) &&
                ($invoiceSignId == 0) && 
                $ourInvoice
                ) {

            $submitBtn1 = $invoiceService ->getInvoiceSignBtnById($this->getUser(),-10);
            $submitBtn2 = $invoiceService ->getInvoiceSignBtnById($this->getUser(),0);
            $submitBtn3 = $invoiceService ->getInvoiceSignBtnById($this->getUser(),10);
            
        } else if (
                ($pinvoiceId > 0) && 
                is_object($pinvoice) &&
                ($invoiceSignId == 10) && 
                $ourInvoice
                ) {
            
            $submitBtn1 = $invoiceService ->getInvoiceSignBtnById($this->getUser(),11);
            $submitBtn2 = $invoiceService ->getInvoiceSignBtnById($this->getUser(),20);
            
        } else if (
                ($pinvoiceId > 0) && 
                is_object($pinvoice) &&
                ($invoiceSignId == 20) && 
                $ourInvoice
                ) {
            
            $submitBtn1 = $invoiceService ->getInvoiceSignBtnById($this->getUser(),21);
            
        }
        //---------------------
         else if (
                ($pinvoiceId > 0) && 
                is_object($pinvoice) &&
                ($invoiceSignId == 20) && 
                !$ourInvoice
                ) {
            
            $submitBtn1 = $invoiceService ->getInvoiceSignBtnById($this->getUser(),30);
            
        } else if (
                ($pinvoiceId > 0) && 
                is_object($pinvoice) &&
                ($invoiceSignId == 30) && 
                !$ourInvoice
                ) {
            
            $submitBtn1 = $invoiceService ->getInvoiceSignBtnById($this->getUser(),31);
            
        }
        
        $pInvoiceType = $invoiceService ->getInvoiceTypeById( $this->getUser(), $ptype);
        $personList = $personService ->getPersonList($this->getUser());

        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'АКТы и Отчеты', 'url' => $this->generateUrl('invoice_list')),
            array('name' => $pInvoiceType ->getName(), 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('invoice/invoice_view.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'pinvoice' => $pinvoice,
            'ptype' => $ptype,
            'pInvoiceType' => $pInvoiceType,
            'fromcompanylist' => $fromCompanyList,
            'tocompanylist' => $toCompanyList,
            'personlist' => $personList,
            'can_edit' => $can_edit,
            'submitbtn1' => $submitBtn1,
            'submitbtn2' => $submitBtn2,
            'submitbtn3' => $submitBtn3,
            'submitbtn4' => $submitBtn4,
        ));

    }
    
    /**
     * @Route("/invoice-edit/{pinvoiceid}", name="invoice_edit")
     */
    public function invoiceEditAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $invoiceid = $request ->get("pinvoiceid");
        
        if ( !$is_guest ) {
            
            $gInvoiceId = $request ->get("pinvoiceid"); // GET parameter

            $paramData = $request ->get("paramdata");
            $params = json_decode($paramData);

            $pInvoiceId = $params ->o_invoiceid;
            $pCompanyTo = $params ->o_companyto;
            $pCompanyFrom = $params ->o_companyfrom;
            $pInvoiceSignId = $params ->o_invoicesign;
            $pFioTo = isset($params ->o_fioto) ? $params ->o_fioto : null;
            $pFioFrom = isset($params ->o_fiofrom) ? $params ->o_fiofrom : null;
            $pType = $params ->o_type;
            $invoiceContent = $params ->content;
            
            //var_dump($params);exit;

            $companyService = $this->get("company_service");
            $invoiceService = $this->get("invoice_service");
            
            $pInvoice = $invoiceService->getInvoiceById($this->getUser(),$pInvoiceId);
            
            if ($pInvoice) {
                $oldInvoice =  $invoiceService->cloneEntity( $this->getUser(),$pInvoice );
                $oldInvoiceSignId = $pInvoice->getInvoiceSign()->getInvoiceSignId();
                $ourInvoice = ($pInvoice->getCompanyCreate()->getCompanyId() == $this->getUser()->getCompany()->getCompanyId() );
            }
                
            
            if (
                    ( ($pInvoiceSignId == '0') || ($pInvoiceSignId == '10') )
                    && ($gInvoiceId == 'new')
                    ) {

                    $pInvoice = new Invoice();

                    $pInvoice->setInvoiceDate(new DateTime());
                    $pInvoice->setInvoiceType( $invoiceService->getInvoiceTypeById($this->getUser(),$pType) );
                    $pInvoice->setInvoiceSign( $invoiceService->getInvoiceSignById($this->getUser(), $pInvoiceSignId ) );
                    $pInvoice->setCompanyTo( $companyService->getCompanyById($this->getUser(),$pCompanyTo));
                    $pInvoice->setCompanyFrom($this->getUser()->getCompany());
                    $pInvoice->setCompanyCreate($this->getUser()->getCompany());
                    $pInvoice->setFioFrom($pFioFrom);
                    $pInvoice->setFioTo($pFioTo);
                    $pInvoice->setUserCreate($this->getUser());

                    $invoiceService ->saveInvoice($this->getUser(),$pInvoice);

            } elseif (
                    ($pInvoiceSignId == '0') 
                    && ($gInvoiceId == $pInvoiceId) 
                    && is_object($pInvoice) 
                    && ($oldInvoiceSignId == 0)
                    && $ourInvoice
                    ) {
                
                    $pInvoice->setCompanyTo( $companyService->getCompanyById($this->getUser(),$pCompanyTo));
                    $pInvoice->setCompanyFrom($this->getUser()->getCompany());
                    $pInvoice->setFioFrom($pFioFrom);
                    $pInvoice->setFioTo($pFioTo);
                
                    $invoiceService ->saveInvoice($this->getUser(),$pInvoice, $oldInvoice);
                    $invoiceService ->saveInvoiceContent($this->getUser(), $pInvoiceId, $invoiceContent);

            } elseif (
                    ($pInvoiceSignId == '-10') 
                    && ($gInvoiceId == $pInvoiceId) 
                    && is_object($pInvoice) 
                    && ($oldInvoiceSignId == 0)
                    && $ourInvoice
                    ) {
                
                    $pInvoice->setInvoiceSign( $invoiceService->getInvoiceSignById($this->getUser(),-10) );
                
                    $invoiceService ->saveInvoice($this->getUser(),$pInvoice, $oldInvoice);

            } elseif (
                    ($pInvoiceSignId == '0') 
                    && ($gInvoiceId == $pInvoiceId) 
                    && is_object($pInvoice) 
                    && ($oldInvoiceSignId == -10)
                    && $ourInvoice
                    ) {

                    $pInvoice->setInvoiceSign( $invoiceService->getInvoiceSignById($this->getUser(),0) );
                    
                    $invoiceService ->saveInvoice($this->getUser(),$pInvoice, $oldInvoice);
                
            } elseif (
                    ($pInvoiceSignId == '10') 
                    && ($gInvoiceId == $pInvoiceId) 
                    && is_object($pInvoice) 
                    && (($oldInvoiceSignId == 0) || ($oldInvoiceSignId == 20))
                    && $ourInvoice
                    ) {
                
                    $pInvoice->setInvoiceSign( $invoiceService->getInvoiceSignById($this->getUser(),10) );
                    if ($oldInvoiceSignId == 20) {
                        $pInvoice->setUserFrom(null);
                    }
                    
                    
                    $invoiceService ->saveInvoice($this->getUser(),$pInvoice, $oldInvoice);

            } elseif (
                    ($pInvoiceSignId == '20') 
                    && ($gInvoiceId == $pInvoiceId) 
                    && is_object($pInvoice) 
                    && ($oldInvoiceSignId == 10)
                    && $ourInvoice
                    ) {
                
                    $pInvoice->setInvoiceSign( $invoiceService->getInvoiceSignById($this->getUser(),20) );
                    $pInvoice->setUserFrom($this->getUser());
                    
                    $invoiceService ->saveInvoice($this->getUser(),$pInvoice, $oldInvoice);

            } elseif (
                    ($pInvoiceSignId == '0') 
                    && ($gInvoiceId == $pInvoiceId) 
                    && is_object($pInvoice) 
                    && ($oldInvoiceSignId == 10)
                    && $ourInvoice
                    ) {
                
                    $pInvoice->setInvoiceSign( $invoiceService->getInvoiceSignById($this->getUser(),0) );
                    
                    $invoiceService ->saveInvoice($this->getUser(),$pInvoice, $oldInvoice);

            } 
            //-------------------------------
            elseif (
                    ($pInvoiceSignId == '30') 
                    && ($gInvoiceId == $pInvoiceId) 
                    && is_object($pInvoice) 
                    && ($oldInvoiceSignId == 20)
                    && !$ourInvoice
                    ) {

                    $pInvoice->setInvoiceSign( $invoiceService->getInvoiceSignById($this->getUser(),30) );
                    $pInvoice->setUserTo($this->getUser());
                    
                    $invoiceService ->saveInvoice($this->getUser(),$pInvoice, $oldInvoice);
                
            }elseif (
                    ($pInvoiceSignId == '20') 
                    && ($gInvoiceId == $pInvoiceId) 
                    && is_object($pInvoice) 
                    && ($oldInvoiceSignId == 30)
                    && !$ourInvoice
                    ) {

                    $pInvoice->setInvoiceSign( $invoiceService->getInvoiceSignById($this->getUser(),20) );
                    $pInvoice->setUserTo(null);
                    
                    $invoiceService ->saveInvoice($this->getUser(),$pInvoice, $oldInvoice);
                
            }
            
        }

        //return $this->redirect($this->generateUrl('invoice_list'));
        
        $response = new Response();
        $response->setContent(json_encode(array('redirecturl' => $this->generateUrl('invoice_list'))));
        $response->headers->set('Content-Type', 'application/json');        

        return $response;

    }
    
}

