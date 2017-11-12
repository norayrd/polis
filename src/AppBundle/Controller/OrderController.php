<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Orders;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends Controller
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

        $orderService = $this->get("order_service");

        $orderList = $orderService ->getOrderList($this->getUser());
        
        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Заказы', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('order/order_list.html.twig', array(
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

        $companyService = $this->get("company_service");
        $orderService = $this->get("order_service");
        
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
        
        $agentCompanyList = $companyService ->getAgentCompanyes($this->getUser());
        $insuranceCompanyList = $companyService ->getInsuranceCompanyes($this->getUser());
        
        $porder = $orderService ->getOrderById($this->getUser(), $porderId );
        
        $submitBtn1 = null;
        $submitBtn2 = null;
        $submitBtn3 = null;
        $submitBtn4 = null;
        
        if ($porderId == 'new') {
            $submitBtn1 = $orderService ->getOrderSignById($this->getUser(),0);
            
        } else if (
                ($porderId > 0) && 
                (is_object ($porder)) &&
                ($porder->getOrderSign()->getOrderSignId() == 0) && 
                ($this->getUser()->getCompany()->getCompanyId() == $porder->getCompanyFrom()->getCompanyId())
                ) {

            $submitBtn1 = $orderService ->getOrderSignById($this->getUser(),-20);
            
        } else if (
                ($porderId > 0) && 
                ($porder->getOrderSign()->getOrderSignId() == 0) && 
                ($this->getUser()->getCompany()->getCompanyId() == $porder->getCompanyTo()->getCompanyId())
                ) {
            
            $submitBtn1 = $orderService ->getOrderSignById($this->getUser(),-10);
            $submitBtn2 = $orderService ->getOrderSignById($this->getUser(),10);
            
        } else if (
                ($porderId > 0) && 
                ($porder->getOrderSign()->getOrderSignId() == 10) && 
                ($this->getUser()->getCompany()->getCompanyId() == $porder->getCompanyTo()->getCompanyId())
                ) {
            
            $submitBtn1 = $orderService ->getOrderSignById($this->getUser(),20);
            
        }

        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Заказы', 'url' => $this->generateUrl('order_list')),
            array('name' => 'Заказ', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('order/order_view.html.twig', array(
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
            
            $orderService = $this->get("order_service");
            $companyService = $this->get("company_service");
            
                
            if (($pOrderSign == '-20') && ($gOrderId == $pOrderId)) {
                
                $pOrder = $orderService->getOrderById($this->getUser(),$pOrderId);
                
                if (is_object($pOrder) && ($pOrder->getOrderSign()->getOrderSignId() == 0)) {
                    
                    $oldOrder =  $orderService->cloneEntity( $this->getUser(),$pOrder );
                    
                    $pOrder->setOrderSign( $orderService->getOrderSignById($this->getUser(),-20) );

                    $orderService ->saveOrder($this->getUser(), $pOrder, $oldOrder);
                }
                
            } elseif (($pOrderSign == '-10') && ($gOrderId == $pOrderId)) {

                $pOrder = $orderService->getOrderById($this->getUser(),$pOrderId);
                
                if (is_object($pOrder) && ($pOrder->getOrderSign()->getOrderSignId() == 0)) {
                    
                    $oldOrder =  $orderService->cloneEntity( $this->getUser(),$pOrder );
                    
                    $pOrder->setOrderSign( $orderService->getOrderSignById($this->getUser(),-10) );
                    
                    $orderService ->saveOrder($this->getUser(),$pOrder, $oldOrder);
                }
                
            } elseif (($pOrderSign == '0') && ($gOrderId == 'new')) {
                $pOrder = new Orders();
                
                $pOrder->setOrderDate(new DateTime());
                $pOrder->setOrderType( $orderService->getOrderTypeById($this->getUser(),10) );
                $pOrder->setOrderSign( $orderService->getOrderSignById($this->getUser(),0) );
                $pOrder->setCompanyTo( $companyService->getCompanyById($this->getUser(),$pCompanyTo));
                //$pOrder->setUserTo();
                $pOrder->setCompanyFrom($this->getUser()->getCompany());
                //$pOrder->setUserFrom();
                $pOrder->setCompanyCreate($this->getUser()->getCompany());
                $pOrder->setUserCreate($this->getUser());
                
                $orderService ->saveOrder($this->getUser(),$pOrder);

            } elseif (($pOrderSign == '10') && ($gOrderId == $pOrderId)) {
                
                $pOrder = $orderService->getOrderById($this->getUser(),$pOrderId);
                
                if (is_object($pOrder) && ($pOrder->getOrderSign()->getOrderSignId() == 0)) {
                    
                    $oldOrder =  $orderService->cloneEntity( $this->getUser(),$pOrder );
                    
                    $pOrder->setOrderSign( $orderService->getOrderSignById($this->getUser(),10) );
                    $pOrder->setUserFrom($this->getUser());
                    
                    $orderService ->saveOrder($this->getUser(),$pOrder, $oldOrder);
                }

            } elseif (($pOrderSign == '20') && ($gOrderId == $pOrderId)) {

                if (is_object($pOrder) && ($pOrder->getOrderSign()->getOrderSignId() == 10)) {
                    
                    $oldOrder =  $orderService->cloneEntity( $this->getUser(),$pOrder );
                    
                    $pOrder->setOrderSign( $orderService->getOrderSignById($this->getUser(),20) );
                    $pOrder->setUserTo($this->getUser());
                    
                    $orderService ->saveOrder($this->getUser(),$pOrder, $oldOrder);
                }
                
            }
            
        }
        
        return $this->redirect($this->generateUrl('order_list'));

    }
    
}

