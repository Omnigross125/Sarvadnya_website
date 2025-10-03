<?php

// Environment setting: 'uat' or 'prod'
$environment = 'prod';

// API URLs based on the environment
$auth_urls = [
    "prod" => "https://api.phonepe.com/apis/identity-manager/v1/oauth/token",
    "uat"  => "https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token"
];

// Select URLs dynamically
$auth_url = $auth_urls[$environment];

// Payload with credentials — make sure these are securely stored in production
$payload = [
    "client_id" => "SU2506251831012893462099",                          // Enter client_id
    "client_version" => "1",                // Enter client_version
    "client_secret" => "ab004146-8094-44b0-aa81-a0edd236e9ad",       // Enter client_secret
    "grant_type" => "client_credentials" 
];

// Token storage
$accessToken = null;
$tokenExpiry = null;

/**
 * Fetch OAuth Token from PhonePe
 */
function fetchOAuthToken()
{
    global $auth_url, $accessToken, $tokenExpiry, $payload;

    // Convert payload to URL-encoded string
    $postData = http_build_query($payload);

    $ch = curl_init($auth_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        $data = json_decode($response, true);

        if (isset($data['access_token'], $data['expires_at'])) {
            $accessToken = $data['access_token'];
            $tokenExpiry = $data['expires_at'] * 1000; // Convert to milliseconds
        } else {
            error_log("Missing token or expiry info in response: " . $response);
        }
    } else {
        error_log("Failed to fetch token. HTTP Code: $httpCode. Response: $response");
    }
}

/**
 * Get valid token, refresh if needed
 */
function getValidToken()
{
    global $accessToken, $tokenExpiry;

    $currentTime = round(microtime(true) * 1000); // current time in ms

    // Refresh if token is about to expire (within 5 minutes)
    if (!$tokenExpiry || $tokenExpiry - $currentTime <= (5 * 60 * 1000)) {
        fetchOAuthToken();
    }

    return $accessToken;
}

/**
 * Example endpoint: Return token if valid
 */
function tokenHandler()
{
    $token = getValidToken();

    if ($token) {
        $expiresIn = floor(($GLOBALS['tokenExpiry'] - round(microtime(true) * 1000)) / 1000);
        header('Content-Type: application/json');
        // echo json_encode([
        //     'access_token' => $token,
        //     'expires_in' => $expiresIn
        // ]);

        // print_r(json_encode([
        //     'access_token' => $token,
        //     'expires_in' => $expiresIn
        // ]));
        
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Token not available or expired.']);
        error_log("Access token is null or expired.");
    }
}

// Optional: Fetch on script start
fetchOAuthToken();

// Usage example
 tokenHandler(); // Call this in a route/controller when needed

?>
