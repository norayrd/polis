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
            array('name' => 'home', 'url' => 'home'),
            array('name' => 'Журнал заявок', 'url' => 'order-list'),
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
            array('name' => 'home', 'url' => 'home'),
            array('name' => 'Журнал полисов', 'url' => 'polis-list'),
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
     * @Route("/polis-new", name="polis_new")
     */
    public function polisNewAction(Request $request){

        $is_guest = !is_object($this->getUser());
        
        return $this->render('polis/polis-view.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));

    }

    /**
     * @Route("/polis-edit", name="polis_edit")
     */
    public function polisEditAction(Request $request){

        $is_guest = !is_object($this->getUser());

        $polisId = $request ->get("polisid");
        
        return $this->render('polis/polis-view.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
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
            array('name' => 'home', 'url' => 'home'),
            array('name' => 'Отчет', 'url' => 'report'),
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

        $companyList = $polisService ->getCompanyList($this->getUser());
        
        $breadcrumb = array(
            array('name' => 'home', 'url' => 'home'),
            array('name' => 'Реестр компаний', 'url' => 'company-list'),
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
        
        $polisService = $this->get("polis_service");

        $pcompany = $polisService ->getCompanyList($companyId, $this->getUser());
        
        $breadcrumb = array(
            array('name' => 'home', 'url' => 'home'),
            array('name' => 'Реестр компаний', 'url' => 'company-list'),
            array('name' => 'Анкета компании', 'url' => '#'),
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
     * @Route("/user-list", name="user_list")
     */
    public function userListAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $polisService = $this->get("polis_service");

        $userList = $polisService ->getUserList($this->getUser());

        $polisRoles = $this->container->getParameter('polis_roles');
        
        $polRoles = array();
        
        foreach ($polisRoles as $value) {
            $polRoles[$value['id']] = array(
                'name' => $value['name'],
                'icon' => $value['icon'],
            );
        }

        $breadcrumb = array(
            array('name' => 'home', 'url' => 'home'),
            array('name' => 'Реестр пользователей', 'url' => 'user-list'),
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
        
        $puser = null;
     
        if ( ($puserid !== null) && ($puserid > 0) ) {
            
            $puser = $polisService ->getUserById($this->getUser(),$puserid);
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
            array('name' => 'home', 'url' => 'home'),
            array('name' => 'Реестр пользователей', 'url' => 'user-list'),
            array('name' => 'Анкета пользователя', 'url' => '#'),
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

