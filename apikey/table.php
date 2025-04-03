<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "lab10db";

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
try{
    $sqlUser = "create table if not exists userv1(
                id int auto_increment primary key,
                username varchar(255),
                password varchar(255),
                apikey varchar(255) unique
                )";
    $pdo->query($sqlUser);
    echo "Create table successfully";
}catch(Exception $e){
    echo "Error: ".$e->getMessage();
}