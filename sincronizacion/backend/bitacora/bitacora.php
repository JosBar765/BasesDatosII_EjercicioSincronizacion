<?php

function escribirBitacora($mensaje)
{

    $archivo = fopen("../../bitacora.txt", "a");

    fwrite($archivo, $mensaje . PHP_EOL);

    fclose($archivo);
}
