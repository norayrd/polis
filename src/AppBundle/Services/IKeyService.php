<?php

namespace AppBundle\Services;

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
    public function checkIKey( $email, $pikey ) {
        
        $iKey = $this->em->getRepository('AppBundle:IKey') 
                -> findOneBy(array('email' => $email, 'i_key'=> $pikey ));
        
        $res = false;

        if (is_object($iKey) ) {

            $aData = $iKey->getData();
            
            if (is_array($aData) && isset($aData['dateCurr'])) {
                
                $currDT = new \DateTime();
                $iKeyDT = $aData['dateCurr'];
                if ($currDT->getTimestamp() > $iKeyDT->getTimestamp()) {
                    $res = true;
                }
            }
        } 

        return $res;
    }
    
}
