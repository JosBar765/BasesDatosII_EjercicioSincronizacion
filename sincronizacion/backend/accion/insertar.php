<?php

session_start();

require_once("../config/mysql.php");
require_once("../config/postgres.php");
require_once("../bitacora/bitacora.php");

$data = json_decode(file_get_contents("php://input"), true);

$conexion = $_SESSION["conexion_actual"] ?? null;

if (!$conexion) {

    echo json_encode([
        "success" => false,
        "message" => "No hay conexión seleccionada"
    ]);

    exit;
}

$db = ($conexion === "mysql")
    ? mysqlConnection()
    : postgresConnection();

$sql = "
INSERT INTO Empleado (
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
)
VALUES (
    :dpi,
    :primer_nombre,
    :segundo_nombre,
    :primer_apellido,
    :segundo_apellido,
    :direccion,
    :telefono_casa,
    :telefono_movil,
    :salario_base,
    :bonificacion,
    NOW(),
    false
)
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

escribirBitacora(
    "INSERT|" .
        $data["dpi"] . "|" .
        date("Y-m-d H:i:s")
);

echo json_encode([
    "success" => true
]);
