<?php

include '../vendor/autoload.php';
include '../connect.php';

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$mail = $data['mail'];
$password = password_hash($data['password'], PASSWORD_BCRYPT);

$stmt = $pdo->prepare("insert into userv3 (username, mail, password) values (:username, :mail, :password)");
$success = $stmt->execute([
    ':username' => $username,
    ':mail' => $mail,
    ':password' => $password
]);

if ($success) {
    echo json_encode(["message" => "User registered successfully"]);
} else {
    echo json_encode(["error" => "Registration failed"]);
}