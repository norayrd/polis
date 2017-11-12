<?php

namespace AppBundle\Services;

use DateTime;

class OrderService {
    
    private $em;
    private $logger;
    private $container;
    
    public function __construct($logger, $em, $container ) {

        $this->em = $em;
        $this->logger = $logger;
        $this->container = $container;

    }

    public function getOrderById( $user, $porderId) {
        
        $order = array();
                
        if (is_numeric($porderId)) {
            $order = $this->em->getRepository('AppBundle:Orders') -> findOneBy(array('order_id' => $porderId));
        }

        return $order;
    }

    public function getOrderList( $user ) {
        
        $qb = $this->em->createQueryBuilder();
        
        $qb->select('o')
            ->from('AppBundle:Orders', 'o')
            ->where('(o.actual_id is null)'
                    .'and (  (o.company_create=:company_id)'
                    .'     or(o.company_from=:company_id)'
                    .'     or(o.company_to = :company_id and o.order_sign<>-20)'
                    .'    )'
                    )
            ->setParameter('company_id', $user->getCompany()->getCompanyId());
        
        return $qb->getQuery()->getResult();

    }

    public function getOrderSignList( $user ) {

        return $this->em->getRepository('AppBundle:OrderSign') -> findBy(array());
    }

    public function getOrderSignById( $user, $orderSignId) {

        return $this->em->getRepository('AppBundle:OrderSign') -> findOneBy(array('order_sign_id' => $orderSignId));
    }

    public function getOrderTypeById( $user, $orderTypeId) {

        return $this->em->getRepository('AppBundle:OrderType') -> findOneBy(array('order_type_id' => $orderTypeId));
    }

    public function saveOrder( $user, $pOrder, $oldOrder = null) {
        
        //var_dump(is_object($oldOrder));exit;
        
        if (is_object($oldOrder)) {
            $oldOrder->setActualId($pOrder->getOrderId());
            $this->em->persist($oldOrder);
        }

        $pOrder->setDateCurr(new DateTime());
        $pOrder->setUserId($user->getId());
        
        $this->em->persist($pOrder);
        $this->em->flush();

        return true;
    }
    
    public function cloneEntity( $user, $pEntity) {
        
        $oldEntity = clone $pEntity;
        $this->em->detach($oldEntity);
        
        return $oldEntity;
    }

}