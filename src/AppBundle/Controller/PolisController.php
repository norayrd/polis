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
     * @Route("/polis-list", name="polis_list")
     */
    public function polisListAction(Request $request){

        $is_guest = !is_object($this->getUser());
        
        $polisService = $this->get("polis_service");

        $polisList = $polisService ->getPolisList($this->getUser());
        
        return $this->render('polis/polisList.html.twig', array(
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
        
        return $this->render('polis/polisList.html.twig', array(
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
        var_dump($polisId);exit;

        
        return $this->render('polis/polisList.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));

    }

}
