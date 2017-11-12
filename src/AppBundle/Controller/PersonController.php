<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PersonController extends Controller
{

    /**
     * @Route("/person-list", name="person_list")
     */
    public function personListAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $userRoles = array();
        
        if (!$is_guest) {
            $userRoles = $this->getUser() -> getRoles();
        }
        
        if ($is_guest || empty($userRoles)) {
            return $this->redirect('/desktop');
        }
        
        $personService = $this->get("person_service");

        //--------------------------
        //access rights
        $can_create =  $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        
        $can_view_all = $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        
        //--------------------------

        if ($can_view_all) {
            
            $personList = $personService ->getPersonList($this->getUser());
        } else {
            
            $personList = null;
        }
        
        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Реестр компаний', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('person/person_list.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'personList' => $personList,
            'can_create' => $can_create,
        ));

    }
    
    /**
     * @Route("/person-view", name="person_view")
     */
    public function personViewAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $ppersonId = $request ->get("ppersonid");

        $personService = $this->get("person_service");
        
        //--------------------------
        //access rights
        // submit button
        if ($ppersonId !== 'new') {
            $can_edit =  $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_MANAGER','ROLE_TOPMANAGER'));
        } else if ($ppersonId === 'new') {
            $can_edit =  $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        }
        //access to "type", "status" and "polis_count_limit".
        $can_edit_type = $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        
        $can_view_all = $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        
        //--------------------------

        if ( $can_view_all ) {
            
            $pperson = $personService ->getPersonById($this->getUser(), $ppersonId );
        } else {
            
            $pperson = null;
        }
        
        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Реестр компаний', 'url' => $this->generateUrl('person_list')),
            array('name' => 'Анкета компании', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('person/person_view.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'pperson' => $pperson,
            'can_edit' => $can_edit,
            'can_edit_type' => $can_edit_type,
        ));

    }
    
    /**
     * @Route("/person-edit/{ppersonid}", name="person_edit")
     */
    public function personEditAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $ppersonid = $request ->get("ppersonid");
        
        if ( !$is_guest && $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER')) ) {
            
            $ppersid = $request ->get("c_personid");
            $pname = $request ->get("c_personname");
            
            $personService = $this->get("person_service");
            
            if ( ($ppersonid == 'new') || ($ppersid == '') ) {

                $pperson = new Person();
                
            } else if ( ($ppersonid !== null) && ($ppersonid > 0) && ($ppersonid == $ppersid) ) {

                $pperson = $personService ->getPersonById($this->getUser(),$ppersonid);
            }

            if (isset($pperson) && is_object($pperson)) {
                
                if (!isset($polisCountLimit)) {
                    $polisCountLimit = 0;
                }
                    
                $pperson->setPersonName($pname);
                $pperson->setDateCurr(new DateTime());
                $pperson->setUserId($this->getUser()->getId());

                $personService ->savePerson($this->getUser(),$pperson);

            }
            
        }
        
        return $this->redirect($this->generateUrl('person_list'));

    }
    
}