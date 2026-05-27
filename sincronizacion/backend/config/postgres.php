<?php

$HOST = "localhost";
$PORT = "5432";
$DBNAME = "DB_2";
$USER = "postgres";
$PASSWORD = "postgre";

function postgresConnection()
{
    global $HOST, $PORT, $DBNAME, $USER, $PASSWORD;

    return new PDO(
        "pgsql:host=$HOST;port=$PORT;dbname=$DBNAME",
        $USER,
        $PASSWORD
    );
}
