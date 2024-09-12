<?php
require_once 'usuario.php';
require_once 'proyecto.php';
require_once 'tarea.php';
require_once 'comentario.php';
require_once 'estado.php';
require_once 'GestorDeProyecto.php';


$gestor = new GestorDeProyecto();

// usuarios
$usuario1 = new Usuario(1, 'Juan Perez', 'juan@gmail.com');
$usuario2 = new Usuario(2, 'Maria Lopez', 'maria@hahoo.com');
$gestor->agregarUsuario($usuario1);
$gestor->agregarUsuario($usuario2);

// proyectos
$proyecto1 = new Proyecto(1, 'Proyecto A', 'Descripción del Proyecto A');
$gestor->agregarProyecto($proyecto1);

// estados
$estado1 = new Estado(1, 'Pendiente');
$estado2 = new Estado(2, 'En Progreso');
$estado3 = new Estado(3, 'Completado');
$gestor->agregarEstado($estado1);
$gestor->agregarEstado($estado2);
$gestor->agregarEstado($estado3);

// agregamos tareas
$tarea1 = new Tarea(1, 'Tarea 1', 'Descripción de la Tarea 1', '2024-09-01', '2024-09-10', 1, 1, 1);
$tarea2 = new Tarea(2, 'Tarea 2', 'Descripción de la Tarea 2', '2024-09-05', '2024-09-15', 1, 2, 2);
$gestor->agregarTarea($tarea1);
$gestor->agregarTarea($tarea2);

// agregamos comentarios
$comentario1 = new Comentario(1, 1, 1, 'Este es un comentario sobre la Tarea 1', '2024-09-01');
$gestor->agregarComentario($comentario1);

//Usuarios
echo "Usuarios:\n";
foreach ($gestor->usuarios as $usuario) {
   echo "ID: " . $usuario->getIdUsuario() . ", Nombre: " . $usuario->getNombre() . ", Email: " . $usuario->getEmail() . "\n";
}
// Proyectos
echo "\nProyectos:\n";
foreach ($gestor->proyectos as $proyecto) {
    echo "ID: " . $proyecto->getIdProyecto() . ", Nombre: " . $proyecto->getNombre() . ", Descripción: " . $proyecto->getDescripcion() . "\n";
}

// TAREAS
echo "\nTareas:\n";
foreach ($gestor->tareas as $tarea) {
    echo "ID: " . $tarea->getIdTarea() . ", Nombre: " . $tarea->getNombre() . ", Descripción: " . $tarea->getDescripcion() . ", Fecha Inicio: " . $tarea->getFechaInicio() . ", Fecha Fin: " . $tarea->getFechaFin() . ", ID Proyecto: " . $tarea->getIdProyecto() . ", ID Usuario: " . $tarea->getIdUsuario() . ", ID Estado: " . $tarea->getIdEstado() . "\n";
}
// COMENTARIOS
echo "\nComentarios:\n";
foreach ($gestor->comentarios as $comentario) {
    echo "ID: " . $comentario->getIdComentario() . ", ID Tarea: " . $comentario->getIdTarea() . ", ID Usuario: " . $comentario->getIdUsuario() . ", Contenido: " . $comentario->getContenido() . ", Fecha: " . $comentario->getFecha() . "\n";
}
?>








