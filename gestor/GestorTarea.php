<?php
require_once './clases/tarea.php';
require_once './clases/proyecto.php';

class GestorTarea {
        public $tareas = [];
        private $archivoJson = './Json/tareas.json';
        private $archivoJsonProyectos = './Json/proyecto.json';
        private $proyectos = [];

        public function __construct() {
            $this->cargarDesdeJSON();
            $this->proyectos = [];
        }

        public function esFechaValida($fecha, $formato = 'Y-m-d') {
            $d = DateTime::createFromFormat($formato, $fecha);
            return $d && $d->format($formato) === $fecha;
        }


       public function agregarTarea($proyecto) {
    $id_tarea = count($proyecto->getTareas()) + 1; 
    $id_proyecto = $proyecto->getIdProyecto();
    echo "Ingrese el nombre de la tarea: ";
    $nombre = trim(fgets(STDIN));
    
    echo "Ingrese la descripción de la tarea: ";
    $descripcion = trim(fgets(STDIN));
    
    // Obtener fechas de inicio y fin del proyecto
    $fecha_inicio_proyecto = $proyecto->getFechaInicio(); // Debe estar implementado en el objeto proyecto
    $fecha_fin_proyecto = $proyecto->getFechaFin(); // Debe estar implementado en el objeto proyecto

    // Validación de fecha de inicio
    do {
        echo "Ingrese la fecha de inicio en formato fecha(YYYY-MM-DD): ";
        $fecha_inicio = trim(fgets(STDIN));
        
        if (!$this->esFechaValida($fecha_inicio)) {
            echo "La fecha de inicio no es válida. Intenta nuevamente.\n";
            continue;
        }

        // Verificar que la fecha de inicio esté dentro del rango del proyecto
        $fechaInicioObj = DateTime::createFromFormat('Y-m-d', $fecha_inicio);
        $fechaInicioProyectoObj = DateTime::createFromFormat('Y-m-d', $fecha_inicio_proyecto);

        if ($fechaInicioObj < $fechaInicioProyectoObj) {
            echo "La fecha de inicio no puede ser antes de la fecha de inicio del proyecto.\n";
            continue;
        }

        break; // La fecha de inicio es válida
    } while (true);

    // Validación de fecha de finalización
    do {
        echo "Ingrese la fecha de finalización (YYYY-MM-DD): ";
        $fecha_fin = trim(fgets(STDIN));
        $validacion = $this->validarFechaInicioFin($fecha_inicio, $fecha_fin);

        if (!$this->esFechaValida($fecha_fin)) {
            echo "La fecha de finalización no es válida. Intenta nuevamente.\n";
            continue;
        }

        // Verificar que la fecha de fin esté dentro del rango del proyecto
        $fechaFinObj = DateTime::createFromFormat('Y-m-d', $fecha_fin);
        $fechaFinProyectoObj = DateTime::createFromFormat('Y-m-d', $fecha_fin_proyecto);

        if ($fechaFinObj > $fechaFinProyectoObj) {
            echo "La fecha de finalización no puede ser después de la fecha de finalización del proyecto.\n";
            continue;
        }

        break; // La fecha de finalización es válida
    } while (true);

    // Preguntar si la tarea depende de otra
    $tareaCorrelativa = null;
    echo "¿La tarea depende de otra tarea? (sí/no): ";
    $respuesta = trim(fgets(STDIN));
    if (strtolower($respuesta) === 'sí' || strtolower($respuesta) === 'si') {
        echo "Ingrese el ID de la tarea de la cual depende: ";
        $id_tarea_correlativa = trim(fgets(STDIN));

        // Buscar si existe la tarea correlativa
        foreach ($proyecto->getTareas() as $tarea) {
            if ($tarea->getIdTarea() == $id_tarea_correlativa) {
                $tareaCorrelativa = $tarea;
                break;
            }
        }

        if (!$tareaCorrelativa) {
            echo "No se encontró la tarea correlativa con ID $id_tarea_correlativa.\n";
        }
    }

    // Crear la nueva tarea con su tarea correlativa (si existe)
    $nuevaTarea = new Tarea($id_tarea, $nombre, $descripcion, $fecha_inicio, $fecha_fin, $id_proyecto, $tareaCorrelativa);
    $proyecto->agregarTarea($nuevaTarea); 
    echo "Tarea agregada exitosamente: " . $nuevaTarea->getNombre() . " (ID: $id_tarea)\n";

      // Si la fecha de finalización de la tarea es posterior a la fecha de finalización del proyecto, calculamos el atraso
      $fechaFinTareaObj = DateTime::createFromFormat('Y-m-d', $fecha_fin);
      $fechaFinProyectoObj = DateTime::createFromFormat('Y-m-d', $fecha_fin_proyecto);
  
      // Si la fecha de finalización de la tarea es posterior a la fecha de finalización del proyecto
      if ($fechaFinTareaObj > $fechaFinProyectoObj) {
          $diasDeAtraso = $fechaFinTareaObj->diff($fechaFinProyectoObj)->days;
          echo "La tarea está atrasada en $diasDeAtraso días.\n";
          
          // Actualizar la fecha de finalización del proyecto
          $fechaNuevaFinProyecto = $fechaFinProyectoObj->add(new DateInterval("P{$diasDeAtraso}D"));
          $proyecto->setFechaFin($fechaNuevaFinProyecto->format('Y-m-d')); // Asumiendo que existe el método setFechaFin() en la clase Proyecto
          echo "La nueva fecha de finalización del proyecto es: " . $fechaNuevaFinProyecto->format('Y-m-d') . "\n";
      }

}


        private function validarFechaInicioFin($fecha_inicio, $fecha_fin) {
            $fechaInicioObj = DateTime::createFromFormat('Y-m-d', $fecha_inicio);
            $fechaFinObj = DateTime::createFromFormat('Y-m-d', $fecha_fin);
            if (!$fechaInicioObj || !$fechaFinObj) {
                return "Una de las fechas no es válida.";
            }
            if ($fechaFinObj < $fechaInicioObj) {
                return "La fecha de finalización no puede ser anterior a la de inicio.";
            }
            return true; // Las fechas son válidas
        }
        public function obtenerTarea($id_tarea) {
            foreach ($this->tareas as $tarea) {
                if ($tarea->getIdTarea() == $id_tarea) {
                    return $tarea;
                }
            }
            return null;
        }

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

        public function editarTarea($proyecto) {
            $id_proyecto = $proyecto->getIdProyecto();
            echo "Ingrese el ID de la tarea que desea editar: ";
            $id_tarea = trim(fgets(STDIN));
            if ($proyecto->getIdProyecto() == $id_proyecto) {
                foreach ($proyecto->getTareas() as $tarea) {
                    if ($tarea->getIdTarea() == $id_tarea) {
                        echo "=== Elija que campo desea editar ===\n";
                    while (true) {
                        echo "1. Nombre\n";
                        echo "2. Descripción\n";
                        echo "3. Fecha de inicio (YYYY-MM-DD): \n";
                        echo "4. Fecha de finalización (YYYY-MM-DD): \n";
                        echo "5. Tarea correlativa: \n";
                        echo "0. Volver al menu de proyectos: \n";
                        $eleccion = trim(fgets(STDIN));
                        switch ($eleccion) {
                            case '1':
                                echo "Ingrese el nuevo nombre de la tarea: ";
                                $nombre = trim(fgets(STDIN));
                                $tarea->setNombre($nombre);
                                break;
                                echo "Tarea editada exitosamente: " . $tarea->getNombre() . "\n"; 
                            case '2':
                                echo "Ingrese la nueva descripción: ";
                                $descripcion = trim(fgets(STDIN));
                                $tarea->setDescripcion($descripcion);
                                break;
                                echo "Tarea editada exitosamente: " . $tarea->getNombre() . "\n"; 
                            case '3':
                                do {
                                    echo "Ingrese la fecha de inicio en formato fecha(YYYY-MM-DD): ";
                                    $fecha_inicio = trim(fgets(STDIN));
                                    if ($this->esFechaValida($fecha_inicio)) {
                                        $tarea->setFechaInicio($fecha_inicio);
                                        echo "Tarea editada exitosamente: " . $tarea->getNombre() . "\n";
                                        break;  
                                    } else {
                                        echo "La fecha de inicio no es válida. Intenta nuevamente.\n";
                                    }
                                } while (true); 
                                break;
                            case '4':   
                                do {
                                    echo "Ingrese la fecha de finalización (YYYY-MM-DD): ";
                                    $fecha_fin = trim(fgets(STDIN));
                                    $validacion = $this->validarFechaInicioFin($fecha_inicio, $fecha_fin);
                                    if ($validacion === true) {
                                        $tarea->setFechaFin($fecha_fin);
                                         echo "Tarea editada exitosamente: " . $tarea->getNombre() . "\n"; 
                                        break;
                                    } else {
                                        echo $validacion . "\n";
                                    }
                                } while (true);
                                break;           
                            case '0':
                                return; 
                            default:
                                echo "Opción no válida. Inténtelo de nuevo.\n";
                                break;
                        }
                        $this->guardarEnJSON();
                    }
                        $this->guardarEnJSON();
                        return;
                    }
                }
                echo "Tarea no encontrada en el proyecto especificado.\n";
            } else {
                echo "Proyecto no encontrado.\n";
            }
        }
        
        public function eliminarTarea($proyecto) {
            $id_proyecto = $proyecto->getIdProyecto();
            echo "Ingrese el ID de la tarea que desea eliminar: ";
            $id_tarea = trim(fgets(STDIN));
            
            if ($proyecto->getIdProyecto() == $id_proyecto) {
                $tareas = $proyecto->getTareas();
                $indiceTarea = null;
        
                foreach ($tareas as $indice => $tarea) {
                    if ($tarea->getIdTarea() == $id_tarea) {
                        $indiceTarea = $indice;
                        unset($tareas[$indiceTarea]);
                        $proyecto->setTareas(array_values($tareas)); 
                        echo "Tarea eliminada exitosamente.\n";
                        $this->guardarEnJSON();
                        return;
                    }
                }
                echo "Tarea no encontrada en el proyecto especificado.\n";
            } else {
                echo "Proyecto no encontrado.\n";
            }
        }

        
        public function guardarEnJSON() {
            $tareas = [];

            foreach ($this->tareas as $tarea) {
                $tareas[] = $tarea->ToArray();
            }

            $jsontarea = json_encode(['tarea' => $tareas], JSON_PRETTY_PRINT);
            file_put_contents($this->archivoJson, $jsontarea);
        }


    


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
