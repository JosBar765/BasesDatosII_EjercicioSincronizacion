<?php

session_start();

require_once("../config/credenciales.php");

try {

    $pdo = new PDO(
        "mysql:host=" . MySQL_HOST . ";dbname=" . MySQL_DBNAME,
        MySQL_USER,
        MySQL_PASSWORD
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $_SESSION["conexion_actual"] = "mysql";

    echo json_encode([
        "success" => true,
        "message" => "Conexión exitosa a MySQL"
    ]);
} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
