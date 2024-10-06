<?php
require_once 'usuario.php';
require_once 'proyecto.php';
require_once 'tarea.php';
require_once 'comentario.php';
require_once 'estado.php';
require_once 'GestorProyecto.php';
require_once 'tarea.json';
require_once 'GestorTarea.php';

$gestor = new GestorDeProyecto();

// usuarios
$usuario1 = new Usuario(1, 'Juan Perez', 'juan@gmail.com');
$usuario2 = new Usuario(2, 'Maria Lopez', 'maria@hahoo.com');
$gestor->agregarUsuario($usuario1);
$gestor->agregarUsuario($usuario2);

// proyectos
$proyecto1 = new Proyecto(1, 'Proyecto A', 'Descripción del Proyecto A');
$proyecto2= new Proyecto(2,'Proyecto B','Descripción del proyecto B');
$gestor->agregarProyecto($proyecto1);
$gestor->agregarProyecto($proyecto2);

// estados
$estado1 = new Estado(1, 'Pendiente');
$estado2 = new Estado(2, 'En Progreso');
$estado3 = new Estado(3, 'Completado');
$gestor->agregarEstado($estado1);
$gestor->agregarEstado($estado2);
$gestor->agregarEstado($estado3);

// agregamos tareas
/*$tarea1 = new Tarea(1, 'Tarea 1', 'Descripción de la Tarea 1', '2024-09-01', '2024-09-10', 1, 1, 1);
$tarea2 = new Tarea(2, 'Tarea 2', 'Descripción de la Tarea 2', '2024-09-05', '2024-09-15', 1, 2, 2);
$gestor->agregarTarea($tarea1);
$gestor->agregarTarea($tarea2);*/

// agregamos comentarios
$comentario1 = new Comentario(1, 1, 1, 'Este es un comentario sobre la Tarea 1', '2024-09-01');
$gestor->agregarComentario($comentario1);

//Usuarios
echo "Usuarios:\n";
foreach ($gestor->usuarios as $usuario) {
   echo "ID: " . $usuario->getId_usuario() . ", Nombre: " . $usuario->getNombre() . ", Email: " . $usuario->getEmail() . "\n";
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
echo "------------------------- .\n";

//Muestro usuario antes de eliminar y actualizar
echo "Usuarios antes de eliminar "."\n";
foreach ($gestor->usuarios as $usuario) {
    echo "ID: " . $usuario->getId_usuario() . ", Nombre: " . $usuario->getNombre() . ", Email: " . $usuario->getEmail() . "\n";
}
echo "---------------------.\n";

//Elimino Usuario con ID=1
$gestor ->eliminarUsuario(1);
"/n";
echo "Elimino usuario 1"."\n";
//Actualizo Usuario con ID=2
$gestor -> actualizarUsuario(2, "Maria Gonzales", "Mariagonzalez@gmail.com");

//vuelvo a mostrar la lista para control.
echo"lista actualizada"."\n";
foreach ($gestor->usuarios as $usuario) {
    echo "ID: " . $usuario->getId_usuario() . ", Nombre: " . $usuario->getNombre() . ", Email: " . $usuario->getEmail() . "\n";
}
echo "-------------------"."\n";

//muestro proyectos antes de eliminar y actualizar.
echo"Lista de Proyectos antes de eliminar"."\n";
foreach ($gestor->proyectos as $proyecto) {
    echo "ID: " . $proyecto->getIdProyecto() . ", Nombre: " . $proyecto->getNombre() . ", Descripción: " . $proyecto->getDescripcion() . "\n";
}
echo "---------------------"."\n";

//Elimino Proyecto co ID=1

$gestor->eliminarProyecto(1);
echo"elimine Proyecto A"."\n";

//Actualizo Proyecto con ID=2

$gestor->actualizarProyecto(2, 'Nuevo Proyecto 2', 'Nueva descripcion del proyecto 2');


//vuelvo a mostrar la lista para control.
echo"Lista actualizada"."\n";
foreach ($gestor->proyectos as $proyecto) {
    echo "ID: " . $proyecto->getIdProyecto() . ", Nombre: " . $proyecto->getNombre() . ", Descripción: " . $proyecto->getDescripcion() . "\n";
}
echo "---------------------"."\n";


//PRUEBAS CON JSON

$gestorTarea = new GestorTarea();

// Agrego una tarea
$tarea = new Tarea(1, 'Tarea de prueba', 'Descripción de prueba', '2024-10-06', '2024-10-07', 1, 1, 1);
$gestorTarea->agregarTarea($tarea);
echo "Tarea agregada y guardada en JSON./n";

// Obtengo una tarea
$tareaObtenida = $gestorTarea->obtenerTarea(1);
if ($tareaObtenida) {
    echo "Tarea obtenida: " . $tareaObtenida->getNombre() . "/n";
} else {
    echo "Tarea no encontrada./n";
}

// Actualizo una tarea
$gestorTarea->actualizarTarea(1, 'Tarea actualizada', 'Descripción actualizada', '2024-10-08', '2024-10-09', 2, 2, 2);
echo "Tarea actualizada y guardada en JSON./n";

// Elimino una tarea
$gestorTarea->eliminarTarea(1);
echo "Tarea eliminada y JSON actualizado./n";

// Verifico JSON
$contenidoJson = file_get_contents('tareas.json');
echo "Contenido del archivo JSON:/n";
echo "<pre>" . $contenidoJson . "</pre>";
?>


?>








