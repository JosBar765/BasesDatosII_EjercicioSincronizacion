<?php

//
// CREDENCIALES DE CONEXIÓN PARA MySQL
//
$HOST = "localhost";
$DBNAME = "DB_2";
$USER = "root";
$PASSWORD = "";

define("MySQL_HOST", $HOST);
define("MySQL_DBNAME", $DBNAME);
define("MySQL_USER", $USER);
define("MySQL_PASSWORD", $PASSWORD);

//
// CREDENCIALES DE CONEXIÓN PARA PostgreSQL
//
$HOST = "localhost";
$PORT = "5432";
$DBNAME = "DB_1";
$USER = "postgres";
$PASSWORD = "postgre";

define("Postgres_HOST", $HOST);
define("Postgres_PORT", $PORT);
define("Postgres_DBNAME", $DBNAME);
define("Postgres_USER", $USER);
define("Postgres_PASSWORD", $PASSWORD);
