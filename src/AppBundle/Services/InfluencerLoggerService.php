<?php

namespace AppBundle\Services;

class InfluencerLoggerService {

    private $container;
    private $logger;
    private $loggerData = array();
    private $doLogging;

    public function __construct($logger, $container) {

        $this->container = $container;
        $this ->logger = $logger;
        $this ->doLogging = $this->container->getParameter('do_logging')-0;
    }
    
    public function startLogging($object, $functionName) {
    	return;
        if ($this ->doLogging !== 1) {
            return;
        }
        
        $key = get_class($object)."->".$functionName;
        
        $this->loggerData[get_class($object)."->".$functionName]["start_time"] = microtime(true);
    }
    
    public function endLogging($object, $functionName) {
    	return;
        if ($this ->doLogging !== 1) {
            return;
        }

        $key = get_class($object)."->".$functionName;
        
        $start = $this->loggerData[$key]["start_time"];
        
        unset($this->loggerData[$key]["start_time"]);
        
        $end = microtime(true);
        
        $this->loggerData[$key]["elapsed-time"] = $end - $start;

        $this->logger->info(json_encode(array( $key => $this->loggerData[$key])));
        unset($this->loggerData[$key]);
    }

    public function info($message,$context = array()) {
        if ($this ->doLogging !== 1) {
            return;
        }

        $this->logger->info($message,$context);
    }

    public function error($message,$context = array()) {
        if ($this ->doLogging !== 1) {
            return;
        }

        $this->logger->error($message,$context);
    }
}