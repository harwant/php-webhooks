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

// Database configuration - Production
$db_production = [
    'db_host' => 'your-production-host',
    'db_user' => 'your-production-user',
    'db_password' => 'your-production-password',
];

// Database configuration - QA
$db_qa = [
    'db_host' => 'your-qa-host',
    'db_user' => 'your-qa-user',
    'db_password' => 'your-qa-password',
];

// Database dump directory
$dumpDir = __DIR__ . '/dumps';

?>