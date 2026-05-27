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
        primer_nombre = :primer_nombre,
        segundo_nombre = :segundo_nombre,
        primer_apellido = :primer_apellido,
        segundo_apellido = :segundo_apellido,
        direccion = :direccion,
        telefono_casa = :telefono_casa,
        telefono_movil = :telefono_movil,
        salario_base = :salario_base,
        bonificacion = :bonificacion,
        fecha_modificacion = NOW()
    WHERE dpi = :dpi
    AND eliminado = false
    ";

    $stmt = $db->prepare($sql);

    $stmt->execute([

        ":dpi" => $data["dpi"],
        ":primer_nombre" => $data["primer_nombre"],
        ":segundo_nombre" => $data["segundo_nombre"],
        ":primer_apellido" => $data["primer_apellido"],
        ":segundo_apellido" => $data["segundo_apellido"],
        ":direccion" => $data["direccion"],
        ":telefono_casa" => $data["telefono_casa"],
        ":telefono_movil" => $data["telefono_movil"],
        ":salario_base" => $data["salario_base"],
        ":bonificacion" => $data["bonificacion"]

    ]);


    echo json_encode([
        "success" => true,
        "message" => "Empleado actualizado"
    ]);
} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
