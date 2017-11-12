<?php

namespace AppBundle\Services;

class CompanyService {
    
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
    
    public function getAgentCompanyes( $user) {

        return $this->em->getRepository('AppBundle:Company') -> findBy(array('parent' => $user->getCompany()));
    }

    public function getInsuranceCompanyes( $user) {

        return $this->em->getRepository('AppBundle:Company') -> findBy(array('type' => 2));
    }

    public function saveCompany( $user, $pcompany) {
        
        $this->em->persist($pcompany);
        $this->em->flush();

        return true;
    }
    
    public function cloneEntity( $user, $pEntity) {
        
        $oldEntity = clone $pEntity;
        $this->em->detach($oldEntity);
        
        return $oldEntity;
    }

}