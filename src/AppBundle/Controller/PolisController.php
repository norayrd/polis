<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Entity\Invoice;
use AppBundle\Entity\Orders;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller used to manage the application security.
 * See http://symfony.com/doc/current/cookbook/security/form_login_setup.html.
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class PolisController extends Controller
{

    /**
     * @Route("/order-list", name="order_list")
     */
    public function orderListAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $userRoles = array();
        
        if (!$is_guest) {
            $userRoles = $this->getUser() -> getRoles();
        }
        
        if ($is_guest || empty($userRoles)) {
            return $this->redirect('/desktop');
        }

        $polisService = $this->get("polis_service");

        $orderList = $polisService ->getOrderList($this->getUser());
        
        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Заказы', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('polis/order_list.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'porderlist' => $orderList,
        ));

    }

    /**
     * @Route("/order-view", name="order_view")
     */
    public function orderViewAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $porderId = $request ->get("porderid");
        $ptype = $request ->get("ptype");
        $pparentid = $request ->get("pparentid");

        $polisService = $this->get("polis_service");
        
        //--------------------------
        //access rights
        // submit button
        $can_view_all = true;
        $can_view_self = true;
        $can_edit = true;
        
        /*if ($porderId !== 'new') {
            $can_edit =  $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_MANAGER','ROLE_TOPMANAGER'));
        } else if ($porderId === 'new') {
            $can_edit =  $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        }
        
        $can_view_all = $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        
        $can_view_self = $this->getUser()->haveRole(array('ROLE_AGENT','ROLE_MANAGER'));
        */
        //--------------------------
        
        $agentCompanyList = $polisService ->getAgentCompanyes($this->getUser());
        $insuranceCompanyList = $polisService ->getInsuranceCompanyes($this->getUser());
        
        $porder = $polisService ->getOrderById($this->getUser(), $porderId );
        
        $submitBtn1 = null;
        $submitBtn2 = null;
        $submitBtn3 = null;
        $submitBtn4 = null;
        
        if ($porderId == 'new') {
            $submitBtn1 = $polisService ->getOrderSignById($this->getUser(),0);
            
        } else if (
                ($porderId > 0) && 
                (is_object ($porder)) &&
                ($porder->getOrderSign()->getOrderSignId() == 0) && 
                ($this->getUser()->getCompany()->getCompanyId() == $porder->getCompanyFrom()->getCompanyId())
                ) {

            $submitBtn1 = $polisService ->getOrderSignById($this->getUser(),-20);
            
        } else if (
                ($porderId > 0) && 
                ($porder->getOrderSign()->getOrderSignId() == 0) && 
                ($this->getUser()->getCompany()->getCompanyId() == $porder->getCompanyTo()->getCompanyId())
                ) {
            
            $submitBtn1 = $polisService ->getOrderSignById($this->getUser(),-10);
            $submitBtn2 = $polisService ->getOrderSignById($this->getUser(),10);
            
        } else if (
                ($porderId > 0) && 
                ($porder->getOrderSign()->getOrderSignId() == 10) && 
                ($this->getUser()->getCompany()->getCompanyId() == $porder->getCompanyTo()->getCompanyId())
                ) {
            
            $submitBtn1 = $polisService ->getOrderSignById($this->getUser(),20);
            
        }



        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Заказы', 'url' => $this->generateUrl('order_list')),
            array('name' => 'Заказ', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('polis/order_view.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'porder' => $porder,
            'ptype' => $ptype,
            '$pparentid' => $pparentid,
            'pagentcompanylist' => $agentCompanyList,
            'pinsurancecompanylist' => $insuranceCompanyList,
            'can_edit' => $can_edit,
            'submitbtn1' => $submitBtn1,
            'submitbtn2' => $submitBtn2,
            'submitbtn3' => $submitBtn3,
            'submitbtn4' => $submitBtn4,
        ));

    }

    /**
     * @Route("/order-edit/{porderid}", name="order_edit")
     */
    public function orderEditAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $orderid = $request ->get("porderid");
        
        //var_dump($request);exit;
        
        if ( !$is_guest ) {
            
      
            $gOrderId = $request ->get("porderid"); // GET parameter

            $pOrderId = $request ->get("o_orderid");
            $pCompanyTo = $request ->get("o_companyto");
            $pOrderSign = $request ->get("o_ordersign");
            
            $polisService = $this->get("polis_service");
                
            if (($pOrderSign == '-20') && ($gOrderId == $pOrderId)) {
                
                $pOrder = $polisService->getOrderById($this->getUser(),$pOrderId);
                
                if (is_object($pOrder) && ($pOrder->getOrderSign()->getOrderSignId() == 0)) {
                    
                    $oldOrder =  $polisService->cloneEntity( $this->getUser(),$pOrder );
                    
                    $pOrder->setOrderSign( $polisService->getOrderSignById($this->getUser(),-20) );

                    $polisService ->saveOrder($this->getUser(), $pOrder, $oldOrder);
                }
                
            } elseif (($pOrderSign == '-10') && ($gOrderId == $pOrderId)) {

                $pOrder = $polisService->getOrderById($this->getUser(),$pOrderId);
                
                if (is_object($pOrder) && ($pOrder->getOrderSign()->getOrderSignId() == 0)) {
                    
                    $oldOrder =  $polisService->cloneEntity( $this->getUser(),$pOrder );
                    
                    $pOrder->setOrderSign( $polisService->getOrderSignById($this->getUser(),-10) );
                    
                    $polisService ->saveOrder($this->getUser(),$pOrder, $oldOrder);
                }
                
            } elseif (($pOrderSign == '0') && ($gOrderId == 'new')) {
                $pOrder = new Orders();
                
                $pOrder->setOrderDate(new DateTime());
                $pOrder->setOrderType( $polisService->getOrderTypeById($this->getUser(),10) );
                $pOrder->setOrderSign( $polisService->getOrderSignById($this->getUser(),0) );
                $pOrder->setCompanyTo( $polisService->getCompanyById($this->getUser(),$pCompanyTo));
                //$pOrder->setUserTo();
                $pOrder->setCompanyFrom($this->getUser()->getCompany());
                //$pOrder->setUserFrom();
                $pOrder->setCompanyCreate($this->getUser()->getCompany());
                $pOrder->setUserCreate($this->getUser());
                
                $polisService ->saveOrder($this->getUser(),$pOrder);

            } elseif (($pOrderSign == '10') && ($gOrderId == $pOrderId)) {
                
                $pOrder = $polisService->getOrderById($this->getUser(),$pOrderId);
                
                if (is_object($pOrder) && ($pOrder->getOrderSign()->getOrderSignId() == 0)) {
                    
                    $oldOrder =  $polisService->cloneEntity( $this->getUser(),$pOrder );
                    
                    $pOrder->setOrderSign( $polisService->getOrderSignById($this->getUser(),10) );
                    $pOrder->setUserFrom($this->getUser());
                    
                    $polisService ->saveOrder($this->getUser(),$pOrder, $oldOrder);
                }

            } elseif (($pOrderSign == '20') && ($gOrderId == $pOrderId)) {

                if (is_object($pOrder) && ($pOrder->getOrderSign()->getOrderSignId() == 10)) {
                    
                    $oldOrder =  $polisService->cloneEntity( $this->getUser(),$pOrder );
                    
                    $pOrder->setOrderSign( $polisService->getOrderSignById($this->getUser(),20) );
                    $pOrder->setUserTo($this->getUser());
                    
                    $polisService ->saveOrder($this->getUser(),$pOrder, $oldOrder);
                }
                
            }
            
        }
        
        return $this->redirect($this->generateUrl('order_list'));

    }
    
    /**
    }
    }
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

        $polisService = $this->get("polis_service");

        $invoiceList = $polisService ->getInvoiceList($this->getUser());
        
        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Приход / Расход', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('polis/invoice_list.html.twig', array(
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
        
        $polisService = $this->get("polis_service");
        
        //--------------------------
        //access rights
        // submit button
        $can_view_all = true;
        $can_view_self = true;
        $can_edit = true;
        
        //--------------------------
        
        $pinvoice = $polisService ->getInvoiceById($this->getUser(), $pinvoiceId );
        if (is_numeric($pinvoiceId) && is_object($pinvoice)) {
            $ptype = $pinvoice->getInvoiceType()->getInvoiceTypeId();
        }

        
        $agentCompanyList = $polisService ->getAgentCompanyes($this->getUser());
        $insuranceCompanyList = $polisService ->getInsuranceCompanyes($this->getUser());

        if ( is_object($pinvoice) && ($pinvoice->getCompanyCreate()->getCompanyId() !== $this->getUser()->getCompany()->getCompanyId()) ) {
            $fromCompanyList = array($pinvoice ->getCompanyFrom());
            $toCompanyList = array($pinvoice ->getCompanyTo());

        } elseif ($this->getUser()->getCompany()->getType() == 1) {
        
            if ($ptype == '10') {
                $fromCompanyList = $polisService ->getInsuranceCompanyes($this->getUser());
                $toCompanyList = array($this->getUser()->getCompany());

            } elseif ($ptype == '20') {
                $fromCompanyList = array($this->getUser()->getCompany());
                $toCompanyList = $polisService ->getInsuranceCompanyes($this->getUser());

            } elseif ($ptype == '30') {
                $fromCompanyList = array($this->getUser()->getCompany());
                $toCompanyList = $polisService ->getAgentCompanyes($this->getUser());

            } elseif ($ptype == '40') {
                $fromCompanyList = $polisService ->getAgentCompanyes($this->getUser());
                $toCompanyList = array($this->getUser()->getCompany());

            }
            
        } elseif ($this->getUser()->getCompany()->getType() == 3) {
        
            if ($ptype == '10') {
                $fromCompanyList = array($this->getUser()->getCompany()->getParent());
                $toCompanyList = array($this->getUser()->getCompany());

            } elseif ($ptype == '20') {
                $fromCompanyList = array($this->getUser()->getCompany());
                $toCompanyList = array($this->getUser()->getCompany()->getParent());

            } elseif ($ptype == '30') {
                $fromCompanyList = array($this->getUser()->getCompany());
                $toCompanyList = null;

            } elseif ($ptype == '40') {
                $fromCompanyList = null;
                $toCompanyList = array($this->getUser()->getCompany());

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
            $submitBtn1 = $polisService ->getInvoiceSignBtnById($this->getUser(),0);
            $submitBtn2 = $polisService ->getInvoiceSignBtnById($this->getUser(),10);
            
        } else if (
                ($pinvoiceId > 0) && 
                is_object($pinvoice) &&
                ($invoiceSignId == -10) && 
                $ourInvoice
                ) {

            $submitBtn1 = $polisService ->getInvoiceSignBtnById($this->getUser(),-11);
            
        } else if (
                ($pinvoiceId > 0) && 
                is_object($pinvoice) &&
                ($invoiceSignId == 0) && 
                $ourInvoice
                ) {

            $submitBtn1 = $polisService ->getInvoiceSignBtnById($this->getUser(),-10);
            $submitBtn2 = $polisService ->getInvoiceSignBtnById($this->getUser(),0);
            $submitBtn3 = $polisService ->getInvoiceSignBtnById($this->getUser(),10);
            
        } else if (
                ($pinvoiceId > 0) && 
                is_object($pinvoice) &&
                ($invoiceSignId == 10) && 
                $ourInvoice
                ) {
            
            $submitBtn1 = $polisService ->getInvoiceSignBtnById($this->getUser(),11);
            $submitBtn2 = $polisService ->getInvoiceSignBtnById($this->getUser(),20);
            
        } else if (
                ($pinvoiceId > 0) && 
                is_object($pinvoice) &&
                ($invoiceSignId == 20) && 
                $ourInvoice
                ) {
            
            $submitBtn1 = $polisService ->getInvoiceSignBtnById($this->getUser(),21);
            
        }
        //---------------------
         else if (
                ($pinvoiceId > 0) && 
                is_object($pinvoice) &&
                ($invoiceSignId == 20) && 
                !$ourInvoice
                ) {
            
            $submitBtn1 = $polisService ->getInvoiceSignBtnById($this->getUser(),30);
            
        } else if (
                ($pinvoiceId > 0) && 
                is_object($pinvoice) &&
                ($invoiceSignId == 30) && 
                !$ourInvoice
                ) {
            
            $submitBtn1 = $polisService ->getInvoiceSignBtnById($this->getUser(),31);
            
        }

        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Приход / Расход', 'url' => $this->generateUrl('invoice_list')),
            array('name' => 'Накладная', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('polis/invoice_view.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'pinvoice' => $pinvoice,
            'ptype' => $ptype,
            'fromcompanylist' => $fromCompanyList,
            'tocompanylist' => $toCompanyList,
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
            
            var_dump($params);exit;

            $polisService = $this->get("polis_service");
            
            $pInvoice = $polisService->getInvoiceById($this->getUser(),$pInvoiceId);
            
            if ($pInvoice) {
                $oldInvoice =  $polisService->cloneEntity( $this->getUser(),$pInvoice );
                $oldInvoiceSignId = $pInvoice->getInvoiceSign()->getInvoiceSignId();
                $ourInvoice = ($pInvoice->getCompanyCreate()->getCompanyId() == $this->getUser()->getCompany()->getCompanyId() );
            }
                
            
            if (
                    ( ($pInvoiceSignId == '0') || ($pInvoiceSignId == '10') )
                    && ($gInvoiceId == 'new')
                    ) {

                    $pInvoice = new Invoice();

                    $pInvoice->setInvoiceDate(new DateTime());
                    $pInvoice->setInvoiceType( $polisService->getInvoiceTypeById($this->getUser(),$pType) );
                    $pInvoice->setInvoiceSign( $polisService->getInvoiceSignById($this->getUser(), $pInvoiceSignId ) );
                    $pInvoice->setCompanyTo( $polisService->getCompanyById($this->getUser(),$pCompanyTo));
                    $pInvoice->setCompanyFrom($this->getUser()->getCompany());
                    $pInvoice->setCompanyCreate($this->getUser()->getCompany());
                    $pInvoice->setFioFrom($pFioFrom);
                    $pInvoice->setFioTo($pFioTo);
                    $pInvoice->setUserCreate($this->getUser());

                    $polisService ->saveInvoice($this->getUser(),$pInvoice);

            } elseif (
                    ($pInvoiceSignId == '0') 
                    && ($gInvoiceId == $pInvoiceId) 
                    && is_object($pInvoice) 
                    && ($oldInvoiceSignId == 0)
                    && $ourInvoice
                    ) {
                
                    $pInvoice->setCompanyTo( $polisService->getCompanyById($this->getUser(),$pCompanyTo));
                    $pInvoice->setCompanyFrom($this->getUser()->getCompany());
                    $pInvoice->setFioFrom($pFioFrom);
                    $pInvoice->setFioTo($pFioTo);
                
                    $polisService ->saveInvoice($this->getUser(),$pInvoice, $oldInvoice);

            } elseif (
                    ($pInvoiceSignId == '-10') 
                    && ($gInvoiceId == $pInvoiceId) 
                    && is_object($pInvoice) 
                    && ($oldInvoiceSignId == 0)
                    && $ourInvoice
                    ) {
                
                    $pInvoice->setInvoiceSign( $polisService->getInvoiceSignById($this->getUser(),-10) );
                
                    $polisService ->saveInvoice($this->getUser(),$pInvoice, $oldInvoice);

            } elseif (
                    ($pInvoiceSignId == '0') 
                    && ($gInvoiceId == $pInvoiceId) 
                    && is_object($pInvoice) 
                    && ($oldInvoiceSignId == -10)
                    && $ourInvoice
                    ) {

                    $pInvoice->setInvoiceSign( $polisService->getInvoiceSignById($this->getUser(),0) );
                    
                    $polisService ->saveInvoice($this->getUser(),$pInvoice, $oldInvoice);
                
            } elseif (
                    ($pInvoiceSignId == '10') 
                    && ($gInvoiceId == $pInvoiceId) 
                    && is_object($pInvoice) 
                    && (($oldInvoiceSignId == 0) || ($oldInvoiceSignId == 20))
                    && $ourInvoice
                    ) {
                
                    $pInvoice->setInvoiceSign( $polisService->getInvoiceSignById($this->getUser(),10) );
                    if ($oldInvoiceSignId == 20) {
                        $pInvoice->setUserFrom(null);
                    }
                    
                    
                    $polisService ->saveInvoice($this->getUser(),$pInvoice, $oldInvoice);

            } elseif (
                    ($pInvoiceSignId == '20') 
                    && ($gInvoiceId == $pInvoiceId) 
                    && is_object($pInvoice) 
                    && ($oldInvoiceSignId == 10)
                    && $ourInvoice
                    ) {
                
                    $pInvoice->setInvoiceSign( $polisService->getInvoiceSignById($this->getUser(),20) );
                    $pInvoice->setUserFrom($this->getUser());
                    
                    $polisService ->saveInvoice($this->getUser(),$pInvoice, $oldInvoice);

            } elseif (
                    ($pInvoiceSignId == '0') 
                    && ($gInvoiceId == $pInvoiceId) 
                    && is_object($pInvoice) 
                    && ($oldInvoiceSignId == 10)
                    && $ourInvoice
                    ) {
                
                    $pInvoice->setInvoiceSign( $polisService->getInvoiceSignById($this->getUser(),0) );
                    
                    $polisService ->saveInvoice($this->getUser(),$pInvoice, $oldInvoice);

            } 
            //-------------------------------
            elseif (
                    ($pInvoiceSignId == '30') 
                    && ($gInvoiceId == $pInvoiceId) 
                    && is_object($pInvoice) 
                    && ($oldInvoiceSignId == 20)
                    && !$ourInvoice
                    ) {

                    $pInvoice->setInvoiceSign( $polisService->getInvoiceSignById($this->getUser(),30) );
                    $pInvoice->setUserTo($this->getUser());
                    
                    $polisService ->saveInvoice($this->getUser(),$pInvoice, $oldInvoice);
                
            }elseif (
                    ($pInvoiceSignId == '20') 
                    && ($gInvoiceId == $pInvoiceId) 
                    && is_object($pInvoice) 
                    && ($oldInvoiceSignId == 30)
                    && !$ourInvoice
                    ) {

                    $pInvoice->setInvoiceSign( $polisService->getInvoiceSignById($this->getUser(),20) );
                    $pInvoice->setUserTo(null);
                    
                    $polisService ->saveInvoice($this->getUser(),$pInvoice, $oldInvoice);
                
            }
            
        }

        return $this->redirect($this->generateUrl('invoice_list'));

    }

    /**
     * @Route("/user-profile", name="user_profile")
     */
    public function userProfileAction(Request $request){

        $is_guest = !is_object($this->getUser());

        $puserId = $request ->get("userid");
        
        var_dump('Sorry, but "user account" yet not ready!');exit;
        
        /*return $this->render('polis/user-view.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));*/

    }

    /**
     * @Route("/report", name="report")
     */
    public function reportAction(Request $request){

        $is_guest = !is_object($this->getUser());

        $polisId = $request ->get("polisid");
        
        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Отчет', 'url' => null),
        );
        
        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('polis/report.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
        ));

    }
    
    /**
     * @Route("/company-list", name="company_list")
     */
    public function companyListAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $userRoles = array();
        
        if (!$is_guest) {
            $userRoles = $this->getUser() -> getRoles();
        }
        
        if ($is_guest || empty($userRoles)) {
            return $this->redirect('/desktop');
        }
        
        $polisService = $this->get("polis_service");

        //--------------------------
        //access rights
        $can_create =  $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        
        $can_view_all = $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        
        $can_view_self = $this->getUser()->haveRole(array('ROLE_AGENT','ROLE_MANAGER'));
        
        //--------------------------

        if ($can_view_all) {
            
            $companyList = $polisService ->getCompanyList($this->getUser());
        } else if ($can_view_self) {

            $companyList = array($polisService ->getCompanyById($this->getUser(), $this->getUser()->getCompany()->getCompanyId()));
        } else {
            
            $companyList = array();
        }
        
        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Реестр компаний', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('polis/company_list.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'companyList' => $companyList,
            'can_create' => $can_create,
        ));

    }
    
    /**
     * @Route("/company-view", name="company_view")
     */
    public function companyViewAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $pcompanyId = $request ->get("pcompanyid");

        $polisService = $this->get("polis_service");
        
        //--------------------------
        //access rights
        // submit button
        if ($pcompanyId !== 'new') {
            $can_edit =  $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_MANAGER','ROLE_TOPMANAGER'));
        } else if ($pcompanyId === 'new') {
            $can_edit =  $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        }
        //access to "type", "status" and "polis_count_limit".
        $can_edit_type = $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        
        $can_view_all = $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        
        $can_view_self = $this->getUser()->haveRole(array('ROLE_AGENT','ROLE_MANAGER')) 
                && ($this->getUser()->getCompany()->getCompanyId() == $pcompanyId );
        
        //--------------------------

        if ( $can_view_all ) {
            
            $pcompany = $polisService ->getCompanyById($this->getUser(), $pcompanyId );
        } else if ($can_view_self) {

            $pcompany = $polisService ->getCompanyById($this->getUser(), $pcompanyId );
        } else {
            
            $pcompany = null;
        }
        
        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Реестр компаний', 'url' => $this->generateUrl('company_list')),
            array('name' => 'Анкета компании', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('polis/company_view.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'pcompany' => $pcompany,
            'can_edit' => $can_edit,
            'can_edit_type' => $can_edit_type,
        ));

    }
    
    /**
     * @Route("/company-edit/{pcompanyid}", name="company_edit")
     */
    public function companyEditAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $pcompanyid = $request ->get("pcompanyid");
        
        if ( !$is_guest && $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER')) ) {
            
            $pcompid = $request ->get("c_companyid");
            $pcompname = $request ->get("c_compname");
            $pemail = $request ->get("c_email");
            $paddress = $request ->get("c_address");
            $pphone = $request ->get("c_phone");
            $pstatus = $request ->get("c_status");
            $ptype = $request ->get("c_type");
            $polisCountLimit = $request ->get("c_polis_count_limit");
            
            $polisService = $this->get("polis_service");
            
            if ( ($pcompanyid == 'new') || ($pcompid == '') ) {

                $pcompany = new Company();
                
            } else if ( ($pcompanyid !== null) && ($pcompanyid > 0) && ($pcompanyid == $pcompid) ) {

                $pcompany = $polisService ->getCompanyById($this->getUser(),$pcompanyid);
            }

            if (isset($pcompany) && is_object($pcompany)) {
                
                if (!isset($polisCountLimit)) {
                    $polisCountLimit = 0;
                }
                    
                $pcompany->setCompName($pcompname);
                $pcompany->setEmail($pemail);
                $pcompany->setAddress($paddress);
                $pcompany->setPhone($pphone);
                $pcompany->setStatus($pstatus);
                $pcompany->setPolisCountLimit(0);
                $pcompany->setDateBeginFact(new DateTime());
                $pcompany->setDateEndFact(new DateTime('9999-12-31 23:59:59'));
                $pcompany->setUserId1($this->getUser()->getId());

                if ($this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER')) ) {
                    $pcompany->setType($ptype);
                    $pcompany->setPolisCountLimit($polisCountLimit);
                }

                $polisService ->saveCompany($this->getUser(),$pcompany);

            }
            
        }
        
        return $this->redirect($this->generateUrl('company_list'));

    }

    /**
     * @Route("/user-list", name="user_list")
     */
    public function userListAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $polisService = $this->get("polis_service");
        
        if ($this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER')) ) {
            
            $userList = $polisService ->getUserList($this->getUser());
        } else if ($this->getUser()->haveRole(array('ROLE_AGENT','ROLE_MANAGER')) ) {

            $userList = array($polisService ->getUserById($this->getUser(), $this->getUser()->getId()));
        } else {
            
            $userList = array();
        }

        //--------------------
        $securityService = $this->get("security_service");
        $userRolesList = $securityService->getUserRolesList($this->getUser());
        
        $polRoles = array();
        
        foreach ($userRolesList as $role) {
            
            $polRoles[$role->getRole()] = array(
                'name' => $role->getName(),
                'icon' => $role->getIcon(),
            );
        }
        //--------------------

        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Реестр пользователей', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('polis/user_list.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'userList' => $userList,
            'polRoles' => $polRoles,
        ));

    }

    /**
     * @Route("/user-view/{puserid}", name="user_view")
     */
    public function userViewAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $puserid = $request ->get("puserid");
        
        $polisService = $this->get("polis_service");
        
        if ( $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER')) ) {
            
            $puser = $polisService ->getUserById($this->getUser(),$puserid);
        } else if ($this->getUser()->haveRole(array('ROLE_AGENT','ROLE_MANAGER')) && 
             ($this->getUser()->getId() == $puserid ) ) {

            $puser = $polisService ->getUserById($this->getUser(),$puserid);
        } else {
            
            $puser = null;
        }
        
        $securityService = $this->get("security_service");
        $userRolesList = $securityService->getUserRolesList($this->getUser());
                
        $puserRoles = array();
        
        if (is_object($puser)) {
        
            foreach ($userRolesList as $key => $role) {

                $puserRoles[$key] = array(
                    'key' => $key, 
                    'name' => $role->getName(), 
                    'checked' => in_array($role->getRole(), $puser->getRoles()),
                    'icon' => $role->getIcon(),
                );
            }
        }

        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Реестр пользователей', 'url' => $this->generateUrl('user_list')),
            array('name' => 'Анкета пользователя', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('polis/user_view.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'puser' => $puser,
            'puser_roles' => $puserRoles,
        ));

    }
    
    /**
     * @Route("/user-edit/{puserid}", name="user_edit")
     */
    public function userEditAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        if ( !$is_guest && $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER')) ) {
            
            $puserid = $request ->get("puserid");
            $pid = $request ->get("u_id");
            $plastname = $request ->get("u_lastname");
            $pfirstname = $request ->get("u_firstname");
            $ppatronymic = $request ->get("u_patronymic");
            $pemail = $request ->get("u_email");
            $paddress = $request ->get("u_address");
            $pphone = $request ->get("u_phone");
            $pcompanyid = $request ->get("u_company_id");
            $prole = $request ->get("u_role");
            $puserroles = $request ->get("u_roles");

            //---------------------------
            $securityService = $this->get("security_service");
            $userRolesList = $securityService->getUserRolesList($this->getUser());
            
            $polisRoles = array();
            foreach ($userRolesList as $key => $role) {
                $polisRoles[$key] = array(
                    'role' => $role->getRole(),
                );
            }
            
            $proles = array();
            
            if (is_array($puserroles)) {
                foreach ($puserroles as $value) {
                    if (isset($polisRoles[$value])) {
                        $proles[] = $polisRoles[$value]['role'];
                    }
                }
            }
        //--------------------
            
            if ( ($puserid !== null) && ($puserid > 0) ) {

                $polisService = $this->get("polis_service");
                $puser = $polisService ->getUserById($this->getUser(),$puserid);

                if (is_object($puser)) {
                    
                    $puser->setLastname($plastname);
                    $puser->setFirstname($pfirstname);
                    $puser->setPatronymic($ppatronymic);
                    $puser->setEmail($pemail);
                    $puser->setAddress($paddress);
                    $puser->setPhone($pphone);
                    //$puser->setCompanyid($pcompanyid);
                    
                    if ($this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER')) ) {
                        $puser->setRoles($proles);
                    }
                    
                    $polisService ->saveUser($this->getUser(),$puser);

                }
                
            }
            
        }
        
        return $this->redirect($this->generateUrl('user_list'));

    }

    /**
     * @Route("/invitation-sign-up", name="invitation_sign_up")
     */
    public function invitationSignUpAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $polisService = $this->get("polis_service");
        
        if ( $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER')) ) {
            
            $companyList = $polisService ->getCompanyList($this->getUser());
        } else {
            
            $companyList = null;
        }

        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Приглашение на регистрацию', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('polis/invitation_sign_up.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'companyList' => $companyList,
        ));

    }
    
    /**
     * @Route("/send-invitation-sign-up", name="send_invitation_sign_up")
     */
    public function sendInvitationSignUpAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $polisService = $this->get("polis_service");
        
        $pemail = $request ->get("u_email");
        $pcompanyId = $request ->get("u_company_id");

        if ( $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER')) ) {
            
            $user = $this->getUser();
            
            $iKeyService = $this->get("i_key_service");
            
            $piKey = $iKeyService ->createIKey($user, $pemail, $pcompanyId, $this->container->getParameter('secret') );


            
            $hash = $piKey ->getIKey();

            $signup_link = $this->generateUrl('sign_up',array('i' => $hash, 'email' => rawurlencode($pemail)),true);

            $email_from_name = $this->container->getParameter('support_email_from_name');
            $email_from = $this->container->getParameter('support_email_from');
            $email_replay_to = $this->container->getParameter('support_email_replay_to');
            $email_footer_message = $this->container->getParameter('support_email_footer_message');
            $base_url = $this->container->getParameter('base_url');
            $base_url_name = $this->container->getParameter('base_url_name');

            $mail_params = array(
                'signup_link' => $signup_link,
                'email_footer_message' => $email_footer_message,
                'base_url' => $base_url,
                'base_url_name' => $base_url_name,
            );

            $message = $this->get('mail_manager');

            $message->sendEmail('emails/sign_up_email.html.twig', $mail_params, $pemail, $email_from, $email_from_name, $email_replay_to);
            
            //$success_message_text = 'На указанную почту было отправлено письмо для изменения пароля.';
            
        } else {
            
        }
        
        return $this->redirect($this->generateUrl('invitation_sign_up'));
            
    }
    
}

