<?php

date_default_timezone_set("America/Guatemala");

header("Content-Type: application/json");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../conexion/database.php");

try {

    $data = json_decode(
        file_get_contents("php://input"),
        true
    );

    if ($data === null) {

        echo json_encode([
            "success" => false,
            "message" => "JSON inválido"
        ]);

        exit;
    }

    $conexion = $_SESSION["conexion_actual"] ?? null;

    if (!$conexion) {

        echo json_encode([
            "success" => false,
            "message" => "No hay conexión activa"
        ]);

        exit;
    }

    $db = ($conexion === "mysql")
        ? mysqlConnection()
        : postgresConnection();

    $nombre_tabla = ($conexion === "mysql")
        ? "Empleado"
        : '"Empleado"';

    $sql = "
    UPDATE $nombre_tabla
    SET
        eliminado = true,
        fecha_modificacion = NOW()
    WHERE dpi = :dpi
    ";

    $stmt = $db->prepare($sql);

    $stmt->execute([
        ":dpi" => $data["dpi"]
    ]);

    echo json_encode([
        "success" => true,
        "message" => "Empleado eliminado"
    ]);
} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
