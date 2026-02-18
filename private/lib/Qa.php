<?php

class Qa {
    public function serve($payload, $logFilePath) {
        // Process qa action
        // Log the payload to the webhook log file
        $logEntry = date('Y-m-d H:i:s') . ' - Action: qa - Payload: ' . json_encode($payload) . PHP_EOL;
        file_put_contents($logFilePath, $logEntry, FILE_APPEND);
    }
}

?>