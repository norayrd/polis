<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

    /**
     * @Route("/user-profile", name="user_profile")
     */
    public function userProfileAction(Request $request){

        $is_guest = !is_object($this->getUser());

        $puserId = $request ->get("userid");
        
        var_dump('Sorry, but "user account" yet not ready!');exit;
    }

    /**
     * @Route("/user-list", name="user_list")
     */
    public function userListAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $userService = $this->get("user_service");
        
        if ($this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER')) ) {
            
            $userList = $userService ->getUserList($this->getUser());
        } else if ($this->getUser()->haveRole(array('ROLE_AGENT','ROLE_MANAGER')) ) {

            $userList = array($userService ->getUserById($this->getUser(), $this->getUser()->getId()));
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

        return $this->render('user/user_list.html.twig', array(
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
        
        $userService = $this->get("user_service");
        
        if ( $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER')) ) {
            
            $puser = $userService ->getUserById($this->getUser(),$puserid);
        } else if ($this->getUser()->haveRole(array('ROLE_AGENT','ROLE_MANAGER')) && 
             ($this->getUser()->getId() == $puserid ) ) {

            $puser = $userService ->getUserById($this->getUser(),$puserid);
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

        return $this->render('user/user_view.html.twig', array(
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

                $userService = $this->get("user_service");
                $puser = $userService ->getUserById($this->getUser(),$puserid);

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
                    
                    $userService ->saveUser($this->getUser(),$puser);

                }
                
            }
            
        }
        
        return $this->redirect($this->generateUrl('user_list'));
    }

}

