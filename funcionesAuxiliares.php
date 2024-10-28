<?php

require_once 'GestorComentario.php';
require_once 'Comentario.php';

function generarIdNumerico() {
    return rand(1, 1000);
}


$gestor = new GestorComentario();
echo "=== Prueba de Creación de Comentario ===\n";
$id_comentario1 = generarIdNumerico();
$comentario1 = new Comentario($id_comentario1, 1, 1, "Este es un comentario de prueba", "2023-10-19");
$gestor->agregarComentario($comentario1);
print_r($gestor->obtenerComentario($id_comentario1));


echo "=== Prueba de Actualización de Comentario ===\n";
$gestor->editarComentario($id_comentario1, "Comentario actualizado", "2023-10-20");
print_r($gestor->obtenerComentario($id_comentario1));


echo "=== Prueba de Eliminación de Comentario ===\n";
$gestor->eliminarComentario($id_comentario1);
print_r($gestor->obtenerComentario($id_comentario1));

echo "=== Prueba de Carga desde JSON ===\n";
$gestor->cargarDesdeJSON();
print_r($gestor->comentarios);

?>

