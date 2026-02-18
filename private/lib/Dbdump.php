<?php

class Dbdump {
    public function serve($payload, $logFilePath) {
        // Process dbdump action
        // Log the payload to the webhook log file
        $logEntry = date('Y-m-d H:i:s') . ' - Action: dbdump - Payload: ' . json_encode($payload) . PHP_EOL;
        file_put_contents($logFilePath, $logEntry, FILE_APPEND);
    }
}

?>