<?php
require_once('proyecto.php');
require_once('usuario.php');
require_once('estado.php');

$tareas = [];
$tarea1 = new tarea (1,"Tarea 1", "Descripción", "2024-07-31","2024-08-30", 1, 1, 1 );$tarea:: agregar_tarea($tareas, $tarea1);

$tarea2 = new tarea (2,"Tarea 2", "Descripción", "2024-07-31","2024-08-30", 2, 2, 2 );
tarea:: agregar_tarea($tareas, $tarea2);

$tarea_editada = new tarea(1,"Edito tarea 1", " edito descripcion", "2024-07-31","2024-08-30",1,1,1);

tarea:: editar_tarea($tareas, 1, $tarea_editada);
tarea:: eliminar_tarea($tareas, 2);


//proyecto
$proyectos = [];
$proyecto1 = new proyecto(1,"Proyecto1", "Descripción", "2024-07-31","2024-08-30");

$proyecto_editado = new proyecto (1,"Edito proyecto 1", " edito descripcion", "2024-07-31","2024-08-30");
// proyecto:: agregar_proyecto($proyectos, $proyecto1)
// proyecto:: editar_proyecto($proyectos, 1, $proyecto_editado);
// proyecto:: eliminar_proyecto($proyecto, 1);









