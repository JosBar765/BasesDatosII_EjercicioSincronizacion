<?php

require_once("../config/mysql.php");
require_once("../config/postgres.php");

$mysql = mysqlConnection();
$postgres = postgresConnection();

$mysqlData = $mysql
    ->query("SELECT * FROM Empleado")
    ->fetchAll(PDO::FETCH_ASSOC);

$postgresData = $postgres
    ->query("SELECT * FROM Empleado")
    ->fetchAll(PDO::FETCH_ASSOC);

$mysqlMap = [];
$postgresMap = [];

foreach ($mysqlData as $row) {
    $mysqlMap[$row["dpi"]] = $row;
}

foreach ($postgresData as $row) {
    $postgresMap[$row["dpi"]] = $row;
}

foreach ($mysqlMap as $dpi => $mysqlRow) {

    if (!isset($postgresMap[$dpi])) {

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
            :fecha_modificacion,
            :eliminado
        )
        ";

        $stmt = $postgres->prepare($sql);

        $stmt->execute($mysqlRow);
    } else {

        $postgresRow = $postgresMap[$dpi];

        if (
            strtotime($mysqlRow["fecha_modificacion"]) >
            strtotime($postgresRow["fecha_modificacion"])
        ) {

            $sql = "
            UPDATE Empleado
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
                fecha_modificacion = :fecha_modificacion,
                eliminado = :eliminado
            WHERE dpi = :dpi
            ";

            $stmt = $postgres->prepare($sql);

            $stmt->execute($mysqlRow);
        }
    }
}

foreach ($postgresMap as $dpi => $postgresRow) {

    if (!isset($mysqlMap[$dpi])) {

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
            :fecha_modificacion,
            :eliminado
        )
        ";

        $stmt = $mysql->prepare($sql);

        $stmt->execute($postgresRow);
    } else {

        $mysqlRow = $mysqlMap[$dpi];

        if (
            strtotime($postgresRow["fecha_modificacion"]) >
            strtotime($mysqlRow["fecha_modificacion"])
        ) {

            $sql = "
            UPDATE Empleado
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
                fecha_modificacion = :fecha_modificacion,
                eliminado = :eliminado
            WHERE dpi = :dpi
            ";

            $stmt = $mysql->prepare($sql);

            $stmt->execute($postgresRow);
        }
    }
}

echo json_encode([
    "success" => true,
    "message" => "Sincronización completada"
]);
