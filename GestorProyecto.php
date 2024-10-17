<?php
require_once 'funcionesAuxiliares.php';
require_once 'proyecto.php';
require_once 'tarea.php';
require_once 'comentario.php';
require_once 'estado.php';

class GestorProyecto {
      public $proyectos = [];
       
        //-----------------------------crear proyectos----------------------------

        public function crearProyecto() {

            $id_proyecto = generarIdNumerico();
            
            echo "Ingrese el nombre del proyecto: ";
            $nombre = trim(fgets(STDIN));

            echo "Ingrese el descripción del proyecto: ";
            $descripcion = trim(fgets(STDIN));

            echo "Ingrese la fecha de inicio (YYYY-MM-DD): ";
            $fechaInicio = trim(fgets(STDIN));

            echo "Ingrese la fecha de finalización (YYYY-MM-DD): ";
            $fechaFin = trim(fgets(STDIN));

            $nuevoProyecto = new Proyecto($id_proyecto, $nombre, $descripcion, $fechaInicio, $fechaFin);
            $this->proyectos[] = $nuevoProyecto;

            echo "Proyecto creado exitosamente: " . $nuevoProyecto->getNombre() ." ". $id_proyecto . "\n";
        }
//-----------------------------listar proyectos----------------------------
        public function listarProyectos() {
            if (empty($this->proyectos)) {
                echo "No hay proyectos registrados.\n";
                return;
            }

            echo "=== Proyectos Registrados ===\n";
            foreach ($this->proyectos as $proyecto) {
                echo "Id: " . $proyecto->getIdProyecto() . "  Nombre: " . $proyecto->getNombre() . ", Fecha de Inicio: " . $proyecto->getFechaInicio() . ", Fecha de Finalización: " . $proyecto->getFechaFin() . "\n";
            }


        }


//-----------------------------editar proyectos ----------------------------
public function editarProyecto() {
    echo "Ingrese el ID del proyecto que desea editar: ";
    $id_proyecto = trim(fgets(STDIN));

    // Buscar el proyecto por ID

    foreach ($this->proyectos as $proyecto) {
        if ($proyecto->getIdProyecto() == $id_proyecto) {
           
            echo "Ingrese el nuevo nombre del proyecto: ";
                $nombre = trim(fgets(STDIN));
                $proyecto->setNombre($nombre);
    

            echo "Ingrese la nueva descripción del proyecto: ";
                $descripcion = trim(fgets(STDIN));
                 $proyecto->setDescripcion($descripcion);
            

             echo "Ingrese la nueva fecha de inicio (YYYY-MM-DD): ";
                 $fechaInicio = trim(fgets(STDIN));
                 $proyecto->setFechaInicio($fechaInicio);


              echo "Ingrese la nueva fecha de finalización (YYYY-MM-DD): ";
                 $fechaFin = trim(fgets(STDIN));
                 $proyecto->setFechaFin($fechaFin);
            break;
        }       
            else {
             echo "Proyecto no encontrado.\n";
                 };
        };
        echo "Proyecto editado exitosamente: " . $proyecto->getNombre() . "\n";
}

//-----------------------------eliminar proyectos----------------------------
public function eliminarProyecto() {
    echo "Ingrese el ID del proyecto que desea eliminar: ";
    $id_proyecto = trim(fgets(STDIN));

    // Buscar el índice del proyecto por ID
    $indiceProyecto = null;
    foreach ($this->proyectos as $indice => $p) {
        if ($p->getIdProyecto() === $id_proyecto) {
            $indiceProyecto = $indice;
            break;
        }
    }

    if ($indiceProyecto === null) {
        echo "Proyecto no encontrado.\n";
        return;
    }

    // Eliminar el proyecto del array
    unset($this->proyectos[$indiceProyecto]);
    $this->proyectos = array_values($this->proyectos); // Reindexar el array

    echo "Proyecto eliminado exitosamente.\n";
    }

}

$nuevoProyecto = new GestorProyecto ();
$nuevoProyecto->crearProyecto();
$nuevoProyecto->crearProyecto();
$nuevoProyecto->crearProyecto();
$nuevoProyecto->crearProyecto();
// $gestor->validarIngresoUsuario ("florencia", 1234);
$nuevoProyecto->listarProyectos();
$nuevoProyecto->editarProyecto();
$nuevoProyecto->listarProyectos();
$nuevoProyecto->eliminarProyecto();
$nuevoProyecto->listarProyectos();