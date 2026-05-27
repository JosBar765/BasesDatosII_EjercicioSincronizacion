<?php

$HOST = "localhost";
$DBNAME = "DB_1";
$USER = "localhost";
$PASSWORD = "";

function mysqlConnection()
{
    global $HOST, $DBNAME, $USER, $PASSWORD;

    return new PDO(
        "mysql:host=$HOST;dbname=$DBNAME",
        $USER,
        $PASSWORD
    );
}
