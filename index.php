<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

echo json_encode(array("Mensagem" => "Hello! Bem vindos à Juca Pizzas!"));
?>
