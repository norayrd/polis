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

use AppBundle\Entity\User;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;

/**
 * Controller used to manage the application security.
 * See http://symfony.com/doc/current/cookbook/security/form_login_setup.html.
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class MainController extends Controller
{

    /**
     * @Route("/", name="home")
     */
    public function indexAction(Request $request){

        $is_guest = !is_object($this->getUser());
        
        /*return $this->render('polis/index.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));*/
        
        return $this->redirect('/desktop');

    }

    /**
     * @Route("/desktop", name="desktop")
     */
    public function desktopAction(Request $request){

        $is_guest = !is_object($this->getUser());
        
        $breadcrumb = array(
            array('name' => 'home', 'url' => 'home'),
            array('name' => 'branch2', 'url' => 'url2'),
            array('name' => 'branch3', 'url' => 'url3'),
            );
        
        return $this->render('polis/desktop.html.twig', array(
            'user' => $this->getUser(),
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'breadcrumb' => $breadcrumb,
        ));

    }

}
