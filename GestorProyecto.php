<?php
require_once 'funcionesAuxiliares.php';
require_once 'proyecto.php';
require_once 'tarea.php';
require_once 'comentario.php';
require_once 'estado.php';

class GestorProyecto {
    public $proyectos = [];
    private $archivoJson = 'proyecto.json';

    public function __construct() {
        $this->cargarDesdeJSON();
    }

    
    public function agregarProyecto() {
        $id_proyecto = generarIdNumerico();
        $estado = "Activo";
        echo "Ingrese el nombre del proyecto: ";
        $nombre = trim(fgets(STDIN));
        echo "Ingrese la descripción del proyecto: ";
        $descripcion = trim(fgets(STDIN));
        echo "Ingrese la fecha de inicio (YYYY-MM-DD): ";
        $fechaInicio = trim(fgets(STDIN));
        echo "Ingrese la fecha de finalización (YYYY-MM-DD): ";
        $fechaFin = trim(fgets(STDIN));
        
        $nuevoProyecto = new Proyecto($id_proyecto, $nombre, $descripcion, $fechaInicio, $fechaFin,$estado);
        $this->proyectos[] = $nuevoProyecto;
        echo "Proyecto creado exitosamente: " . $nuevoProyecto->getNombre() . " " . $id_proyecto . " Estado: " . $estado ."\n";

        $this->guardarEnJSON();
    }

    public function listarProyectos() {
        if (empty($this->proyectos)) {
            echo "No hay proyectos registrados.\n";
            return;
        }
        echo "=== Proyectos Registrados ===\n";
        foreach ($this->proyectos as $proyecto) {
            echo "Id: " . $proyecto->getIdProyecto() . "  Nombre: " . $proyecto->getNombre() . ", Fecha de Inicio: " . $proyecto->getFechaInicio() . ", Fecha de Finalización: " . $proyecto->getFechaFin(). ", Estado: " . $proyecto->getEstado() . "\n";
        }
    }


    
    public function editarProyecto() {
        echo "Ingrese el ID del proyecto que desea editar: ";
        $id_proyecto = trim(fgets(STDIN));
        
        // Variable para indicar si se encontró el proyecto
        $proyectoEncontrado = false;
    
        // Busca el proyecto por ID
        foreach ($this->proyectos as $proyecto) {
            if ($proyecto->getIdProyecto() == $id_proyecto) {
                $proyectoEncontrado = true; // Se encontró el proyecto
                echo "=== Elija que campo desea editar ===\n";
                while (true) {
                    echo "1. Nombre\n";
                    echo "2. Descripción\n";
                    echo "3. Fecha de inicio (YYYY-MM-DD): \n";
                    echo "4. Fecha de finalización (YYYY-MM-DD): \n";
                    echo "5. Estado\n";
                    echo "0. Salir al Menú Principal\n";
    
                    $eleccion = trim(fgets(STDIN));
                    switch ($eleccion) {
                        case '1':
                            echo "Ingrese el nuevo nombre del proyecto: ";
                            $nombre = trim(fgets(STDIN));
                            $proyecto->setNombre($nombre);
                            echo "Proyecto editado exitosamente: " . $proyecto->getNombre() . "\n";
                            break;
                        case '2':
                            echo "Ingrese la nueva descripción del proyecto: ";
                            $descripcion = trim(fgets(STDIN));
                            $proyecto->setDescripcion($descripcion);
                            echo "Proyecto editado exitosamente: " . $proyecto->getNombre() . "\n";
                            break;
                        case '3':
                            echo "Ingrese la nueva fecha de inicio (YYYY-MM-DD): ";
                            $fechaInicio = trim(fgets(STDIN));
                            $proyecto->setFechaInicio($fechaInicio);
                            echo "Proyecto editado exitosamente: " . $proyecto->getNombre() . "\n";
                            break;
                        case '4':
                            echo "Ingrese la nueva fecha de finalización (YYYY-MM-DD): ";
                            $fechaFin = trim(fgets(STDIN));
                            $proyecto->setFechaFin($fechaFin);
                            echo "Proyecto editado exitosamente: " . $proyecto->getNombre() . "\n";
                            break;
                        case '5':
                            echo "Ingrese activo o terminado según corresponda: ";
                            $estado = trim(fgets(STDIN));
                            $proyecto->setEstado($estado);
                            echo "Proyecto editado exitosamente: " . $proyecto->getNombre() . "\n";
                            break;
                        case '0':
                            return; 
                        default:
                            echo "Opción no válida. Inténtelo de nuevo.\n";
                            break;
                    }
                    $this->guardarEnJSON();
                }
            }
        }
    
        // Si se sale del bucle y no se encontró el proyecto
        if (!$proyectoEncontrado) {
            echo "Proyecto no encontrado.\n";
        }
    }

    
    public function eliminarProyecto() {
        echo "Ingrese el ID del proyecto que desea eliminar: ";
        $id_proyecto = trim(fgets(STDIN));
        // Busca el índice del proyecto por ID
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
    
        unset($this->proyectos[$indiceProyecto]);
        $this->proyectos = array_values($this->proyectos); 
        echo "Proyecto eliminado exitosamente.\n";
        $this->guardarEnJSON();
    }


    public function guardarEnJSON() {
        $proyectos = [];
        foreach ($this->proyectos as $proyecto) {
            $proyectos[] = $proyecto->toArray();
        }
        $jsonproyecto = json_encode(['proyecto' => $proyectos], JSON_PRETTY_PRINT);
        file_put_contents($this->archivoJson, $jsonproyecto);
    }

    
   
    public function cargarDesdeJSON() {
        if (file_exists($this->archivoJson)) {
            $json = file_get_contents($this->archivoJson);
            $data = json_decode($json, true);
    
            if (isset($data['proyecto']) && is_array($data['proyecto'])) {
                $proyectos = $data['proyecto'];
                $this->proyectos = [];
                foreach ($proyectos as $proyectoData) {
                    $proyecto = new Proyecto(
                        $proyectoData['id_proyecto'],
                        $proyectoData['nombre'],
                        $proyectoData['descripcion'],
                        $proyectoData['fechaInicio'],
                        $proyectoData['fechaFin'],
                        $proyectoData['estado'],
                    );
                    $this->proyectos[] = $proyecto;
                }
            } else {
                $this->proyectos = [];
            }
        } else {
            $this->proyectos = [];
        }
    }
    
}
