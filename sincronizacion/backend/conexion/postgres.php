<?php

session_start();

require_once("../config/credenciales.php");

try {

    $pdo = new PDO(
        "pgsql:host=" . Postgres_HOST . ";port=" . Postgres_PORT . ";dbname=" . Postgres_DBNAME,
        Postgres_USER,
        Postgres_PASSWORD
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $_SESSION["conexion_actual"] = "postgres";

    echo json_encode([
        "success" => true,
        "message" => "Conexión exitosa a PostgreSQL"
    ]);
} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
