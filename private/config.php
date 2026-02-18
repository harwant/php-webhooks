<?php

// Configuration file for webhook handler

// Map Bearer tokens to allowed actions
$tokenActions = [
    'cusg-Z4cF9vLMvf7SRPZ1T90rhlUucCIdSJHfGdjtOW2VPiAXEXtcVXyT7uV0WBqJClyB' => ['dbdump', 'qa'], // Example
];

// Log file path
$logFilePath = __DIR__ . '/logs/webhook_log.txt';

// Lib directory path
$libPath = __DIR__ . '/lib/';

?>