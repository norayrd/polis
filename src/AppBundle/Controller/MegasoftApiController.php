<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MegasoftApiController extends Controller
{
    /**
     * @Route("/get-card", name="get-card")
     */
    public function getCardAction(Request $request)
    {
        $commonCard = file_get_contents('./data/111.xml');
        $commonCard2 = iconv("windows-1251", "utf-8", $commonCard);
        
        $response = new Response();
        $response->setContent($commonCard2);
        $response->headers->set('Content-Type', 'text/xml');
        return $response;
    }
}
