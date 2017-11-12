<?php

namespace AppBundle\Services;

class PolisService {
    
    private $em;
    private $logger;
    private $container;
    
    public function __construct($logger, $em, $container ) {

        $this->em = $em;
        $this->logger = $logger;
        $this->container = $container;
    }

}