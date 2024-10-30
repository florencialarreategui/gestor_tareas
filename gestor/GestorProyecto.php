<?php
require_once './clases/proyecto.php';
require_once './clases/tarea.php';
require_once './clases/estado.php';
require_once './gestor/GestorTarea.php';

class GestorProyecto {
    public $proyectos = [];
    private $archivoJson = './Json/proyecto.json';
    private $gestorTarea; 

    public function __construct(GestorTarea $gestorTarea) {
        $this->cargarDesdeJSON();
        $this->gestorTarea = $gestorTarea; 
    }

    
    public function agregarProyecto() {
        $id_proyecto = count($this->proyectos) + 1; 
        $estado= "Activo";
        echo "Ingrese el nombre del proyecto: ";
        $nombre = trim(fgets(STDIN));
        echo "Ingrese la descripción del proyecto: ";
        $descripcion = trim(fgets(STDIN));
        echo "Ingrese la fecha de inicio (YYYY-MM-DD): ";
        $fechaInicio = trim(fgets(STDIN));
        echo "Ingrese la fecha de finalización (YYYY-MM-DD): ";
        $fechaFin = trim(fgets(STDIN));
        echo "Ingrese Estado: ";
        $estado= "Activo";
        $nuevoProyecto = new Proyecto($id_proyecto, $nombre, $descripcion, $fechaInicio, $fechaFin, $estado);
        $this->proyectos[] = $nuevoProyecto;
        echo "Proyecto creado exitosamente: " . $nuevoProyecto->getNombre() . " " . $id_proyecto . "\n";

        
    while (true) {
        echo "¿Desea agregar una tarea al proyecto? (s/n): ";
        $respuesta = trim(fgets(STDIN));
        if (strtolower($respuesta) !== 's') {
            break; 
        }
        $this->gestorTarea->agregarTarea($nuevoProyecto);
    }

        $this->guardarEnJSON();
 }

    public function listarProyectos() {
        if (empty($this->proyectos)) {
            echo "No hay proyectos registrados.\n";
            return;
        }
        echo "=== Proyectos Registrados ===\n";
        foreach ($this->proyectos as $proyecto) {
            echo "Id: " . $proyecto->getIdProyecto() . "  Nombre: " . $proyecto->getNombre() . ", Fecha de Inicio: " . $proyecto->getFechaInicio() . ", Fecha de Finalización: " . $proyecto->getFechaFin(). "\n";
        }
    }


    public function editarProyecto() {
        echo "Ingrese el ID del proyecto que desea editar: ";
        $id_proyecto = trim(fgets(STDIN));
        
        $proyectoEncontrado = false;

        foreach ($this->proyectos as $proyecto) {
            if ($proyecto->getIdProyecto() == $id_proyecto) {
                $proyectoEncontrado = true; 
                echo "=== Elija que campo desea editar ===\n";
                while (true) {
                    echo "1. Nombre\n";
                    echo "2. Descripción\n";
                    echo "3. Fecha de inicio (YYYY-MM-DD): \n";
                    echo "4. Fecha de finalización (YYYY-MM-DD): \n";
                    echo "5. Cambiar estado: \n";
                    echo "6. Agregar Tarea: \n";
                    echo "7. Editar Tarea: \n";
                    echo "8. Eliminar Tarea: \n";
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
                                echo "Ingrese Activo o Terminado según corresponda: ";
                                $estado = trim(fgets(STDIN));
                                $proyecto->setEstado($estado);
                                echo "Proyecto editado exitosamente: " . $proyecto->getNombre() . "\n";
                                break;
                        case '6':
                                $this->gestorTarea->agregarTarea($proyecto);
                                break;
                        case '7':
                                    $this->gestorTarea->editarTarea($proyecto) ;
                                break;
                        case '8':
                                    $this->gestorTarea->eliminarTarea($proyecto) ;
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
    
        if (!$proyectoEncontrado) {
            echo "Proyecto no encontrado.\n";
        }
    }

    
    public function eliminarProyecto() {
        echo "Ingrese el ID del proyecto que desea eliminar: ";
        $id_proyecto = trim(fgets(STDIN));
       
        $indiceProyecto = null;
        foreach ($this->proyectos as $indice => $p) {
            if ($p->getIdProyecto() == $id_proyecto) {
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
    
    public function listarProyectoPorId() {
        echo "Ingrese el ID del proyecto que desea ver: ";
        $id_proyecto = trim(fgets(STDIN));
        
        foreach ($this->proyectos as $proyecto) {
            if ($proyecto->getIdProyecto() == $id_proyecto) {
                echo "=== Proyecto Encontrado ===\n";
                echo "Id: " . $proyecto->getIdProyecto() . "\n";
                echo "Nombre: " . $proyecto->getNombre() . "\n";
                echo "Descripción: " . $proyecto->getDescripcion() . "\n";
                echo "Fecha de Inicio: " . $proyecto->getFechaInicio() . "\n";
                echo "Fecha de Finalización: " . $proyecto->getFechaFin() . "\n";
                echo "Estado: " . $proyecto->getEstado() . "\n";
    
                $tareas = $proyecto->getTareas();
                if (!empty($tareas)) {
                    echo "Tareas:\n";
                    foreach ($tareas as $tarea) {
                        echo " - Id: " . $tarea->getIdTarea() . "\n";
                        echo "   Nombre: " . $tarea->getNombre() . "\n";
                        echo "   Descripción: " . $tarea->getDescripcion() . "\n";
                        echo "   Fecha de Inicio: " . $tarea->getFechaInicio() . "\n";
                        echo "   Fecha de Finalización: " . $tarea->getFechaFin() . "\n";
                    }
                } else {
                    echo "No hay tareas asociadas a este proyecto.\n";
                }
                return; 
            }
        }
    
        echo "Proyecto no encontrado.\n";
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
    
                    if (isset($proyectoData['tareas']) && is_array($proyectoData['tareas'])) {
                        foreach ($proyectoData['tareas'] as $tareaData) {
                            $tarea = new Tarea(
                                $tareaData['id_tarea'],
                                $tareaData['nombre'],
                                $tareaData['descripcion'],
                                $tareaData['fecha_inicio'],
                                $tareaData['fecha_fin'],
                                $tareaData['id_proyecto']
                            );
                            $proyecto->agregarTarea($tarea);
                        }
                    }
    
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
