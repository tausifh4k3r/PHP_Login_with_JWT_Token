<?php
require '../config/db.php';

if (isset($_COOKIE['refresh_token'])) {
    $refreshToken = $_COOKIE['refresh_token'];

    $stmt = $pdo->prepare("UPDATE users SET refresh_token = NULL WHERE refresh_token = ?");
    $stmt->execute([$refreshToken]);

    setcookie('refresh_token', '', time() - 3600, '/', '', true, true);
}

http_response_code(200);
echo json_encode(['message' => 'Logged out']);
?>