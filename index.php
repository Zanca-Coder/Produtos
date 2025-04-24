<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "produtos_db";

$conn = new mysqli($server, $user, $password, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " .$conn->connect_error);
}
?>