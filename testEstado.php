<?php

require_once 'GestorEstado.php';
require_once 'estado.php';

// Inicializa el gestor
$gestor = new GestorEstado();

// Prueba la creación de estado
echo "=== Prueba de Creación de Estado ===\n";
$estado1 = new Estado(true, "Activo");
$gestor->agregarEstado($estado1);
print_r($gestor->obtenerEstado(true));

// Prueba la actualización de estado
echo "=== Prueba de Actualización de Estado ===\n";
$gestor->actualizarEstado(true, "Terminado");
print_r($gestor->obtenerEstado(true));

// Prueba la carga desde JSON
echo "=== Prueba de Carga desde JSON ===\n";
$gestor->cargarDesdeJSON();
print_r($gestor->estados);

?>

