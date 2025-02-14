        <?php
        require_once './clases/tarea.php';
        class GestorTarea {
            private $tareas = [];
            private $archivoJsonTareas = './Json/tareas.json';
            private $gestorProyecto;  // Para acceder al gestor de proyectos
        
             public function __construct($gestorProyecto) {
                $this->gestorProyecto = $gestorProyecto;
                $this->cargarTareaDesdeJson($this->archivoJsonTareas);
             }

             public function setGestorProyecto($gestorProyecto) {
                $this->gestorProyecto = $gestorProyecto;
            }
        
       // Cargar tareas desde el archivo JSON
      
    public function cargarTareaDesdeJson() {
    if (file_exists($this->archivoJsonTareas)) {
        $contenidoJson = file_get_contents($this->archivoJsonTareas);
        $data = json_decode($contenidoJson, true);
        if (isset($data['tareas'])) {
            foreach ($data['tareas'] as $tareaData) {
                $this->tareas[] = Tarea::fromArray($tareaData); // Crear tarea a partir del array
            }
        }
    }
    return $this->tareas; // Asegúrate de devolver las tareas cargadas
}

    // Método para buscar tarea por ID
    public function buscarTareaPorId($id_tarea) {
        foreach ($this->tareas as $tarea) {
            if ($tarea->getIdTarea() == $id_tarea) {
                return $tarea;
            }
        }
        return null; // Si no se encuentra la tarea
    }


     // Método en la clase GestorTarea para obtener un nuevo ID único
     public function obtenerNuevoIdTarea() {
        // Cargar las tareas existentes desde el archivo JSON
        $tareasExistentes = $this->cargarTareaDesdeJson();  // Asegúrate de que este método devuelva las tareas
    
        // Buscar el ID más alto entre las tareas
        $maxId = 0;
        foreach ($tareasExistentes as $tareaData) {
            $idTarea = $tareaData->getIdTarea();  // Accede a la propiedad del objeto correctamente
            if ($idTarea > $maxId) {
                $maxId = $idTarea;
            }
        }
    
        return $maxId + 1; // El nuevo ID es el siguiente número disponible
     }

     public function guardarTareaEnJson($tarea) {
        $tareasData = [];
    
        // Cargar tareas actuales desde el archivo JSON
        if (file_exists($this->archivoJsonTareas)) {
            $contenidoJson = file_get_contents($this->archivoJsonTareas);
            $data = json_decode($contenidoJson, true);
            if (isset($data['tareas'])) {
                foreach ($data['tareas'] as $tareaData) {
                    // Si la tarea coincide con la que estamos actualizando, se actualiza
                    if ($tareaData['id_tarea'] == $tarea->getIdTarea()) {
                        $tareasData[] = $tarea->toArray();
                    } else {
                        $tareasData[] = $tareaData;
                    }
                }
            }
        }
    
        // Si la tarea no se encontraba previamente, añadirla
        $idsExistentes = array_column($tareasData, 'id_tarea');
        if (!in_array($tarea->getIdTarea(), $idsExistentes)) {
            $tareasData[] = $tarea->toArray();
        }
    
        // Guardar el array de tareas actualizado en tareas.json
        file_put_contents($this->archivoJsonTareas, json_encode(['tareas' => $tareasData], JSON_PRETTY_PRINT));
    }
    
    // public function crearTarea($gestorProyecto) {
    //     // Primero preguntar el ID del proyecto
    //     echo "Ingrese el ID del proyecto al que pertenece la tarea: ";
    //     $id_proyecto = trim(fgets(STDIN));
        
    //     // Preguntar si la tarea tiene dependencias
    //     echo "¿La tarea tiene dependencias? (sí/no): ";
    //     $respuesta = trim(fgets(STDIN));
        
    //     $dependencias = [];
    //     if (strtolower($respuesta) == "sí" || strtolower($respuesta) == "si") {
    //         echo "Ingrese los IDs de las tareas de las cuales depende (separados por comas): ";
    //         $dependencias = explode(",", trim(fgets(STDIN)));  // Convertimos a array y eliminamos espacios en blanco
    //         $dependencias = array_map('trim', $dependencias); // Asegurarse de que no haya espacios en blanco
    //     }
        
    //     // Ahora preguntar los datos de la tarea
    //     echo "Ingrese el nombre de la tarea: ";
    //     $nombre = trim(fgets(STDIN));
        
    //     echo "Ingrese la descripción de la tarea: ";
    //     $descripcion = trim(fgets(STDIN));
        
    //     // Validar la fecha de inicio
    //     do {
    //         echo "Ingrese la fecha de inicio de la tarea (formato: Y-m-d): ";
    //         $fechaInicioInput = trim(fgets(STDIN));
    //         $fechaInicio = new DateTime($fechaInicioInput);
            
    //         if ($fechaInicio->format('Y') < 2025) {
    //             echo "La fecha de inicio no puede ser inferior a 2025. Por favor, ingrese una fecha válida.\n";
    //         }
    //     } while ($fechaInicio->format('Y') < 2025);
        
    //     // Validar la fecha de fin
    //     do {
    //         echo "Ingrese la fecha de fin de la tarea (formato: Y-m-d): ";
    //         $fechaFinInput = trim(fgets(STDIN));
    //         $fechaFin = new DateTime($fechaFinInput);
            
    //         if ($fechaFin < $fechaInicio) {
    //             echo "La fecha de fin no puede ser anterior a la fecha de inicio. Por favor, ingrese una fecha válida.\n";
    //         }
    //     } while ($fechaFin < $fechaInicio);
        
    //     // Crear la nueva tarea
    //     $idTarea = $this->obtenerNuevoIdTarea();  // Método para obtener el próximo ID disponible
    //     $nuevaTarea = new Tarea($idTarea, $nombre, $descripcion, $fechaInicio, $fechaFin, $id_proyecto, $dependencias);
        
    //     // Guardar la tarea en tareas.json
    //     $this->guardarTareaEnJson($nuevaTarea);
        
    //     // Añadir la tarea al campo "tareas" del proyecto correspondiente
    //     $gestorProyecto->agregarTareaAlProyecto($id_proyecto, $nuevaTarea);
        
    //     echo "Tarea creada exitosamente: " . $nuevaTarea->getNombre() . " con ID " . $nuevaTarea->getIdTarea() . "\n";
    // }
        
    public function crearTarea($gestorProyecto) {
        // Primero preguntar el ID del proyecto
        echo "Ingrese el ID del proyecto al que pertenece la tarea: ";
        $id_proyecto = trim(fgets(STDIN));
        
        // Obtener el proyecto desde el gestor de proyectos
        $proyecto = $gestorProyecto->buscarProyectoPorId($id_proyecto);
        
        if (!$proyecto) {
            echo "El proyecto con ID $id_proyecto no existe.\n";
            return;  // Si el proyecto no existe, terminamos la función
        }
        
        // Obtener las fechas de inicio y fin del proyecto
        $fechaInicioProyecto = $proyecto->getFechaInicio(); // Ya es un objeto DateTime
        $fechaFinProyecto = $proyecto->getFechaFin(); // Ya es un objeto DateTime
        
        // Preguntar al usuario si la tarea es dependiente o independiente
        echo "¿La tarea es dependiente o independiente? (dependiente/independiente): ";
        $tipoTarea = trim(fgets(STDIN));
    
        // Obtener todas las tareas del proyecto
        $tareasProyecto = $gestorProyecto->obtenerTareasPorIdProyecto($id_proyecto);
        
        // Ordenar las tareas por fecha de fin (descendente) para encontrar la última tarea
        usort($tareasProyecto, function($a, $b) {
            return $a->getFechaFin() < $b->getFechaFin();
        });
    
        // Si hay tareas en el proyecto, la última tarea es la primera en la lista después de ordenar
        $ultimaTarea = (count($tareasProyecto) > 0) ? $tareasProyecto[0] : null;
        
        // Ahora proceder según el tipo de tarea
        if (strtolower($tipoTarea) == 'dependiente') {
            // Si la tarea es dependiente, asignamos las fechas en función de la última tarea
    
            // Si hay tareas en el proyecto, la fecha de inicio de la nueva tarea debe ser al día siguiente de la fecha de fin de la última tarea
            if ($ultimaTarea) {
                $fechaInicioTarea = clone $ultimaTarea->getFechaFin();
                $fechaInicioTarea->modify("+1 day");  // Comenzar al día siguiente
            } else {
                // Si no hay tareas previas, asignamos la fecha de inicio como la fecha de inicio del proyecto
                $fechaInicioTarea = $fechaInicioProyecto;
            }
            
            // Preguntar los datos de la tarea
            echo "Ingrese el nombre de la tarea: ";
            $nombre = trim(fgets(STDIN));
            
            echo "Ingrese la descripción de la tarea: ";
            $descripcion = trim(fgets(STDIN));
            
            // Preguntar la cantidad de días que durará la tarea
            do {
                echo "Ingrese la cantidad de días que durará la tarea: ";
                $diasDuracion = trim(fgets(STDIN));
                if (!is_numeric($diasDuracion) || $diasDuracion <= 0) {
                    echo "La duración debe ser un número entero mayor que 0.\n";
                }
            } while (!is_numeric($diasDuracion) || $diasDuracion <= 0);
            
            // Calcular la fecha de fin de la tarea sumando los días de duración
            $fechaFinTarea = clone $fechaInicioTarea;  // Clonar la fecha de inicio para no modificarla
            $fechaFinTarea->modify("+$diasDuracion days");  // Sumar la duración en días
            
            // Verificar que la fecha de fin esté dentro del rango del proyecto
            if ($fechaFinTarea > $fechaFinProyecto) {
                echo "La fecha de fin de la tarea no puede ser posterior a la fecha de fin del proyecto.\n";
                return;  // Salir si la fecha de fin es inválida
            }
            
            // Crear la nueva tarea
            $idTarea = $this->obtenerNuevoIdTarea();  // Método para obtener el próximo ID disponible
            $nuevaTarea = new Tarea($idTarea, $nombre, $descripcion, $fechaInicioTarea, $fechaFinTarea, $id_proyecto, []);
    
        } elseif (strtolower($tipoTarea) == 'independiente') {
            // Si la tarea es independiente, pedimos las fechas de inicio y cantidad de días
    
            // Preguntar la fecha de inicio de la tarea
            do {
                echo "Ingrese la fecha de inicio de la tarea (formato: Y-m-d): ";
                $fechaInicioInput = trim(fgets(STDIN));
                $fechaInicioTarea = new DateTime($fechaInicioInput);
    
                // Verificar que la fecha de inicio esté dentro del rango del proyecto
                if ($fechaInicioTarea < $fechaInicioProyecto) {
                    echo "La fecha de inicio de la tarea no puede ser anterior a la fecha de inicio del proyecto.\n";
                }
            } while ($fechaInicioTarea < $fechaInicioProyecto);
    
            // Preguntar la cantidad de días que durará la tarea
            do {
                echo "Ingrese la cantidad de días que durará la tarea: ";
                $diasDuracion = trim(fgets(STDIN));
                if (!is_numeric($diasDuracion) || $diasDuracion <= 0) {
                    echo "La duración debe ser un número entero mayor que 0.\n";
                }
            } while (!is_numeric($diasDuracion) || $diasDuracion <= 0);
    
            // Calcular la fecha de fin de la tarea sumando los días de duración
            $fechaFinTarea = clone $fechaInicioTarea;  // Clonar la fecha de inicio para no modificarla
            $fechaFinTarea->modify("+$diasDuracion days");  // Sumar la duración en días
            
            // Verificar que la fecha de fin esté dentro del rango del proyecto
            if ($fechaFinTarea > $fechaFinProyecto) {
                echo "La fecha de fin de la tarea no puede ser posterior a la fecha de fin del proyecto.\n";
                return;  // Salir si la fecha de fin es inválida
            }
    
            // Crear la nueva tarea
            $idTarea = $this->obtenerNuevoIdTarea();  // Método para obtener el próximo ID disponible
            $nuevaTarea = new Tarea($idTarea, $nombre, $descripcion, $fechaInicioTarea, $fechaFinTarea, $id_proyecto, []);
        } else {
            echo "Tipo de tarea no válido. Debe ser 'dependiente' o 'independiente'.\n";
            return;
        }
        
        // Guardar la tarea en tareas.json
        $this->guardarTareaEnJson($nuevaTarea);
        
        // Añadir la tarea al campo "tareas" del proyecto correspondiente
        $gestorProyecto->agregarTareaAlProyecto($id_proyecto, $nuevaTarea);
        
        echo "Tarea creada exitosamente: " . $nuevaTarea->getNombre() . " con ID " . $nuevaTarea->getIdTarea() . "\n";
    }
    
    
         
            public function obtenerTodasLasTareas() {
                return $this->tareas;
            }

            public function editarTarea($id_tarea) {
                $tarea = $this->buscarTareaPorId($id_tarea);
            
                if (!$tarea) {
                    echo "Tarea con ID {$id_tarea} no encontrada.\n";
                    return;
                }
            
                echo "Tarea encontrada: {$tarea->getNombre()}\n";
                echo "¿Qué campo deseas editar?\n";
                echo "1. Nombre\n";
                echo "2. Descripción\n";
                echo "3. Fecha de Inicio\n";
                echo "4. Fecha de Fin\n";
                echo "5. Dependencias\n";
                echo "0. Volver\n";
            
                $opcion = trim(fgets(STDIN));
            
                switch ($opcion) {
                    case '1':
                        echo "Ingrese el nuevo nombre de la tarea: ";
                        $nombre = trim(fgets(STDIN));
                        $tarea->setNombre($nombre);
                        break;
                    case '2':
                        echo "Ingrese la nueva descripción de la tarea: ";
                        $descripcion = trim(fgets(STDIN));
                        $tarea->setDescripcion($descripcion);
                        break;
                   
                     case '3':
                            do {
                                echo "Ingrese la nueva fecha de inicio de la tarea (formato: Y-m-d): ";
                                $fecha_inicio_input = trim(fgets(STDIN));
                
                                // Validar el formato de la fecha
                                if ($this->validarFecha($fecha_inicio_input)) {
                                    $fecha_inicio = new DateTime($fecha_inicio_input);
                                    if ($fecha_inicio->format('Y') < 2025) {
                                        echo "La fecha de inicio no puede ser inferior a 2025. Por favor, ingrese una fecha válida.\n";
                                    } else {
                                        break; // Si la fecha es válida, salir del ciclo
                                    }
                                } else {
                                    echo "El formato de fecha ingresado no es válido. Debe ser Y-m-d. Ejemplo: 2025-02-08.\n";
                                }
                            } while (true);
                
                            $tarea->setFechaInicio($fecha_inicio->format('Y-m-d'));
                            // Recalcular fechas del proyecto
                            $this->gestorProyecto->actualizarFechaFinProyecto($tarea->getIdProyecto());
                            // Verificar y actualizar el camino crítico
                            $this->verificarYActualizarCaminoCritico($tarea);
                            echo "Fecha modificada. Actualización del camino crítico.\n";
                            break;
                        
                        case '4':
                            do {
                                echo "Ingrese la nueva fecha de fin de la tarea (formato: Y-m-d): ";
                                $fecha_fin_input = trim(fgets(STDIN));
                
                                // Validar el formato de la fecha
                                if ($this->validarFecha($fecha_fin_input)) {
                                    $fecha_fin = new DateTime($fecha_fin_input);
                                    if ($fecha_fin < $tarea->getFechaInicio()) {
                                        echo "La fecha de fin no puede ser anterior a la fecha de inicio. Por favor, ingrese una fecha válida.\n";
                                    } else {
                                        break; // Si la fecha es válida, salir del ciclo
                                    }
                                } else {
                                    echo "El formato de fecha ingresado no es válido. Debe ser Y-m-d. Ejemplo: 2025-02-08.\n";
                                }
                            } while (true);
                
                            $tarea->setFechaFin($fecha_fin->format('Y-m-d'));
                            $this->gestorProyecto->actualizarFechaFinProyecto($tarea->getIdProyecto());
                            // Verificar y actualizar el camino crítico
                            $this->verificarYActualizarCaminoCritico($tarea);
                            echo "Fecha modificada. Actualización del camino crítico.\n";
                            break;
                       
                    case '5':
                        echo "Ingrese el ID de la tarea dependiente: ";
                        $id_dependencia = trim(fgets(STDIN));
                        $tarea->agregarDependencia($id_dependencia);
                        break;
                    case '0':
                        return;
                    default:
                        echo "Opción no válida.\n";
                        break;
                }
            
                // Guardar la tarea actualizada en tareas.json
                $this->guardarTareaEnJson($tarea);
                echo "Tarea actualizada.\n";
            }
            public function validarFecha($fecha) {
                // Verificar si la fecha es válida en formato Y-m-d usando regex
                $patron = '/^\d{4}-\d{2}-\d{2}$/';
                return preg_match($patron, $fecha) === 1;
            }
            
            public function verificarYActualizarCaminoCritico($tarea) {
                // Ordenar tareas por fecha de inicio
                usort($this->tareas, function($a, $b) {
                    return $a->getFechaInicio() <=> $b->getFechaInicio();
                });
            
                // Verificar si el cambio de fecha afecta al camino crítico
                echo "=== Recalculando el camino crítico ===\n";
                $nuevaFechaFinProyecto = null;
            
                foreach ($this->tareas as $index => $t) {
                    // Verificar si la fecha de inicio de la siguiente tarea es posterior
                    if (isset($this->tareas[$index + 1]) && $t->getFechaFin() > $this->tareas[$index + 1]->getFechaInicio()) {
                       // echo "La fecha de una tarea ha afectado el camino crítico.\n";
                        // Recalcular y actualizar fechas
                        $nuevaFechaFinProyecto = $t->getFechaFin();
                    }
                    echo "La fecha de una tarea ha afectado el camino crítico.\n";

                }
            
                if ($nuevaFechaFinProyecto) {
                    echo "El proyecto tendrá una nueva fecha de finalización: " . $nuevaFechaFinProyecto->format('Y-m-d') . "\n";
                    // Aquí también podrías actualizar la fecha de finalización del proyecto
                    // $this->gestorProyecto->actualizarFechaFinProyecto($nuevaFechaFinProyecto);
                }
            }
            // En el método que se encarga de actualizar la fecha de finalización del proyecto
             public function actualizarFechaFinProyecto($id_proyecto) {
                    // Obtener todas las tareas del proyecto
                    $tareasDelProyecto = $this->getTareasPorProyecto($id_proyecto);
                    
                    // Ordenar las tareas por la fecha de fin (de la más tarde a la más temprana)
                    usort($tareasDelProyecto, function($a, $b) {
                        return $a->getFechaFin() <=> $b->getFechaFin();
                    });
                    
                    // La última tarea en la lista será la que determine la fecha de finalización
                    $ultimaTarea = end($tareasDelProyecto);
                    
                    // Actualizar la fecha de finalización del proyecto
                    if ($ultimaTarea) {
                        // Se obtiene la fecha de fin de la última tarea
                        $nuevaFechaFinProyecto = $ultimaTarea->getFechaFin();
                        echo "Fecha de finalización del proyecto actualizada: " . $nuevaFechaFinProyecto->format('Y-m-d') . "\n";
                    }
                    
                    // Ahora actualiza también la fecha de finalización del proyecto en su base de datos o archivo
                    // Código adicional para guardar la nueva fecha final en tu base de datos o archivo JSON
                }   

                            
        
            // Eliminar una tarea
            public function eliminarTarea($id_tarea) {
                $tareaEliminada = null;
                
                foreach ($this->tareas as $key => $tarea) {
                    if ($tarea->getIdTarea() == $id_tarea) {
                        $tareaEliminada = $tarea;
                        unset($this->tareas[$key]);
                        // Reindexar el array después de eliminar la tarea
                         $this->tareas = array_values($this->tareas);
                        $this->guardarTodasLasTareasEnJson();
                        echo "Tarea eliminada con éxito.\n";
                        break;
                    }
                }
            
                if ($tareaEliminada) {
                    // También actualizar el proyecto correspondiente en proyecto.json
                    $this->gestorProyecto->eliminarTareaDeProyecto($tareaEliminada->getIdProyecto(), $id_tarea);
                } else {
                    echo "Tarea con ID {$id_tarea} no encontrada.\n";
                }
            }
            

            // metodo separado para actualizar cuando elimino una tarea 
            public function guardarTodasLasTareasEnJson() {
                $tareasData = [];
            
                // Agregar las tareas actuales al array de tareas
                foreach ($this->tareas as $tarea) {
                    $tareasData[] = [
                        'id_tarea' => $tarea->getIdTarea(),
                        'nombre' => $tarea->getNombre(),
                        'descripcion' => $tarea->getDescripcion(),
                        'fecha_inicio' => $tarea->getFechaInicio()->format('Y-m-d'),
                        'fecha_fin' => $tarea->getFechaFin()->format('Y-m-d'),
                        'id_proyecto' => $tarea->getIdProyecto(),
                        'dependencias' => $tarea->getDependencias(),
                    ];
                }
            
                // Guardar el array de tareas actualizado en tareas.json
                file_put_contents($this->archivoJsonTareas, json_encode(['tareas' => $tareasData], JSON_PRETTY_PRINT));
            }

        
            public function calcularCaminoCritico($id_proyecto) {
                // Obtener las tareas del proyecto
                $tareasProyecto = $this->getTareasPorProyecto($id_proyecto);
            
                if (empty($tareasProyecto)) {
                    echo "No hay tareas asociadas a este proyecto.\n";
                    return;
                }
            
                // Mostrar la lista de tareas existentes
                echo "=== Lista de Tareas ===\n";
                foreach ($tareasProyecto as $tarea) {
                    echo "ID: " . $tarea->getIdTarea() . ", Nombre: " . $tarea->getNombre() . ", Fecha Inicio: " . $tarea->getFechaInicio()->format('Y-m-d') . ", Fecha Fin: " . $tarea->getFechaFin()->format('Y-m-d') . "\n";
                }
            
                // Ordenar las tareas por fecha de inicio
                usort($tareasProyecto, function($a, $b) {
                    return $a->getFechaInicio() <=> $b->getFechaInicio();
                });
            
             
            
                // Determinar el orden de ejecución respetando las dependencias
                $ordenTareas = $this->ordenarTareasPorDependencias($tareasProyecto);
                
            
            
                // Calcular el camino crítico (usaremos el método de calcular dependencias de las tareas)
                $caminoCritico = $this->calcularCaminoCriticoReal($ordenTareas);
            
             
            }
            
            
       // Método para ordenar las tareas considerando sus dependencias
       public function ordenarTareasPorDependencias($tareas) {
        $tareasOrdenadas = [];  // Almacena el orden correcto de ejecución
        $tareasPendientes = $tareas;  // Lista de tareas sin procesar
    
        // Procesar las tareas mientras haya tareas pendientes
        while (!empty($tareasPendientes)) {
            $tareasProcesadasEnEstaIteracion = false;  // Flag para verificar si procesamos alguna tarea
    
            foreach ($tareasPendientes as $key => $tarea) {
                $dependenciasCumplidas = true;
    
                // Verificar si todas las dependencias de la tarea están resueltas
                foreach ($tarea->getDependencias() as $dependencia) {
                    // Comprobamos si la dependencia está en el array de tareas ordenadas
                    if (!in_array($dependencia, array_map(fn($t) => $t->getIdTarea(), $tareasOrdenadas))) {
                        $dependenciasCumplidas = false;
                        break;
                    }
                }
    
                // Si todas las dependencias están resueltas, agregamos la tarea al orden
                if ($dependenciasCumplidas) {
                    $tareasOrdenadas[] = $tarea;
                    unset($tareasPendientes[$key]);  // Eliminar de las tareas pendientes
                    $tareasProcesadasEnEstaIteracion = true;
                    echo "Tarea " . $tarea->getNombre() . " agregada al orden\n";  // Mensaje de depuración
                }
            }
    
            // Si no se procesó ninguna tarea en esta iteración, significa que hay un ciclo o tareas sin dependencias resueltas
            if (!$tareasProcesadasEnEstaIteracion) {
                echo "Cuidado: hay dependencias no resueltas, posible ciclo en las tareas.\n";
                break;  // Detenemos el ciclo para evitar un bucle infinito
            }
        }
    
        return $tareasOrdenadas;
    }
         


                
            
                
                // Método para calcular el camino crítico
                public function calcularCaminoCriticoReal($tareasOrdenadas) {
                    $caminoCritico = [];
                    $fechaActual = new DateTime('2025-01-01'); // Fecha de inicio del proyecto
                    
                    // Procesamos las tareas para calcular fechas de inicio y fin
                    foreach ($tareasOrdenadas as $tarea) {
                        echo "Procesando tarea: " . $tarea->getNombre() . "\n"; // Esto solo es para depuración
                        
                        // Si la tarea puede comenzar después de la fecha actual
                        if ($fechaActual < $tarea->getFechaInicio()) {
                            $fechaActual = $tarea->getFechaInicio();
                        }
                
                        // Calculamos la fecha de fin de la tarea
                        $fechaFinTarea = clone $fechaActual;
                        $fechaFinTarea->add(new DateInterval('P' . $tarea->getDuracion() . 'D')); // 'P' es el prefijo para un intervalo de días
                
                        echo "Fecha de inicio para " . $tarea->getNombre() . ": " . $fechaActual->format('Y-m-d') . "\n"; // Depuración
                        echo "Fecha de fin para " . $tarea->getNombre() . ": " . $fechaFinTarea->format('Y-m-d') . "\n"; // Depuración
                
                        // Asignamos la fecha de fin calculada
                        $tarea->setFechaFin($fechaFinTarea);
                        $caminoCritico[] = $tarea;
                
                        // La próxima tarea no puede empezar antes de la fecha de fin de esta tarea
                        $fechaActual = $fechaFinTarea;
                    }
                
                    // Ahora imprimimos el camino crítico, solo una vez
                    echo "=== Camino Crítico ===\n";
                    foreach ($caminoCritico as $tarea) {
                        echo "ID: " . $tarea->getIdTarea() . ", Nombre: " . $tarea->getNombre() . ", Fecha Inicio: " . $tarea->getFechaInicio()->format('Y-m-d') . ", Fecha Fin: " . $tarea->getFechaFin()->format('Y-m-d') . "\n";
                    }
                
                    return $caminoCritico;
                }
                
                
            
            public function getTareasPorProyecto($id_proyecto) {
                // Devuelve todas las tareas asociadas a un proyecto
                return array_filter($this->tareas, function($tarea) use ($id_proyecto) {
                    return $tarea->getIdProyecto() == $id_proyecto;
                });
            }
        }
        
      