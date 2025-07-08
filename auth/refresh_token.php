<?php
require '../config/db.php';
require '../utils/jwt_utils.php';

if (!isset($_COOKIE['refresh_token'])) {
    http_response_code(401);
    echo json_encode(['message' => 'No refresh token']);
    exit;
}

$refreshToken = $_COOKIE['refresh_token'];

// $stmt = $pdo->prepare("SELECT * FROM users WHERE refresh_token = ?");
$stmt = mysqli_query($conn,"SELECT * FROM users WHERE refresh_token = '$refreshToken'");
// $stmt->execute([$refreshToken]);
$user = mysqli_fetch_array($stmt, MYSQLI_ASSOC);

if ($user) {
    $accessToken = generateJWT($user['id']);
    echo json_encode(['accessToken' => $accessToken]);
} else {
    http_response_code(401);
    echo json_encode(['message' => 'Invalid refresh token']);
}
?>