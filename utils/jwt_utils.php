<?php
require '../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$secret_key = "TausifPatel";
$issuer = "localhost";

function generateJWT($userId, $expiry = 300) {
    global $secret_key, $issuer;
    $issuedAt = time();
    $payload = [
        "iss" => $issuer,
        "iat" => $issuedAt,
        "exp" => $issuedAt + $expiry,
        "uid" => $userId
    ];
    return JWT::encode($payload, $secret_key, 'HS256');
}

function decodeJWT($jwt) {
    global $secret_key;
    return JWT::decode($jwt, new Key($secret_key, 'HS256'));
}
?>
