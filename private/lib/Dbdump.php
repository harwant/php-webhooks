<?php

require_once 'ActionHandler.php';

class Dbdump extends ActionHandler {
    public function serve($payload) {
        // Process dbdump action
        $this->saveLog('dbdump', $payload);
        
        // Access config settings if needed
        // $tokenActions = $this->getConfig('tokenActions');
    }
}

?>