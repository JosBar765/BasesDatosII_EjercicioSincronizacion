<?php

require_once("../config/credenciales.php");

function mysqlConnection()
{

    $HOST = MySQL_HOST;
    $DBNAME = MySQL_DBNAME;
    $USER = MySQL_USER;
    $PASSWORD = MySQL_PASSWORD;

    $pdo = new PDO(
        "mysql:host=$HOST;dbname=$DBNAME",
        $USER,
        $PASSWORD
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    return $pdo;
}



function postgresConnection()
{

    $HOST = Postgres_HOST;
    $PORT = Postgres_PORT;
    $DBNAME = Postgres_DBNAME;
    $USER = Postgres_USER;
    $PASSWORD = Postgres_PASSWORD;

    $pdo = new PDO(
        "pgsql:host=$HOST;port=$PORT;dbname=$DBNAME",
        $USER,
        $PASSWORD
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    return $pdo;
}
