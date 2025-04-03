<?php

include '../connect.php';

function authentication($pdo){
    $headers = getallheaders();
    $token = $headers['Authorization'];

    if (!$token) {
        http_response_code(404);
        echo json_encode(["error" => "Authorization token required"]);
        exit;
    }

    $stmt = $pdo->prepare("select * from userv2 where access_token = :access_token");
    $stmt->execute([':access_token' => $token]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        http_response_code(404);
        echo json_encode(['Error' => "Invalid or expired token"]);
        exit();
    }

    return $user;
}

$user = authentication($pdo);

echo json_encode([
    "message" => "Welcome, authorized user",
    "user" => [
        "id" => $user['id'],
        "username" => $user['username'],
        "mail" => $user['mail'],
    ]
]);