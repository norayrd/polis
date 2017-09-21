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
        
        $polisService = $this->get("polis_service");

        $orderList = null;//$polisService ->getorderList($this->getUser());
        
        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Журнал заявок', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('polis/order_list.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'orderList' => $orderList,
        ));

    }

    /**
     * @Route("/polis-list", name="polis_list")
     */
    public function polisListAction(Request $request){
        
        /*$polisService = $this->get("polis_service");

        // reversing Company
        $polisService ->reverseCompany( 32, $this->getUser()->getId());
        
        // adding Company
        $company = new Company();
        $company->setCompName('Новый Тест ' . date('d.m.Y H:i'));
        $company->setType('1');
        $company->setPolisCountLimit(12);

        $test = $polisService ->addCompany( $company, $this->getUser()->getId());
        
        var_dump($test);exit;
        */

        $is_guest = !is_object($this->getUser());
        
        $polisService = $this->get("polis_service");

        $polisList = null;//$polisService ->getPolisList($this->getUser());
        
        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Журнал полисов', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('polis/polis_list.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'polisList' => $polisList,
        ));

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
                $pcompany->setDateBeginFact(new \DateTime());
                $pcompany->setDateEndFact(new \DateTime('9999-12-31 23:59:59'));
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

        $polisRoles = $this->container->getParameter('polis_roles');
        
        $polRoles = array();
        
        foreach ($polisRoles as $value) {
            $polRoles[$value['id']] = array(
                'name' => $value['name'],
                'icon' => $value['icon'],
            );
        }

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
        
        $polisRoles = $this->container->getParameter('polis_roles');
                
        $puserRoles = array();
        
        if (is_object($puser)) {
        
            foreach ($polisRoles as $key => $value) {

                $puserRoles[$key] = array(
                    'key' => $key, 
                    'name' => $value['name'], 
                    'checked' => in_array($value['id'], $puser->getRoles()),
                    'icon' => $value['icon'],
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

            $polisRoles = $this->container->getParameter('polis_roles');
            
            $proles = array();
            
            if (is_array($puserroles)) {
                foreach ($puserroles as $value) {
                    if (isset($polisRoles[$value])) {
                        $proles[] = $polisRoles[$value]['id'];
                    }
                }
            }
            
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
        
        $pemail = $request ->get("email");
        $pcompanyid = $request ->get("companyid");

        if ( $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER')) ) {
            
            $user = $this->getUser();
            
            $securityService = $this->get("security_service");
            
            $hash = 'sdfasdfasdfa'; //$securityService ->getForgotPasswordHash($user, $this->container->getParameter('secret'));

            $forgot_link = 'asdasda'; //$this->generateUrl('change_password',array(),true) . 
                    //'?email=' . rawurlencode($pemail) .
                    //'&h=' . $hash ;

            $email_from_name = $this->container->getParameter('support_email_from_name');
            $email_from = $this->container->getParameter('support_email_from');
            $email_replay_to = $this->container->getParameter('support_email_replay_to');
            $email_footer_message = $this->container->getParameter('support_email_footer_message');
            $base_url = $this->container->getParameter('base_url');
            $base_url_name = $this->container->getParameter('base_url_name');

            $mail_params = array(
                'fullname' => $user->getFirstName().' '.$user->getLastName(),
                'forgot_link' => $forgot_link,
                'email_footer_message' => $email_footer_message,
                'base_url' => $base_url,
                'base_url_name' => $base_url_name,
            );

            $message = $this->get('mail_manager');

            $message->sendEmail('emails/sign_up_email.html.twig', $mail_params, $pemail, $email_from, $email_from_name, $email_replay_to);

            $mailBody = $this->renderView(
                'emails/sign_up_email.html.twig',
                array()
            );
            $mailSubject = 'Test';
            $mailHeaders = 'MIME-Version: 1.0' . "\r\n";
            $mailHeaders .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $mailHeaders .= 'FROM: Test message <'.$email_from.'>' . "\r\n";


            
            $res=mail($pemail, $mailSubject, $mailBody, $mailHeaders);
var_dump($mailBody);exit;
            //$success_message_text = 'На указанную почту было отправлено письмо для изменения пароля.';
            
        } else {
            
var_dump(7);exit;
        }
        
        return $this->redirect($this->generateUrl('invitation_sign_up'));
            
    }
    
}

