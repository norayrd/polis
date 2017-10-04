<?php

namespace AppBundle\Services;

use DateInterval;
use DateTime;

class SecurityService {
    
    private $em;
    private $logger;
    
    public function __construct($logger, $em ) {

        $this->em = $em;
        $this->logger = $logger;
    }

    /*
     * Checking if $username found in User -s list
     */
    public function findUsername( $username ) {
        
        $user = $this->em->getRepository('AppBundle:User') 
                -> findOneBy(array('username'=> $username ));

        return $user;
    }
    
    /*
     * Geting user by email
     */
    public function findUserByEmail( $email ) {
        
        $user = $this->em->getRepository('AppBundle:User') 
                -> findOneBy(array('email'=> $email ));

        return $user;
    }

    public function getForgotPasswordHash($user, $key) {
        
        $expireDate = new DateTime();
        $expireDate->add(new DateInterval('P1D'));
        
        $hash =  md5($user->getEmail() . $expireDate->format("Y-m-d h:m:s") . $key);
        
        $user->setForgotPasswordHash($hash);
        $user->setForgotPasswordExpireDatetime($expireDate);
        $user = $this->em->merge($user);
        $this->em->flush();
        
        return $user->getForgotPasswordHash();
    }
    
    /*
     * Getting UserRoles list
     */
    public function getUserRolesList($user) {
        
        $userRolesList = $this->em->getRepository('AppBundle:UserRoles') 
                -> findBy(array());

        return $userRolesList;
    }
    
}
