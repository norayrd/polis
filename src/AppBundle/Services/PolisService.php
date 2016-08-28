<?php

namespace AppBundle\Services;

use DateInterval;
use DateTime;

class PolisService {
    
    private $em;
    private $logger;
    
    public function __construct($logger, $em ) {

        $this->em = $em;
        $this->logger = $logger;
    }

    public function getPolis($user, $polisId) {
        
        $polis = $this->em->getRepository('AppBundle:Polis') 
                -> findOneBy(array('id'=> $polisId ));
        
        return $polis;
    }
    
    public function getPolisList($user) {
        
        $polisList = $this->em->getRepository('AppBundle:Polis') 
                -> findBy(array());
        
        return $polisList;
    }
    
}
