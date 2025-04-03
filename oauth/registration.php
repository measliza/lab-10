<?php

include "../connect.php";

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$mail = $data['mail'];
$password = password_hash($data['password'], PASSWORD_BCRYPT);

$access_token = bin2hex(random_bytes(16));

$stmt = $pdo->prepare("insert into userv2 (username, mail, password, access_token) values (:username, :mail, :password, :access_token)");
if ($stmt->execute([
    ':username' => $username,
    ':mail' => $mail,
    ':password' => $password,
    ':access_token' => $access_token
])) {
    echo json_encode([
        'message' => "User registerd successfully",
        "access_token" => $access_token
    ]);
} else {
    echo json_encode(['error' => "Could not register user"]);
}