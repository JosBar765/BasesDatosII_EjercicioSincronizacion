<?php

session_start();

require_once("../config/mysql.php");
require_once("../config/postgres.php");
require_once("../utils/bitacora.php");

$data = json_decode(file_get_contents("php://input"), true);

$conexion = $_SESSION["conexion_actual"] ?? null;

if (!$conexion) {

    echo json_encode([
        "success" => false
    ]);

    exit;
}

$db = ($conexion === "mysql")
    ? mysqlConnection()
    : postgresConnection();

$sql = "
UPDATE Empleado
SET
    eliminado = true,
    fecha_modificacion = NOW()
WHERE dpi = :dpi
";

$stmt = $db->prepare($sql);

$stmt->execute([
    ":dpi" => $data["dpi"]
]);

escribirBitacora(
    "DELETE|" .
        $data["dpi"] . "|" .
        date("Y-m-d H:i:s")
);

echo json_encode([
    "success" => true
]);
