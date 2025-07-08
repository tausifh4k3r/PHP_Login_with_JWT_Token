<?php
require '../config/db.php';
require '../utils/jwt_utils.php';

$headers = getallheaders();
if (!isset($headers['Authorization'])) {
    http_response_code(401);
    exit(json_encode(['message' => 'Unauthorized']));
}

$jwt = str_replace("Bearer ", "", $headers['Authorization']);

try {

    $decoded = decodeJWT($jwt);
    $userId = $decoded->uid;

    $stmt = mysqli_query($conn,"SELECT `email` FROM `users` WHERE `id` = '$userId'");

    $user = mysqli_fetch_array($stmt, MYSQLI_ASSOC);

    echo json_encode([
        "name" => $user['email']
    ]);

} catch (Exception $e) {

    http_response_code(401);
    echo json_encode(['message' => 'Token invalid']);

}

?>