<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Nomen;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NomenController extends Controller
{

    /**
     * @Route("/nomen-list", name="nomen_list")
     */
    public function nomenListAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $userRoles = array();
        
        if (!$is_guest) {
            $userRoles = $this->getUser() -> getRoles();
        }
        
        if ($is_guest || empty($userRoles)) {
            return $this->redirect('/desktop');
        }
        
        $nomenService = $this->get("nomen_service");

        //--------------------------
        //access rights
        $can_create =  $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        
        $can_view_all = $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        
        //--------------------------

        if ($can_view_all) {
            
            $nomenList = $nomenService ->getNomenList($this->getUser());
        } else {
            
            $nomenList = array();
        }
        
        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Номенклатура', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('nomen/nomen_list.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'nomenList' => $nomenList,
            'can_create' => $can_create,
        ));

    }
    
    /**
     * @Route("/nomen-view", name="nomen_view")
     */
    public function nomenViewAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $pnomenId = $request ->get("pnomenid");

        $nomenService = $this->get("nomen_service");
        
        $polisService = $this->get("polis_service");
        
        //--------------------------
        //access rights
        // submit button
        if ($pnomenId !== 'new') {
            $can_edit =  $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_MANAGER','ROLE_TOPMANAGER'));
        } else if ($pnomenId === 'new') {
            $can_edit =  $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        }

        $can_edit_type = $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        
        $can_view_all = $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER'));
        
        $can_view_self = FALSE;
        
        //--------------------------

        if ( $can_view_all ) {
            
            $pnomen = $nomenService ->getNomenById($this->getUser(), $pnomenId );
        } else if ($can_view_self) {

            $pnomen = $nomenService ->getNomenById($this->getUser(), $pnomenId );
        } else {
            
            $pnomen = null;
        }
        
        $insuranceCompanyList = $polisService ->getInsuranceCompanyes($this->getUser());
        
        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Номенклатура', 'url' => $this->generateUrl('nomen_list')),
            array('name' => 'Редактирование номенклатура', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('nomen/nomen_view.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'pnomen' => $pnomen,
            'pinsuranceCompanyList' => $insuranceCompanyList,
            'can_edit' => $can_edit,
            'can_edit_type' => $can_edit_type,
        ));

    }
    
    /**
     * @Route("/nomen-edit/{pnomenid}", name="nomen_edit")
     */
    public function nomenEditAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $gnomenid = $request ->get("pnomenid");
        
        if ( !$is_guest && $this->getUser()->haveRole(array('ROLE_ADMIN','ROLE_TOPMANAGER')) ) {
            
            $pnomenid = $request ->get("c_nomenid");
            $pcompany = $request ->get("c_company");
            $ptitle = $request ->get("c_title");
            
            $polisService = $this->get("polis_service");
            $nomenService = $this->get("nomen_service");
            
            if ( ($gnomenid == 'new') || ($gnomenid == '') ) {

                $pNomen = new Nomen();
                $oldNomen = null;
                
            } else if ( ($gnomenid !== null) && ($gnomenid > 0) && ($gnomenid == $pnomenid) ) {

                $pNomen = $nomenService ->getNomenById($this->getUser(),$pnomenid);
                $oldNomen =  $nomenService->cloneEntity( $this->getUser(),$pNomen );
            }

            if (isset($pNomen) && is_object($pNomen)) {
                
                $pNomen->setCompany($polisService ->getCompanyById($this->getUser(),$pcompany) );
                $pNomen->setTitle($ptitle);

                $nomenService ->saveNomen($this->getUser(),$pNomen, $oldNomen);
            }
        }
        
        return $this->redirect($this->generateUrl('nomen_list'));
    }

    /**
     * @Route("/popup-nomen-list", name="popup_nomen_list")
     */
    public function popupNomenListAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $nomenService = $this->get("nomen_service");
        
        $nomenList = $nomenService ->getNomenList($this->getUser());

        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Номенклатура', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('nomen/popup_nomen_list.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'pnomenList' => $nomenList,
        ));

    }
    
    /**
     * @Route("/popup-prod-list", name="popup_prod_list")
     */
    public function popupProdListAction(Request $request){
        
        $is_guest = !is_object($this->getUser());
        
        $nomenService = $this->get("nomen_service");
        
        $prodList = $nomenService ->getProdList($this->getUser());

        $breadcrumb = array(
            array('name' => 'home', 'url' => $this->generateUrl('home')),
            array('name' => 'Номенклатура', 'url' => null),
        );

        $page_title = $this->container->getParameter('default_title') . ' - ' . $breadcrumb[count($breadcrumb)-1]['name'];

        return $this->render('nomen/popup_prod_list.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'page_title' => $page_title,
            'breadcrumb' => $breadcrumb,
            'pprodList' => $prodList,
        ));

    }
    
}

