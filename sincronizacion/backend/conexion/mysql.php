<?php

session_start();

$_SESSION["conexion_actual"] = "mysql";

echo json_encode([
    "success" => true,
    "conexion" => "mysql"
]);
