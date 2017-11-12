<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CompanyController extends Controller
{

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
        
        $companyService = $this->get("company_service");

        //--------------------------
        //access rights
        $can_create =  $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        
        $can_view_all = $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        
        $can_view_self = $this->getUser()->haveRole(array('ROLE_AGENT','ROLE_MANAGER'));
        
        //--------------------------

        if ($can_view_all) {
            
            $companyList = $companyService ->getCompanyList($this->getUser());
        } else if ($can_view_self) {

            $companyList = array($companyService ->getCompanyById($this->getUser(), $this->getUser()->getCompany()->getCompanyId()));
        } else {
            
            $companyList = array();
        }
        
        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Реестр компаний', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('company/company_list.html.twig', array(
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

        $companyService = $this->get("company_service");
        
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
            
            $pcompany = $companyService ->getCompanyById($this->getUser(), $pcompanyId );
        } else if ($can_view_self) {

            $pcompany = $companyService ->getCompanyById($this->getUser(), $pcompanyId );
        } else {
            
            $pcompany = null;
        }
        
        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Реестр компаний', 'url' => $this->generateUrl('company_list')),
            array('name' => 'Анкета компании', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('company/company_view.html.twig', array(
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
            
            $companyService = $this->get("company_service");
            
            if ( ($pcompanyid == 'new') || ($pcompid == '') ) {

                $pcompany = new Company();
                
            } else if ( ($pcompanyid !== null) && ($pcompanyid > 0) && ($pcompanyid == $pcompid) ) {

                $pcompany = $companyService ->getCompanyById($this->getUser(),$pcompanyid);
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

                $companyService ->saveCompany($this->getUser(),$pcompany);

            }
            
        }
        
        return $this->redirect($this->generateUrl('company_list'));

    }
    
}