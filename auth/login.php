<?php
require '../config/db.php';
require '../utils/jwt_utils.php';

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'];
$password = $data['password'];
$stmt = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND password = '$password'");
$user = mysqli_fetch_array($stmt, MYSQLI_ASSOC);
if ($user) {
    $accessToken = generateJWT($user['id']);
    $refreshToken = bin2hex(random_bytes(64));
    
    $stmt = mysqli_query($conn, "UPDATE users SET refresh_token = '$refreshToken' WHERE id = '$user[id]'");

    // Send access token in response, refresh token as HttpOnly cookie
    setcookie("refresh_token", $refreshToken, [
        'httponly' => true,
        'samesite' => 'Strict',
        'secure' => true
    ]);
    
    echo json_encode([
        'accessToken' => $accessToken,
        'message' => 'Login successful'
    ]);
} else {
    http_response_code(401);
    echo json_encode(['message' => 'Invalid credentials']);
}
?>
