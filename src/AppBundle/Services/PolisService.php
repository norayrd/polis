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

    public function reverseCompany( $companyId, $userId) {

        return $this->em->getRepository('AppBundle:Company') -> reverseCompany($companyId, $userId);
    }
    
    public function addCompany( $company, $userId) {

        return $this->em->getRepository('AppBundle:Company') -> addCompany($company, $userId);
    }

    public function getCompanyById( $user, $pcompanyId) {

        return $this->em->getRepository('AppBundle:Company') -> findOneBy(array('company_id' => $pcompanyId));
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
    
    public function saveCompany( $user, $pcompany) {
        
        $this->em->persist($pcompany);
        $this->em->flush();

        return true;
    }
    
    public function getOrderById( $user, $porderId) {

        return $this->em->getRepository('AppBundle:Order') -> findOneBy(array('order_id' => $porderId));
    }

}
