<?php
require '../connect.php';
require '../vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

function authenticate($pdo)
{
    $headers = getallheaders();
    $jwt = $headers['Authorization'];

    if (!$jwt) {
        http_response_code(404);
        echo json_encode(["error" => "Authorization token required"]);
        exit;
    }

    try {
        $secret_key = "all_right_reserved_by_leang_vakhim";
        $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
        return $decoded->data;
    } catch (Exception $e) {
        http_response_code(404);
        echo json_encode(["error" => "Invalid or expired token", "details" => $e->getMessage()]);
        exit;
    }
}

$user = authenticate($pdo);

echo json_encode([
    "message" => "Access allowance",
    "user" => $user
]);