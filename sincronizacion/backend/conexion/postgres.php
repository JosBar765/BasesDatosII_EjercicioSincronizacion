<?php

session_start();

$_SESSION["conexion_actual"] = "postgres";

echo json_encode([
    "success" => true,
    "conexion" => "postgres"
]);
