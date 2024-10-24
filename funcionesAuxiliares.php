<?php
/*require_once 'usuario.php';
require_once 'proyecto.php';
require_once 'tarea.php';
require_once 'comentario.php';
require_once 'estado.php';
require_once 'GestorProyecto.php';
require_once 'funcionesAuxiliares.php';

function generarIdNumerico() {
    // Generar un número aleatorio entre 10000 y 99999
    return rand(10000, 99999); 
}*/

// Uso de la función
// $id = generarIdNumerico();
// echo "ID generado: " . $id;

// Para almacenar el nuevo proyecto en un archivo JSON, puedes seguir estos pasos dentro de tu función `crearProyecto()`. Primero, después de crear la instancia de `Proyecto`, necesitas convertirla a un formato que pueda ser guardado en JSON, y luego escribirlo en un archivo.

// Aquí tienes un ejemplo modificado de tu función:


// function crearProyecto() {
//     $id_proyecto = generarIdNumerico();

//     echo "Ingrese el nombre del proyecto: ";
//     $nombre = trim(fgets(STDIN));

//     echo "Ingrese la descripción del proyecto: ";
//     $descripcion = trim(fgets(STDIN));

//     echo "Ingrese la fecha de inicio (YYYY-MM-DD): ";
//     $fechaInicio = trim(fgets(STDIN));

//     echo "Ingrese la fecha de finalización (YYYY-MM-DD): ";
//     $fechaFin = trim(fgets(STDIN));

//     $nuevoProyecto = new Proyecto($id_proyecto, $nombre, $descripcion, $fechaInicio, $fechaFin);
//     $this->proyectos[] = $nuevoProyecto;

//     echo "Proyecto creado exitosamente: " . $nuevoProyecto->getNombre() . " " . $id_proyecto . "\n";

//     // Almacenar el proyecto en un archivo JSON
//     $this->guardarProyectoEnJson($nuevoProyecto);
// }

// private function guardarProyectoEnJson($proyecto) {
//     $proyectoArray = [
//         'id' => $proyecto->getId(), // Asegúrate de tener un método getId() en la clase Proyecto
//         'nombre' => $proyecto->getNombre(),
//         'descripcion' => $proyecto->getDescripcion(), // Asegúrate de tener este método
//         'fechaInicio' => $proyecto->getFechaInicio(), // Asegúrate de tener este método
//         'fechaFin' => $proyecto->getFechaFin() // Asegúrate de tener este método
//     ];

//     // Leer proyectos existentes del archivo, si lo hay
//     $archivo = 'proyectos.json';
//     if (file_exists($archivo)) {
//         $contenido = file_get_contents($archivo);
//         $proyectosExistentes = json_decode($contenido, true);
//     } else {
//         $proyectosExistentes = [];
//     }

//     // Agregar el nuevo proyecto a la lista existente
//     $proyectosExistentes[] = $proyectoArray;

//     // Guardar la lista de proyectos en el archivo
//     file_put_contents($archivo, json_encode($proyectosExistentes, JSON_PRETTY_PRINT));
// }


// // ### Explicación:
// // 1. **Crear un arreglo asociativo**: Se crea un arreglo con los detalles del proyecto.
// // 2. **Leer proyectos existentes**: Si el archivo `proyectos.json` ya existe, se lee su contenido y se decodifica como un arreglo.
// // 3. **Agregar el nuevo proyecto**: Se añade el nuevo proyecto al arreglo de proyectos existentes.
// // 4. **Guardar en el archivo**: Se convierte el arreglo completo a JSON y se guarda en el archivo.

// // Asegúrate de tener los métodos `getId()`, `getDescripcion()`, `getFechaInicio()`, y `getFechaFin()` en tu clase `Proyecto
//` para acceder a esos valores.


/*require_once 'GestorUsuario.php';
require_once 'Usuario.php';

// Asegúrate de que la clase `GestorUsuario` y `Usuario` estén definidas correctamente.

function generarIdNumerico() {
    return rand(1, 1000);
}

// Inicializa el gestor
$gestor = new GestorUsuario();

// Prueba la creación de usuario
echo "=== Prueba de Creación de Usuario ===\n";
$gestor->crearUsuario();
$gestor->listarUsuarios();

// Prueba la edición de usuario
echo "=== Prueba de Edición de Usuario ===\n";
$gestor->editarUsuario();
$gestor->listarUsuarios();

// Prueba la eliminación de usuario
echo "=== Prueba de Eliminación de Usuario ===\n";
$gestor->eliminarUsuario();
$gestor->listarUsuarios();

// Carga los usuarios desde JSON y verifica que se guardaron
echo "=== Prueba de Carga desde JSON ===\n";
$gestor->cargarDesdeJSON();
$gestor->listarUsuarios(); */


require_once 'GestorProyecto.php';
require_once 'Proyecto.php';

function generarIdNumerico() {
    return rand(1, 1000);
}

$gestor = new GestorProyecto();

// Prueba la creación de proyecto
echo "=== Prueba de Creación de Proyecto ===\n";
$gestor->crearProyecto();
$gestor->listarProyectos();

// Prueba la edición de proyecto
echo "=== Prueba de Edición de Proyecto ===\n";
$gestor->editarProyecto();
$gestor->listarProyectos();

// Prueba la eliminación de proyecto
echo "=== Prueba de Eliminación de Proyecto ===\n";
$gestor->eliminarProyecto();
$gestor->listarProyectos();

// Carga los proyectos desde JSON y verifica que se guardaron
echo "=== Prueba de Carga desde JSON ===\n";
$gestor->cargarDesdeJSON();
$gestor->listarProyectos();

?>



