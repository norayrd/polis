<?php

namespace AppBundle\Services;

use DateTime;

class NomenService {
    
    private $em;
    private $logger;
    private $container;
    
    public function __construct($logger, $em, $container ) {

        $this->em = $em;
        $this->logger = $logger;
        $this->container = $container;
    }

    /*
    public function reverseNomen( $nomenId, $userId) {

        return $this->em->getRepository('AppBundle:Nomen') -> reverseNomen($nomenId, $userId);
    }
    
    public function addNomen( $nomen, $userId) {

        return $this->em->getRepository('AppBundle:Nomen') -> addNomen($nomen, $userId);
    }
     */

    public function getNomenById( $user, $pnomenId) {

        return $this->em->getRepository('AppBundle:Nomen') -> findOneBy(array('nomen_id' => $pnomenId));
    }

    public function saveNomen( $user, $pNomen, $oldNomen = null) {

        if (is_object($oldNomen)) {
            $oldNomen->setActualId($pNomen->getNomenId());
            $this->em->persist($oldNomen);
        }

        $pNomen->setDateCurr(new DateTime());
        $pNomen->setUserId($user->getId());
        
        $this->em->persist($pNomen);
        $this->em->flush();
        
        return true;
    }
    
    public function cloneEntity( $user, $pEntity) {
        
        $oldEntity = clone $pEntity;
        $this->em->detach($oldEntity);
        
        return $oldEntity;
    }
    
    public function getNomenList($user) {

        return $this->em->getRepository('AppBundle:Nomen') -> findBy(array('actual_id' => null));
    }

    public function getProdList($user) {

        return array();
    }
    
}