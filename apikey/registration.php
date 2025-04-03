<?php

include "../connect.php";

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$password = password_hash($data['password'], PASSWORD_BCRYPT);

$apikey = bin2hex(random_bytes(16));

$stmt = $pdo->prepare("insert into userv1 (username, password, apikey) values (:username, :password, :apikey)");
if($stmt->execute([
    ':username' => $username,
    ':password' => $password,
    ':apikey' => $apikey
])){
    echo json_encode(['message' => "User created", "apikey" => $apikey]);
}else {
    echo json_encode(['error' => "Could not create user"]);
}