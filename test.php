<?php

require_once 'GestorProyecto.php';
require_once 'Proyecto.php';

function generarIdNumerico() {
    return rand(1, 1000);
}


$gestor = new GestorProyecto();

echo "=== Prueba de Creación de Proyecto ===\n";
$id_proyecto1 = generarIdNumerico();
$proyecto1 = new Proyecto($id_proyecto1, "Proyecto 1", "Descripción del Proyecto 1", "2023-01-01", "2023-12-31");
$gestor->agregarProyecto($proyecto1);
$gestor->listarProyectos();


echo "=== Prueba de Edición de Proyecto ===\n";
$gestor->editarProyecto($id_proyecto1, "Proyecto 1 Actualizado", "Descripción Actualizada", "2023-02-01", "2023-11-30");
$gestor->listarProyectos();

echo "=== Prueba de Eliminación de Proyecto ===\n";
$gestor->eliminarProyecto($id_proyecto1);
$gestor->listarProyectos();

echo "=== Prueba de Carga desde JSON ===\n";
$gestor->cargarDesdeJSON();
$gestor->listarProyectos();

?>
