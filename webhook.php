<?php

$VERIFY_TOKEN = "calz_ig_webhook_2026";

// =============================
// Verifikasi Webhook
// =============================
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $mode = $_GET['hub_mode'] ?? $_GET['hub.mode'] ?? '';
    $token = $_GET['hub_verify_token'] ?? $_GET['hub.verify_token'] ?? '';
    $challenge = $_GET['hub_challenge'] ?? $_GET['hub.challenge'] ?? '';

    if ($mode === 'subscribe' && $token === $VERIFY_TOKEN) {
        http_response_code(200);
        echo $challenge;
        exit;
    }

    http_response_code(403);
    exit('Verification failed');
}

// =============================
// Terima Event Instagram
// =============================

$data = file_get_contents("php://input");

file_put_contents(
    __DIR__ . "/webhook_log.txt",
    date("Y-m-d H:i:s") . PHP_EOL .
    $data . PHP_EOL .
    "==============================" . PHP_EOL,
    FILE_APPEND
);

http_response_code(200);
echo "EVENT_RECEIVED";