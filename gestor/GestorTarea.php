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

 /*   public function guardarTareaEnJson($tareaActualizada) {
        $tareasData = [];
    
        // Cargar tareas actuales desde el archivo JSON
        if (file_exists($this->archivoJsonTareas)) {
            $contenidoJson = file_get_contents($this->archivoJsonTareas);
            $data = json_decode($contenidoJson, true);
            if (isset($data['tareas'])) {
                foreach ($data['tareas'] as $tareaData) {
                    // Si la tarea coincide con la que estamos actualizando, se actualiza
                    if ($tareaData['id_tarea'] == $tareaActualizada->getIdTarea()) {
                        $tareasData[] = $tareaActualizada->toArray();
                    } else {
                        $tareasData[] = $tareaData;
                    }
                }
            }
        }
    
        // Guardar el array de tareas actualizado en tareas.json
        file_put_contents($this->archivoJsonTareas, json_encode(['tareas' => $tareasData], JSON_PRETTY_PRINT));
    }*/
    
            
       /* public function guardarTareaEnJson($nuevaTarea) {
            $tareasData = [];
        
            // Cargar tareas actuales desde el archivo JSON
            if (file_exists($this->archivoJsonTareas)) {
                $contenidoJson = file_get_contents($this->archivoJsonTareas);
                $data = json_decode($contenidoJson, true);
                if (isset($data['tareas'])) {
                    foreach ($data['tareas'] as $tareaData) {
                        $tareasData[] = $tareaData; // Añadir tareas existentes
                    }
                }
            }
        
            // Añadir la nueva tarea
            $tareasData[] = $nuevaTarea->toArray();
        
            // Guardar el array de tareas actualizado en tareas.json
            file_put_contents($this->archivoJsonTareas, json_encode(['tareas' => $tareasData], JSON_PRETTY_PRINT));
        }*/
        
        


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
    
    public function crearTarea($gestorProyecto) {
        echo "Ingrese el nombre de la tarea: ";
        $nombre = trim(fgets(STDIN));
    
        echo "Ingrese la descripción de la tarea: ";
        $descripcion = trim(fgets(STDIN));
    
        // Validar la fecha de inicio
        do {
            echo "Ingrese la fecha de inicio de la tarea (formato: Y-m-d): ";
            $fechaInicioInput = trim(fgets(STDIN));
            $fechaInicio = new DateTime($fechaInicioInput);
            
            if ($fechaInicio->format('Y') < 2025) {
                echo "La fecha de inicio no puede ser inferior a 2025. Por favor, ingrese una fecha válida.\n";
            }
        } while ($fechaInicio->format('Y') < 2025);
    
        // Validar la fecha de fin
        do {
            echo "Ingrese la fecha de fin de la tarea (formato: Y-m-d): ";
            $fechaFinInput = trim(fgets(STDIN));
            $fechaFin = new DateTime($fechaFinInput);
            
            if ($fechaFin < $fechaInicio) {
                echo "La fecha de fin no puede ser anterior a la fecha de inicio. Por favor, ingrese una fecha válida.\n";
            }
        } while ($fechaFin < $fechaInicio);
    
        echo "Ingrese el ID del proyecto al que pertenece la tarea: ";
        $id_proyecto = trim(fgets(STDIN));
    
        // Preguntar si la tarea tiene dependencias
        echo "¿La tarea tiene dependencias? (sí/no): ";
        $respuesta = trim(fgets(STDIN));
    
        $dependencias = [];
        if (strtolower($respuesta) == "sí" || strtolower($respuesta) == "si") {
            echo "Ingrese los IDs de las tareas de las cuales depende (separados por comas): ";
            $dependencias = explode(",", trim(fgets(STDIN)));  // Convertimos a array y eliminamos espacios en blanco
            $dependencias = array_map('trim', $dependencias); // Asegurarse de que no haya espacios en blanco
        }
    
        // Crear la nueva tarea
        $idTarea = $this->obtenerNuevoIdTarea();  // Método para obtener el próximo ID disponible
        $nuevaTarea = new Tarea($idTarea, $nombre, $descripcion, $fechaInicio, $fechaFin, $id_proyecto, $dependencias);
    
        // Guardar la tarea en tareas.json
        $this->guardarTareaEnJson($nuevaTarea);
    
        // Añadir la tarea al campo "tareas" del proyecto correspondiente
        $gestorProyecto->agregarTareaAlProyecto($id_proyecto, $nuevaTarea);
    
        echo "Tarea creada exitosamente: " . $nuevaTarea->getNombre() . " con ID " . $nuevaTarea->getIdTarea() . "\n";
    }
    
    /* public function crearTarea($gestorProyecto) {
        echo "Ingrese el nombre de la tarea: ";
        $nombre = trim(fgets(STDIN));
    
        echo "Ingrese la descripción de la tarea: ";
        $descripcion = trim(fgets(STDIN));
    
        // Validar la fecha de inicio
        do {
            echo "Ingrese la fecha de inicio de la tarea (formato: Y-m-d): ";
            $fechaInicioInput = trim(fgets(STDIN));
            $fechaInicio = new DateTime($fechaInicioInput);
            
            if ($fechaInicio->format('Y') < 2025) {
                echo "La fecha de inicio no puede ser inferior a 2025. Por favor, ingrese una fecha válida.\n";
            }
        } while ($fechaInicio->format('Y') < 2025);
    
        // Validar la fecha de fin
        do {
            echo "Ingrese la fecha de fin de la tarea (formato: Y-m-d): ";
            $fechaFinInput = trim(fgets(STDIN));
            $fechaFin = new DateTime($fechaFinInput);
            
            if ($fechaFin < $fechaInicio) {
                echo "La fecha de fin no puede ser anterior a la fecha de inicio. Por favor, ingrese una fecha válida.\n";
            }
        } while ($fechaFin < $fechaInicio);
    
        echo "Ingrese el ID del proyecto al que pertenece la tarea: ";
        $id_proyecto = trim(fgets(STDIN));
    
        // Preguntar si la tarea tiene dependencias
        echo "¿La tarea tiene dependencias? (sí/no): ";
        $respuesta = trim(fgets(STDIN));
    
        $dependencias = [];
        if (strtolower($respuesta) == "sí" || strtolower($respuesta) == "si") {
            echo "Ingrese los IDs de las tareas de las cuales depende (separados por comas): ";
            $dependencias = explode(",", trim(fgets(STDIN)));  // Convertimos a array y eliminamos espacios en blanco
            $dependencias = array_map('trim', $dependencias); // Asegurarse de que no haya espacios en blanco
        }
    
        // Crear la nueva tarea
        $idTarea = $this->obtenerNuevoIdTarea();  // Método para obtener el próximo ID disponible
        $nuevaTarea = new Tarea($idTarea, $nombre, $descripcion, $fechaInicio, $fechaFin, $id_proyecto, $dependencias);
    
        // Guardar la tarea en tareas.json
        $this->guardarTareaEnJson($nuevaTarea);
    
        // Añadir la tarea al campo "tareas" del proyecto correspondiente
        $gestorProyecto->agregarTareaAlProyecto($id_proyecto, $nuevaTarea);
    
        echo "Tarea creada exitosamente: " . $nuevaTarea->getNombre() . " con ID " . $nuevaTarea->getIdTarea() . "\n";
    } */
    
    
        

          
         
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
                            $fecha_inicio = new DateTime($fecha_inicio_input);
            
                            if ($fecha_inicio->format('Y') < 2025) {
                                echo "La fecha de inicio no puede ser inferior a 2025. Por favor, ingrese una fecha válida.\n";
                            }
                        } while ($fecha_inicio->format('Y') < 2025);
            
                        $tarea->setFechaInicio($fecha_inicio->format('Y-m-d'));
                        break;
                    case '4':
                        do {
                            echo "Ingrese la nueva fecha de fin de la tarea (formato: Y-m-d): ";
                            $fecha_fin_input = trim(fgets(STDIN));
                            $fecha_fin = new DateTime($fecha_fin_input);
            
                            if ($fecha_fin < $tarea->getFechaInicio()) {
                                echo "La fecha de fin no puede ser anterior a la fecha de inicio. Por favor, ingrese una fecha válida.\n";
                            }
                        } while ($fecha_fin < $tarea->getFechaInicio());
            
                        $tarea->setFechaFin($fecha_fin->format('Y-m-d'));
                        $this->gestorProyecto->actualizarFechaFinProyecto($tarea->getIdProyecto());
                        echo "Fecha modificada actualización del camino crítico, redirijase a la opción 7 .\n";
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
            
         /*   public function editarTarea($id_tarea) {
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
                            $fecha_inicio = new DateTime($fecha_inicio_input);
            
                            if ($fecha_inicio->format('Y') < 2025) {
                                echo "La fecha de inicio no puede ser inferior a 2025. Por favor, ingrese una fecha válida.\n";
                            }
                        } while ($fecha_inicio->format('Y') < 2025);
            
                        $tarea->setFechaInicio($fecha_inicio->format('Y-m-d'));
                        break;
                    case '4':
                        do {
                            echo "Ingrese la nueva fecha de fin de la tarea (formato: Y-m-d): ";
                            $fecha_fin_input = trim(fgets(STDIN));
                            $fecha_fin = new DateTime($fecha_fin_input);
            
                            if ($fecha_fin < $tarea->getFechaInicio()) {
                                echo "La fecha de fin no puede ser anterior a la fecha de inicio. Por favor, ingrese una fecha válida.\n";
                            }
                        } while ($fecha_fin < $tarea->getFechaInicio());
            
                        $tarea->setFechaFin($fecha_fin->format('Y-m-d'));
                        $this->gestorProyecto->actualizarFechaFinProyecto($tarea->getIdProyecto());
                        echo "Fecha modificada por corrección del camino crítico.\n";
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
            } */
            
            
        
         /*   public function editarTarea($id_tarea) {
                $tarea = $this->buscarTareaPorId($id_tarea);
            
                if (!$tarea) {
                    echo "Tarea con ID {$id_tarea} no encontrada.\n";
                    return;
                }
            
                echo "Tarea encontrada: {$tarea->getNombre()}\n";
                echo "¿Que campo deseas editar?";
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
                            $fecha_inicio = new DateTime($fecha_inicio_input);
            
                            if ($fecha_inicio->format('Y') < 2025) {
                                echo "La fecha de inicio no puede ser inferior a 2025. Por favor, ingrese una fecha válida.\n";
                            }
                        } while ($fecha_inicio->format('Y') < 2025);
            
                        $tarea->setFechaInicio($fecha_inicio->format('Y-m-d'));
                        break;
                    case '4':
                        do {
                            echo "Ingrese la nueva fecha de fin de la tarea (formato: Y-m-d): ";
                            $fecha_fin_input = trim(fgets(STDIN));
                            $fecha_fin = new DateTime($fecha_fin_input);
            
                            if ($fecha_fin < $tarea->getFechaInicio()) {
                                echo "La fecha de fin no puede ser anterior a la fecha de inicio. Por favor, ingrese una fecha válida.\n";
                            }
                        } while ($fecha_fin < $tarea->getFechaInicio());
            
                        $tarea->setFechaFin($fecha_fin->format('Y-m-d'));
                        // Actualizar la fecha fin del proyecto si se cambia la fecha fin de la tarea
                        $this->gestorProyecto->actualizarFechaFinProyecto($tarea->getIdProyecto());
                        echo "Fecha modificada por corrección del camino crítico.\n";
                        break;
                    case '5':
                        echo "Ingrese el ID de la tarea dependiente: ";
                        $id_dependencia = trim(fgets(STDIN));
                        $tarea->agregarDependencia($id_tarea);
                        break;
                    case '0':
                        return;
                    default:
                        echo "Opción no válida.\n";
                        break;
                }
            
                $this->guardarTareaEnJson($tarea) ;
                echo "Tarea actualizada.\n";
            } */
            
       
            
        
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

           /* public function calcularCaminoCritico($id_proyecto) {
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
            
                echo "=== Tareas Ordenadas por Fecha de Inicio ===\n";
                foreach ($tareasProyecto as $tarea) {
                    echo "ID: " . $tarea->getIdTarea() . ", Nombre: " . $tarea->getNombre() . ", Fecha Inicio: " . $tarea->getFechaInicio()->format('Y-m-d') . ", Fecha Fin: " . $tarea->getFechaFin()->format('Y-m-d') . "\n";
                }
            
                // Determinar y mostrar el camino crítico
                echo "=== Camino Crítico ===\n";
                $tareasCriticas = [];
                foreach ($tareasProyecto as $tarea) {
                    if (empty($tarea->getDependencias())) {
                        $tareasCriticas[] = $tarea;
                    } else {
                        foreach ($tarea->getDependencias() as $dependencia) {
                            $tareaDependencia = $this->buscarTareaPorId($dependencia);
                            if ($tareaDependencia && $tarea->getFechaInicio() <= $tareaDependencia->getFechaFin()) {
                                $tareasCriticas[] = $tarea;
                            }
                        }
                    }
                }
            
                foreach ($tareasCriticas as $tarea) {
                    echo "ID: " . $tarea->getIdTarea() . ", Nombre: " . $tarea->getNombre() . ", Fecha Inicio: " . $tarea->getFechaInicio()->format('Y-m-d') . ", Fecha Fin: " . $tarea->getFechaFin()->format('Y-m-d') . "\n";
                }
            }*/
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
            
                echo "=== Tareas dependientes ordenadas  ===\n";
                foreach ($tareasProyecto as $tarea) {
                    echo "ID: " . $tarea->getIdTarea() . ", Nombre: " . $tarea->getNombre() . ", Fecha Inicio: " . $tarea->getFechaInicio()->format('Y-m-d') . ", Fecha Fin: " . $tarea->getFechaFin()->format('Y-m-d') . "\n";
                }
            }
            
        
            

          /*  public function calcularCaminoCritico($id_proyecto) {
                $tareasProyecto = $this->getTareasPorProyecto($id_proyecto);
            
                if (empty($tareasProyecto)) {
                    echo "No hay tareas asociadas a este proyecto.\n";
                    return;
                }
            
                // Inicialización
                $fechasTempranas = [];
                $fechasTardías = [];
                $duracionTotal = 0;
                $tareasCriticas = [];
            
                // Calcular fechas tempranas
                foreach ($tareasProyecto as $tarea) {
                    $idTarea = $tarea->getIdTarea();
                    $fechaInicio = $tarea->getFechaInicio();
                    $fechaFin = $tarea->getFechaFin();
                    $duracion = $fechaFin->diff($fechaInicio)->days;
            
                    if (!isset($fechasTempranas[$idTarea])) {
                        $fechasTempranas[$idTarea] = clone $fechaInicio;
                    }
            
                    foreach ($tarea->getDependencias() as $dependencia) {
                        if (!isset($fechasTempranas[$dependencia])) {
                            $fechasTempranas[$dependencia] = clone $fechaInicio;
                        }
                        $fechaFinDependencia = clone $fechasTempranas[$dependencia];
                        $fechaFinDependencia->add(new DateInterval("P{$duracion}D"));
            
                        if ($fechasTempranas[$idTarea] < $fechaFinDependencia) {
                            $fechasTempranas[$idTarea] = clone $fechaFinDependencia;
                        }
                    }
            
                    if ($duracionTotal < $fechaFin->getTimestamp()) {
                        $duracionTotal = $fechaFin->getTimestamp();
                    }
                }
            
                // Calcular fechas tardías
                foreach (array_reverse($tareasProyecto) as $tarea) {
                    $idTarea = $tarea->getIdTarea();
                    $fechaFin = $tarea->getFechaFin();
            
                    if (!isset($fechasTardías[$idTarea])) {
                        $fechasTardías[$idTarea] = new DateTime();
                        $fechasTardías[$idTarea]->setTimestamp($duracionTotal);
                    }
            
                    foreach ($tarea->getDependencias() as $dependencia) {
                        if (!isset($fechasTardías[$dependencia])) {
                            $fechasTardías[$dependencia] = new DateTime('9999-12-31');
                        }
                        $fechaInicioDependencia = clone $fechasTardías[$dependencia];
                        $fechaInicioDependencia->sub(new DateInterval("P{$duracion}D"));
            
                        if ($fechasTardías[$idTarea] > $fechaInicioDependencia) {
                            $fechasTardías[$idTarea] = clone $fechaInicioDependencia;
                        }
                    }
                }
            
                // Determinar las tareas críticas
                foreach ($tareasProyecto as $tarea) {
                    $idTarea = $tarea->getIdTarea();
                    $holgura = ($fechasTardías[$idTarea]->getTimestamp() - $fechasTempranas[$idTarea]->getTimestamp()) / (24 * 60 * 60); // Convertir a días
                    echo "Tarea: " . $tarea->getNombre() . " (ID: " . $idTarea . ") - Holgura: " . $holgura . " días\n";
                    if (round($holgura) == 0) {
                        $tareasCriticas[] = $tarea;
                    }
                }
            
                // Ordenar las tareas críticas por fechas tempranas
                usort($tareasCriticas, function($a, $b) use ($fechasTempranas) {
                    return $fechasTempranas[$a->getIdTarea()] <=> $fechasTempranas[$b->getIdTarea()];
                });
            
                echo "El camino crítico es:\n";
                foreach ($tareasCriticas as $tarea) {
                    echo "Tarea: " . $tarea->getNombre() . " (ID: " . $tarea->getIdTarea() . ") - Fecha Inicio: " . $fechasTempranas[$tarea->getIdTarea()]->format('Y-m-d') . "\n";
                }
            }*/
            
            
            
            public function getTareasPorProyecto($id_proyecto) {
                // Devuelve todas las tareas asociadas a un proyecto
                return array_filter($this->tareas, function($tarea) use ($id_proyecto) {
                    return $tarea->getIdProyecto() == $id_proyecto;
                });
            }
        }
        
      