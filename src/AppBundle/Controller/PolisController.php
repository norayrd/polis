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
        
        $polisService = $this->get("polis_service");

        /*$is_guest = !is_object($this->getUser());
        
        $polisService = $this->get("polis_service");

        $polisList = $polisService ->getPolisList($this->getUser());
         */
        
        return $this->render('polis/order_list.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
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
        
        return $this->render('polis/polis_list.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
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

        $polisId = $request ->get("polisid");
        
        var_dump('Sorry, but "user account" yet not ready!');exit;
        
        /*return $this->render('polis/polis-view.html.twig', array(
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
        
        return $this->render('polis/report.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'breadcrumb' => $breadcrumb,
        ));

    }
    
}

