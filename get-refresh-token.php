<?php
require 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('');
$client->setClientSecret('');
$client->setRedirectUri('http://localhost');
$client->addScope(Google_Service_Drive::DRIVE_FILE);
$client->setAccessType('offline');
$client->setPrompt('consent');

if (!isset($_GET['code'])) {
    $authUrl = $client->createAuthUrl();
    echo "Buka link berikut di browser:\n$authUrl\n";
} else {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    echo "Refresh Token: " . $token['refresh_token'] . "\n";
}
