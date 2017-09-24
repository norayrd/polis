<?php

namespace AppBundle\Services;

use AppBundle\Entity\IKey;
use DateInterval;
use DateTime;

class IKeyService {
    
    private $em;
    private $logger;
    
    public function __construct($logger, $em ) {

        $this->em = $em;
        $this->logger = $logger;
    }

    /*
     * Checking if $username found in User -s list
     */
    public function findIKey( $email, $hash ) {
        
        $iKey = $this->em->getRepository('AppBundle:IKey') 
                -> findOneBy(array('email' => $email, 'i_key'=> $hash ));
        
        $res = false;

        if (is_object($iKey) ) {

            $currDt = new DateTime();
            $iKeyDt = $iKey->getDateCurr();
            $iKeyDt->add(new DateInterval('P1D'));
            if ($currDt->getTimestamp() <= $iKeyDt->getTimestamp()) {
                $res = $iKey;
            }
        } 

        return $res;
    }
    
    /*
     * Checking if $username found in User -s list
     */
    public function createIKey($user, $pemail, $pcompanyId, $secret ) {
       
        $piKey= null;
                
        if ( isset($pemail) && isset($pcompanyId) ) {
            
            $dateCurr = new DateTime();
            $hash =  md5($user->getEmail() . $dateCurr->format("Y-m-d h:m:s") . $secret);
            
            $piKey = new IKey();
            $piKey->setCompanyId($pcompanyId);
            $piKey->setEmail($pemail);
            $piKey->setDateCurr($dateCurr);
            $piKey->setIKey($hash);
            $piKey->setData(array());
            $piKey->setUserId($user->getId());
            $this->em->merge($piKey);
            $this->em->flush();
            
        }
        
        return $piKey;
    }
    
}
