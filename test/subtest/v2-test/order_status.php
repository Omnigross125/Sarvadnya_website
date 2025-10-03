<?php
require_once 'authorization.php'; // Included token logic

$environment = 'prod';

$orderStatus_urls = [
    "prod" => "https://api.phonepe.com/apis/pg/checkout/v2/order/{merchantOrderId}/status",
    "uat"  => "https://api-preprod.phonepe.com/apis/pg-sandbox/checkout/v2/order/{merchantOrderId}/status"
];

$FRONTEND_URL = "http://localhost/v2-test"; // Replace with your frontend

if (!isset($_GET['merchantOrderId'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing merchantOrderId parameter.']);
    exit;
}

$merchantOrderId = $_GET['merchantOrderId'];
$token = getValidToken();

if (!$token) {
    http_response_code(500);
    echo json_encode(['error' => 'OAuth token not available. Please try again later.']);
    exit;
}

$urlTemplate = $orderStatus_urls[$environment];
$url = str_replace('{merchantOrderId}', $merchantOrderId, $urlTemplate);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Accept: application/json",
    "Content-Type: application/json",
    "Authorization: O-Bearer $token"
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode === 200) {
    $data = json_decode($response, true);

    if (isset($data['state'])) {
        $state = $data['state'];
        $amount = $data['amount'] ?? 0;

        if ($state === "COMPLETED") {
            header("Location: $FRONTEND_URL/success?merchantOrderId=$merchantOrderId&amount=" . ($amount / 100));   // Kindly change based on your routing
            exit;
        } elseif ($state === "FAILED") {
            header("Location: $FRONTEND_URL/failure?merchantOrderId=$merchantOrderId");        // Kindly change based on your routing
            exit;
        }
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Unexpected response from payment gateway."]);
    }
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to fetch payment status."]);
}

