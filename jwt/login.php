<?php
require '../connect.php';
require '../vendor/autoload.php';

use \Firebase\JWT\JWT;

$secret_key = "all_right_reserved_by_leang_vakhim";
$issuer = "localhost";

$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$password = $data['password'];

$stmt = $pdo->prepare("select * from userv3 where username = :username");
$stmt->execute([':username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || !password_verify($password, $user['password'])) {
    echo json_encode(["error" => "Invalid credentials"]);
    exit;
}

$issued_at = time();
$expiration_time = $issued_at + (60 * 10); // valid 10 minutes

$payload = [
    "iss" => $issuer,
    "iat" => $issued_at,
    "exp" => $expiration_time,
    "data" => [
        "id" => $user['id'],
        "username" => $user['username'],
        "mail" => $user['mail']
    ]
];

$jwt = JWT::encode($payload, $secret_key, 'HS256');

echo json_encode([
    "message" => "Login successful",
    "token" => $jwt
]);