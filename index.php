<?php

// Configuration: Map Bearer tokens to allowed actions
$tokenActions = [
    'token1' => ['process_payment', 'update_inventory'],
    'token2' => ['send_notification'],
    'your-preset-bearer-token' => ['log_data', 'process_webhook'], // Example
];

// Set response header
header('Content-Type: application/json');

// Get the Authorization header
$authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

if (!preg_match('/^Bearer\s+(.+)$/', $authHeader, $matches)) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$providedToken = $matches[1];

if (!isset($tokenActions[$providedToken])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Get the JSON payload from the request body
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON payload']);
    exit;
}

// Check if action is specified and allowed
$action = $data['action'] ?? null;
if (!$action || !in_array($action, $tokenActions[$providedToken])) {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden: Action not allowed']);
    exit;
}

// Process the webhook data (example: log to file)
$logEntry = date('Y-m-d H:i:s') . ' - Action: ' . $action . ' - Webhook received: ' . json_encode($data) . PHP_EOL;
file_put_contents('webhook_log.txt', $logEntry, FILE_APPEND);

// Respond with success
echo json_encode(['status' => 'success', 'message' => 'Webhook processed', 'action' => $action]);

?>