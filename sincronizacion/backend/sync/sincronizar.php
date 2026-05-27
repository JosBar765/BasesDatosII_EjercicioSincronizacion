<?php

date_default_timezone_set("America/Guatemala");

header("Content-Type: application/json");

require_once("../conexion/database.php");

try {

    $mysql = mysqlConnection();
    $postgres = postgresConnection();

    $tablaMysql = "Empleado";
    $tablaPostgres = '"Empleado"';

    //
    // OBTENER DATOS
    //

    $mysqlData = $mysql
        ->query("SELECT * FROM $tablaMysql")
        ->fetchAll(PDO::FETCH_ASSOC);

    $postgresData = $postgres
        ->query("SELECT * FROM $tablaPostgres")
        ->fetchAll(PDO::FETCH_ASSOC);

    //
    // MAPAS
    //

    $mysqlMap = [];
    $postgresMap = [];

    foreach ($mysqlData as $row) {
        $mysqlMap[$row["dpi"]] = $row;
    }

    foreach ($postgresData as $row) {
        $postgresMap[$row["dpi"]] = $row;
    }

    //
    // MYSQL -> POSTGRES
    //

    foreach ($mysqlMap as $dpi => $mysqlRow) {

        //
        // INSERTAR EN POSTGRES
        //

        if (!isset($postgresMap[$dpi])) {

            $sql = "
            INSERT INTO $tablaPostgres (
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

            //
            // ACTUALIZAR SI MYSQL ES MÁS RECIENTE
            //

            $postgresRow = $postgresMap[$dpi];

            if (
                strtotime($mysqlRow["fecha_modificacion"]) >=
                strtotime($postgresRow["fecha_modificacion"])
            ) {

                $sql = "
                UPDATE $tablaPostgres
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

    //
    // POSTGRES -> MYSQL
    //

    foreach ($postgresMap as $dpi => $postgresRow) {

        //
        // INSERTAR EN MYSQL
        //

        if (!isset($mysqlMap[$dpi])) {

            $sql = "
            INSERT INTO $tablaMysql (
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

            //
            // ACTUALIZAR SI POSTGRES ES MÁS RECIENTE
            //

            $mysqlRow = $mysqlMap[$dpi];

            if (
                strtotime($postgresRow["fecha_modificacion"]) >=
                strtotime($mysqlRow["fecha_modificacion"])
            ) {

                $sql = "
                UPDATE $tablaMysql
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

    //
    // RECARGAR DATOS ACTUALIZADOS
    //

    $mysqlData = $mysql
        ->query("SELECT * FROM $tablaMysql")
        ->fetchAll(PDO::FETCH_ASSOC);

    $postgresData = $postgres
        ->query("SELECT * FROM $tablaPostgres")
        ->fetchAll(PDO::FETCH_ASSOC);

    $mysqlMap = [];
    $postgresMap = [];

    foreach ($mysqlData as $row) {
        $mysqlMap[$row["dpi"]] = $row;
    }

    foreach ($postgresData as $row) {
        $postgresMap[$row["dpi"]] = $row;
    }

    //
    // ELIMINAR FÍSICAMENTE
    // SI EN AMBAS DBS ESTÁ ELIMINADO
    //

    foreach ($mysqlMap as $dpi => $mysqlRow) {

        if (!isset($postgresMap[$dpi])) {
            continue;
        }

        $postgresRow = $postgresMap[$dpi];

        if (
            (bool)$mysqlRow["eliminado"] === true &&
            (bool)$postgresRow["eliminado"] === true
        ) {

            //
            // DELETE MYSQL
            //

            $sqlMysql = "
            DELETE FROM $tablaMysql
            WHERE dpi = :dpi
            ";

            $stmtMysql = $mysql->prepare($sqlMysql);

            $stmtMysql->execute([
                ":dpi" => $dpi
            ]);

            //
            // DELETE POSTGRES
            //

            $sqlPostgres = "
            DELETE FROM $tablaPostgres
            WHERE dpi = :dpi
            ";

            $stmtPostgres = $postgres->prepare($sqlPostgres);

            $stmtPostgres->execute([
                ":dpi" => $dpi
            ]);
        }
    }

    echo json_encode([
        "success" => true,
        "message" => "Sincronización completada"
    ]);
} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
