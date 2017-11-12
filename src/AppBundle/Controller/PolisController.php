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

