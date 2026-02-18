<?php

class ActionHandler {
    protected $logFilePath;
    protected $config;

    public function __construct($logFilePath) {
        $this->logFilePath = $logFilePath;
        $this->loadConfig();
    }

    protected function loadConfig() {
        // Load configuration settings
        $configPath = __DIR__ . '/../config.php';
        if (file_exists($configPath)) {
            include $configPath;
            $this->config = get_defined_vars();
        }
    }

    protected function saveLog($actionName, $payload) {
        $logEntry = date('Y-m-d H:i:s') . ' - Action: ' . $actionName . ' - Payload: ' . json_encode($payload) . PHP_EOL;
        file_put_contents($this->logFilePath, $logEntry, FILE_APPEND);
    }

    protected function getConfig($key = null) {
        if ($key !== null) {
            return $this->config[$key] ?? null;
        }
        return $this->config;
    }
}

?>