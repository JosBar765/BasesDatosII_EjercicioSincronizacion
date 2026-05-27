<?php

function escribirBitacora($mensaje)
{

    $ruta = __DIR__ . "/../../bitacora/bitacora.txt";

    $archivo = fopen($ruta, "a");

    fwrite($archivo, $mensaje . PHP_EOL);

    fclose($archivo);
}
