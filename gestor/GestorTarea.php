<?php
require_once './clases/tarea.php';
require_once './clases/proyecto.php';

class GestorTarea {
    public $tareas = [];
    private $archivoJson = './Json/tareas.json';
    private $archivoJsonProyectos = './Json/proyecto.json';

    public function __construct() {
        $this->cargarDesdeJSON();
    }

    //----------------- Agregar tarea--------------------------------
    public function agregarTarea($proyecto) {
        $id_tarea = count($proyecto->getTareas()) + 1; 
        $id_proyecto = $proyecto->getIdProyecto();
        echo "Ingrese el nombre de la tarea: ";
        $nombre = trim(fgets(STDIN));
    
        echo "Ingrese la descripción de la tarea: ";
        $descripcion = trim(fgets(STDIN));
    
        echo "Ingrese la fecha de inicio de la tarea (YYYY-MM-DD): ";
        $fecha_inicio = trim(fgets(STDIN));
    
        echo "Ingrese la fecha de finalización de la tarea (YYYY-MM-DD): ";
        $fecha_fin = trim(fgets(STDIN));
    
        $nuevaTarea = new Tarea($id_tarea, $nombre, $descripcion, $fecha_inicio, $fecha_fin, $id_proyecto);
        $proyecto->agregarTarea($nuevaTarea); 
        echo "Tarea agregada exitosamente: " . $nuevaTarea->getNombre() . " " . $id_tarea . "\n";
    }

    //----------------- Obtener tarea--------------------------------
    public function obtenerTarea($id_tarea) {
        foreach ($this->tareas as $tarea) {
            if ($tarea->getIdTarea() == $id_tarea) {
                return $tarea;
            }
        }
        return null;
    }

    //------------- Listar Tareas--------------------------------------
    public function listarTareas() {
        if (empty($this->tareas)) {
            echo "No hay tareas registradas.\n";
            return;
        }

        echo "=== Tareas Registradas ===\n";
        foreach ($this->tareas as $tarea) {
            echo "Id: " . $tarea->getIdTarea() . "  Nombre: " . $tarea->getNombre() . " Descripción: ". $tarea->getDescripcion() . "Fecha de Inicio: " . $tarea->getFechaInicio() . ", Fecha de Finalización: " . $tarea->getFechaFin() . "\n";
        }
    }

    //----------------- Editar tarea--------------------------------
    public function editarTarea() {
        echo "Ingrese el ID de la tarea que desea editar: ";
        $id_tarea = trim(fgets(STDIN));
        foreach ($this->tareas as $tarea) {
            if ($tarea->getIdTarea() == $id_tarea) {
                echo "Ingrese el nuevo nombre de la tarea: ";
                $nombre = trim(fgets(STDIN));
                $tarea->setNombre($nombre);
                echo "Ingrese la nueva descripción de la tarea: ";
                $descripcion = trim(fgets(STDIN));
                $tarea->setDescripcion($descripcion);
                echo "Ingrese la nueva fecha de inicio (YYYY-MM-DD): ";
                $fechaInicio = trim(fgets(STDIN));
                $tarea->setFechaInicio($fechaInicio);
                echo "Ingrese la nueva fecha de finalización (YYYY-MM-DD): ";
                $fechaFin = trim(fgets(STDIN));
                $tarea->setFechaFin($fechaFin);
                echo "Tarea editada exitosamente: " . $tarea->getNombre() . "\n";

                $this->guardarEnJSON();
                return;
            }
        }
        echo "Tarea no encontrada.\n";
    }

    //----------------- Eliminar tarea--------------------------------
    public function eliminarTarea() {
        echo "Ingrese el ID de la tarea que desea eliminar: ";
        $id_tarea = trim(fgets(STDIN));

        $indiceTarea = null;

        foreach ($this->tareas as $indice => $tarea) {
            if ($tarea->getIdTarea() == $id_tarea) {
                $indiceTarea = $indice;
                break;
            }
        }
        if ($indiceTarea === null) {
            echo "Tarea no encontrada.\n";
            return;
        }

        unset($this->tareas[$indiceTarea]);
        $this->tareas = array_values($this->tareas);
        echo "Tarea eliminada exitosamente.\n";
        $this->guardarEnJSON();
    }

    //----------------- Guardar en JSON--------------------------------
    public function guardarEnJSON() {
        $tareas = [];

        foreach ($this->tareas as $tarea) {
            $tareas[] = $tarea->ToArray();
        }

        $jsontarea = json_encode(['tarea' => $tareas], JSON_PRETTY_PRINT);
        file_put_contents($this->archivoJson, $jsontarea);
    }

    //----------------- Cargar desde JSON --------------------------------
    public function cargarDesdeJSON() {
        if (file_exists($this->archivoJson)) {
            $jsontarea = file_get_contents($this->archivoJson);
            $tareas = json_decode($jsontarea, true)['tarea'];
            $this->tareas = [];

            foreach ($tareas as $tareaData) {
                $tarea = new Tarea(
                    $tareaData['id_tarea'],
                    $tareaData['nombre'],
                    $tareaData['descripcion'],
                    $tareaData['fecha_inicio'],
                    $tareaData['fecha_fin'],
                    $tareaData['id_proyecto']
                );
                $this->tareas[] = $tarea;
            }
        }
    }
}