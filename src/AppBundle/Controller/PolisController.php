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

        if ($this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER')) ) {
            
            $companyList = $polisService ->getCompanyList($this->getUser());
        } else if ($this->getUser()->haveRole(array('ROLE_AGENT','ROLE_MANAGER')) ) {

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
        ));

    }
    
    /**
     * @Route("/company-view", name="company_view")
     */
    public function companyViewAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $pcompanyId = $request ->get("pcompanyid");

        $polisService = $this->get("polis_service");

        if ( $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER')) ) {
            
            $pcompany = $polisService ->getCompanyById($this->getUser(), $pcompanyId );
        } else if ($this->getUser()->haveRole(array('ROLE_AGENT','ROLE_MANAGER')) && 
             ($this->getUser()->getCompany()->getCompanyId() == $pcompanyId ) ) {

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

}

