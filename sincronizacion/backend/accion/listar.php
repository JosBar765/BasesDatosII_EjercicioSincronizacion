<?php

date_default_timezone_set("America/Guatemala");

header("Content-Type: application/json");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../conexion/database.php");

try {

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
        SELECT
            dpi,
            primer_nombre,
            segundo_nombre,
            primer_apellido,
            segundo_apellido,
            direccion,
            telefono_casa,
            telefono_movil,
            salario_base,
            bonificacion,
            fecha_modificacion,
            eliminado
        FROM $nombre_tabla
        WHERE eliminado = false
        ORDER BY fecha_modificacion DESC
    ";

    $stmt = $db->prepare($sql);

    $stmt->execute();

    $empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "data" => $empleados
    ]);
} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
