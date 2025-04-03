<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include '../connect.php';

function checkApiKey($pdo){
    $headers = getallheaders();
    $key = $headers['x-api-key'];

    if(!$key){
        http_response_code(404);
        echo json_encode(["error" => "API Key required"]);
        exit;
    }

    $stmt = $pdo->prepare("select * from userv1 where apikey = :apikey");
    $stmt->execute([':apikey' => $key]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$user){
        http_response_code(404);
        echo json_encode(['Error' => "Invalid API Key"]);
        exit();
    }

    return $user;
}

$user = checkApiKey($pdo);

echo json_encode([
    "message" => "Authenticated successful",
    "user" => [
        "id" => $user['id'],
        "username" => $user['username'],
        "password" => password_hash($user['password'], PASSWORD_BCRYPT),
    ]
]);