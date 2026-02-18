<?php

// Configuration file for webhook handler
// Copy this file to config.php and add your actual settings

// Map Bearer tokens to allowed actions
// IMPORTANT: Replace with your actual bearer tokens and actions
$tokenActions = [
    'your-secret-bearer-token-here' => ['action1', 'action2'],
];

// Log file path
$logFilePath = __DIR__ . '/logs/webhook_log.txt';

// Lib directory path
$libPath = __DIR__ . '/lib/';

?>