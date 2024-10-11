<?php

function generarIdNumerico() {
    // Generar un número aleatorio entre 10000 y 99999
    return rand(10000, 99999);
}

// Uso de la función
$id = generarIdNumerico();
echo "ID generado: " . $id;