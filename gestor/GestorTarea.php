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
            
        function agregarTarea($proyecto) {
            $id_tarea = count($proyecto->getTareas()) + 1; 
            $id_proyecto = $proyecto->getIdProyecto();
            
            echo "Ingrese el nombre de la tarea: ";
            $nombre = trim(fgets(STDIN));
            
            echo "Ingrese la descripción de la tarea: ";
            $descripcion = trim(fgets(STDIN));
        
            // Elegir si la tarea será dependiente o independiente
            echo "¿La tarea es dependiente o independiente? (1: Dependiente, 2: Independiente): ";
            $tipo_tarea = trim(fgets(STDIN));
            
            // Obtener fechas de inicio y fin del proyecto
            $fecha_inicio_proyecto = $proyecto->getFechaInicio();
            $fecha_fin_proyecto = $proyecto->getFechaFin();
            
            // Para tareas dependientes, establecer fecha de inicio según la última tarea dependiente
            if ($tipo_tarea == 1) {
                // Verificar cuántas tareas dependientes ya existen
                $tareas_dependientes = $proyecto->getTareasDependientes();
                if (count($tareas_dependientes) > 0) {
                    // No es la primera tarea dependiente, usar la fecha de fin de la tarea anterior
                    $ultima_tarea_dependiente = end($tareas_dependientes);
                    $fecha_inicio = $ultima_tarea_dependiente->getFechaFin();
                    echo "La fecha de inicio de la tarea dependiente será la fecha de finalización de la tarea anterior: $fecha_inicio\n";
                } else {
                    // Es la primera tarea dependiente, pedir fecha de inicio al usuario
                    do {
                        echo "Ingrese la fecha de inicio en formato fecha (YYYY-MM-DD): ";
                        $fecha_inicio = trim(fgets(STDIN));
                        
                        if (!$this->esFechaValida($fecha_inicio)) {
                            echo "La fecha de inicio no es válida. Intenta nuevamente.\n";
                            continue;
                        }
            
                        $fechaInicioObj = DateTime::createFromFormat('Y-m-d', $fecha_inicio);
                        $fechaInicioProyectoObj = DateTime::createFromFormat('Y-m-d', $fecha_inicio_proyecto);
            
                        if ($fechaInicioObj < $fechaInicioProyectoObj) {
                            echo "La fecha de inicio no puede ser antes de la fecha de inicio del proyecto.\n";
                            continue;
                        }
            
                        break;
                    } while (true);
                }
            }
        
            // Para tareas independientes, se valida la fecha de inicio
            if ($tipo_tarea == 2) {
                // En el caso de las tareas independientes, la fecha de inicio debe ser validada también
                do {
                    echo "Ingrese la fecha de inicio en formato fecha (YYYY-MM-DD): ";
                    $fecha_inicio = trim(fgets(STDIN));
        
                    if (!$this->esFechaValida($fecha_inicio)) {
                        echo "La fecha de inicio no es válida. Intenta nuevamente.\n";
                        continue;
                    }
        
                    $fechaInicioObj = DateTime::createFromFormat('Y-m-d', $fecha_inicio);
                    $fechaInicioProyectoObj = DateTime::createFromFormat('Y-m-d', $fecha_inicio_proyecto);
        
                    if ($fechaInicioObj < $fechaInicioProyectoObj) {
                        echo "La fecha de inicio no puede ser antes de la fecha de inicio del proyecto.\n";
                        continue;
                    }
        
                    break;
                } while (true);
            }
        
            // Solicitar la cantidad de días de duración de la tarea
            do {
                echo "Ingrese la cantidad de días de duración de la tarea: ";
                $dias_duracion = trim(fgets(STDIN));
                
                if (!is_numeric($dias_duracion) || $dias_duracion <= 0) {
                    echo "Por favor, ingresa un número válido de días.\n";
                    continue;
                }
        
                break;
            } while (true);
        
            // Calcular la fecha de fin sumando los días de duración a la fecha de inicio
            $fechaInicioObj = DateTime::createFromFormat('Y-m-d', $fecha_inicio);
            $fechaFinObj = clone $fechaInicioObj;
            $fechaFinObj->add(new DateInterval('P' . $dias_duracion . 'D'));
            $fecha_fin = $fechaFinObj->format('Y-m-d');
        
            // Verificar que la fecha de fin no esté fuera del rango del proyecto
            $fechaFinProyectoObj = DateTime::createFromFormat('Y-m-d', $fecha_fin_proyecto);
            if ($fechaFinObj > $fechaFinProyectoObj) {
                echo "La fecha de finalización calculada está fuera del rango del proyecto.\n";
                return; // Finalizar sin agregar la tarea si la fecha de fin es inválida
            }
        
            // Validación de la fecha de fin no puede ser anterior a la de inicio
            if ($fechaFinObj < $fechaInicioObj) {
                echo "La fecha de finalización no puede ser anterior a la fecha de inicio.\n";
                return; // Finalizar sin agregar la tarea si la fecha de fin es inválida
            }
        
            // Crear la nueva tarea
            $nuevaTarea = new Tarea($id_tarea, $nombre, $descripcion, $fecha_inicio, $fecha_fin, $id_proyecto, $dias_duracion);
        
            // Añadir la tarea al arreglo adecuado del proyecto
            if ($tipo_tarea == 1) {
                $proyecto->agregarTareaDependiente($nuevaTarea);
                echo "Tarea dependiente agregada exitosamente: " . $nuevaTarea->getNombre() . " (ID: $id_tarea)\n";
            } elseif ($tipo_tarea == 2) {
                $proyecto->agregarTareaIndependiente($nuevaTarea);
                echo "Tarea independiente agregada exitosamente: " . $nuevaTarea->getNombre() . " (ID: $id_tarea)\n";
            } else {
                echo "Opción no válida. La tarea no se ha agregado.\n";
            }
        }
        
        public function validarFechaInicioFin($fecha_inicio, $fecha_fin) {
            // Crear objetos DateTime a partir de las fechas
            $fechaInicioObj = DateTime::createFromFormat('Y-m-d', $fecha_inicio);
            $fechaFinObj = DateTime::createFromFormat('Y-m-d', $fecha_fin);
            
            // Verificar si alguna de las fechas no es válida
            if (!$fechaInicioObj || !$fechaFinObj) {
                return "Una de las fechas no es válida.";
            }
            
            // Verificar si la fecha de finalización es anterior a la fecha de inicio
            if ($fechaFinObj < $fechaInicioObj) {
                return "La fecha de finalización no puede ser anterior a la de inicio.";
            }
            
            // Si todo está bien, retornar true
            return true;
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
                                            // Calcular los días de atraso
                                            $fecha_actual = new DateTime();
                                            $fecha_inicio_obj = new DateTime($fecha_inicio);
                                            $intervalo = $fecha_actual->diff($fecha_inicio_obj);
                                            $dias_atraso = $intervalo->days;
        
                                            // Si la fecha de inicio es en el futuro, no hay atraso
                                            if ($fecha_inicio_obj > $fecha_actual) {
                                                $dias_atraso = 0;
                                            }
        
                                            $tarea->setFechaInicio($fecha_inicio);
                                            echo "Tarea editada exitosamente: " . $tarea->getNombre() . "\n";
                                            
                                            // Actualizar la fecha final del proyecto
                                            $fecha_fin_actual = new DateTime($proyecto->getFechaFin());
                                            $fecha_fin_actual->modify("+$dias_atraso days");
                                            $proyecto->setFechaFin($fecha_fin_actual->format('Y-m-d'));
                                            echo "La fecha de finalización del proyecto ha sido extendida.\n";
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
