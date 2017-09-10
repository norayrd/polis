<?php

namespace AppBundle\Services;

use DateInterval;
use DateTime;

class PolisService {
    
    private $em;
    private $logger;
    private $container;
    
    public function __construct($logger, $em, $container ) {

        $this->em = $em;
        $this->logger = $logger;
        $this->container = $container;

    }

    /*public function getPolis($user, $polisId) {
        
        $polis = $this->em->getRepository('AppBundle:Polis') 
                -> findOneBy(array('id'=> $polisId ));
        
        return $polis;
    }
    
    public function getPolisList($user) {
        
        $polisList = $this->em->getRepository('AppBundle:Polis') 
                -> findBy(array());
        
        return $polisList;
    }*/
    
    public function reverseCompany( $companyId, $userId) {

        return $this->em->getRepository('AppBundle:Company') -> reverseCompany($companyId, $userId);
    }
    
    public function addCompany( $company, $userId) {

        return $this->em->getRepository('AppBundle:Company') -> addCompany($company, $userId);
    }

    public function getCompanyList( $userId) {

        return $this->em->getRepository('AppBundle:Company') -> findBy(array());
    }

    public function getUserById( $user, $puserId) {

        return $this->em->getRepository('AppBundle:User') -> findOneBy(array('id' => $puserId));
    }

    public function getUserList( $userId) {

        return $this->em->getRepository('AppBundle:User') -> findBy(array());
    }
    
    public function saveUser( $user, $puser) {
        
        $this->em->persist($puser);
        $this->em->flush();

        return true;
    }
    
}
