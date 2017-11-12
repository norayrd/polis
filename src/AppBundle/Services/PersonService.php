<?php

namespace AppBundle\Services;

class PersonService {
    
    private $em;
    private $logger;
    private $container;
    
    public function __construct($logger, $em, $container ) {

        $this->em = $em;
        $this->logger = $logger;
        $this->container = $container;

    }

    public function getPersonById( $user, $ppersonId) {

        return $this->em->getRepository('AppBundle:Person') -> findOneBy(array('person_id' => $ppersonId));
    }

    public function getPersonList( $userId) {

        return $this->em->getRepository('AppBundle:Person') -> findBy(array());
    }
    
    public function savePerson( $user, $pperson) {
        
        $this->em->persist($pperson);
        $this->em->flush();

        return true;
    }
    
    public function cloneEntity( $user, $pEntity) {
        
        $oldEntity = clone $pEntity;
        $this->em->detach($oldEntity);
        
        return $oldEntity;
    }

}