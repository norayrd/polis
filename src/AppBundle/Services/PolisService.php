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

        return $this->em->getRepository('AppBundle:Orders') -> findOneBy(array('order_id' => $porderId));
    }

    public function getOrderList( $user ) {
        
        $qb = $this->em->createQueryBuilder();
        
        $qb->select('o')
            ->from('AppBundle:Orders', 'o')
            ->where('(o.company_create=:company_id)'
                    .'or (o.company_from=:company_id)'
                    .'or (o.company_to = :company_id and o.order_sign<>(-20))'
                    )
            ->setParameter('company_id', $user->getCompany()->getCompanyId());
        
        return $qb->getQuery()->getResult();

    }

    public function getOrderSignList( $user, $orderSignId) {

        return $this->em->getRepository('AppBundle:OrderSign') -> findOneBy(array('order_sign_id' => $orderSignId));
    }

    public function getOrderTypeById( $user, $orderTypeId) {

        return $this->em->getRepository('AppBundle:orderType') -> findBy(array('order_type_id' => $orderTypeId));
    }
    
}
