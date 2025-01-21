    <?php
    require_once './clases/tarea.php';
    require_once './clases/proyecto.php';
    require_once './json/proyecto.json';
   
    class GestorTarea {
        public $tareas = [];
        
        private $archivoJsonTareas = './Json/tareas.json';
       

        public function __construct() {
            $this->cargarDesdeJSON();
        }

        // Método para calcular el camino crítico
        public function calcularCaminoCritico() {
            $tareasCriticas = [];
            $duracionTareas = [];

            // Calcular la duración de cada tarea
            foreach ($this->tareas as $tarea) {
                $fechaInicio = new DateTime($tarea->getFechaInicio());
                $fechaFin = new DateTime($tarea->getFechaFin());
                $duracionTareas[$tarea->getIdTarea()] = $fechaFin->diff($fechaInicio)->days;
            }

            // Usar un algoritmo que tenga en cuenta las dependencias
            $this->recorrerTareas($this->tareas, $duracionTareas, $tareasCriticas, [], []);

            return $tareasCriticas;
        }

        // Método recursivo para recorrer las tareas y sus dependencias
        private function recorrerTareas($tareas, $duracionTareas, &$tareasCriticas, $caminoActual, $tareasVisitadas) {
            if (empty($tareas)) {
                $tiempoTotal = array_sum(array_map(fn($tareaId) => $duracionTareas[$tareaId], $caminoActual));
                $tareasCriticas[] = ['camino' => $caminoActual, 'duracion' => $tiempoTotal];
                return;
            }

            foreach ($tareas as $tarea) {
                if (in_array($tarea->getIdTarea(), $tareasVisitadas)) {
                    continue;
                }

                $nuevoCamino = array_merge($caminoActual, [$tarea->getIdTarea()]);
                $nuevoTareasVisitadas = array_merge($tareasVisitadas, [$tarea->getIdTarea()]);

                // Verificamos las dependencias
                $dependencias = $tarea->getDependencias();
                if (empty($dependencias)) {
                    $this->recorrerTareas($tareas, $duracionTareas, $tareasCriticas, $nuevoCamino, $nuevoTareasVisitadas);
                } else {
                    // Asegurarnos de que las dependencias se completen primero
                    $this->recorrerTareas($dependencias, $duracionTareas, $tareasCriticas, $nuevoCamino, $nuevoTareasVisitadas);
                }
            }
        }
            public function crearTarea() {
            // Primero aseguramos que hay proyectos disponibles
            if (empty($this->gestorProyecto->proyectos)) {
                echo "No hay proyectos disponibles. No se puede crear una tarea.\n";
                return;
            }
              // Mostrar los proyectos disponibles para que el usuario elija uno
            echo "Seleccione un proyecto para asignar la tarea:\n";
            foreach ($this->gestorProyecto->proyectos as $index => $proyecto) {
                echo ($index + 1) . ". " . $proyecto->getNombre() . "\n";
            }
            echo "Ingrese el número del proyecto: ";
            $opcionProyecto = trim(fgets(STDIN));
        
            // Validar que la opción elegida es válida
            if ($opcionProyecto < 1 || $opcionProyecto > count($this->gestorProyecto->proyectos)) {
                echo "Opción no válida. Inténtelo de nuevo.\n";
                return;
            }
        
            // Obtener el proyecto elegido
            $proyectoSeleccionado = $this->gestorProyecto->proyectos[$opcionProyecto - 1];
        
            // Llamar al método para agregar la tarea al proyecto seleccionado
            $this->gestorTarea->agregarTarea($proyectoSeleccionado);
        }
        
        
        
        public function agregarTarea($proyecto) {
            // Generar un ID para la nueva tarea
            $id_tarea = count($this->tareas) + 1; // Asegúrate de que este ID sea único
        
            echo "Ingrese el nombre de la tarea: ";
            $nombre = trim(fgets(STDIN));
        
            echo "Ingrese la descripción de la tarea: ";
            $descripcion = trim(fgets(STDIN));
        
            // Validación de la fecha de inicio
            do {
                echo "Ingrese la fecha de inicio en formato fecha(YYYY-MM-DD): ";
                $fecha_inicio = trim(fgets(STDIN));
                if ($this->esFechaValida($fecha_inicio)) {
                    break;  
                } else {
                    echo "La fecha de inicio no es válida. Intenta nuevamente.\n";
                }
            } while (true);
        
            // Validación de la fecha de finalización
            do {
                echo "Ingrese la fecha de finalización (YYYY-MM-DD): ";
                $fecha_fin = trim(fgets(STDIN));
                $validacion = $this->validarFechaInicioFin($fecha_inicio, $fecha_fin);
                if ($validacion === true) {
                    break;
                } else {
                    echo $validacion . "\n";
                }
            } while (true);
        
            // Crear la nueva tarea con los datos proporcionados
            $nuevaTarea = new Tarea($id_tarea, $nombre, $descripcion, $fecha_inicio, $fecha_fin, $proyecto->getIdProyecto());
        
            // Agregar la tarea al proyecto correspondiente
            $proyecto->agregarTarea($nuevaTarea);
        
            // También agregar la tarea a la lista global de tareas
            $this->tareas[] = $nuevaTarea;
        
            echo "Tarea agregada exitosamente: " . $nuevaTarea->getNombre() . " (ID: " . $id_tarea . ")\n";
        
            // Guardar las tareas y los proyectos en los archivos JSON
            $this->guardarEnJSON();  // Llamamos al método para guardar en ambos archivos
        }
        
        
        
        public function listarTareas() {
            if (empty($this->tareas)) {
                echo "No hay tareas disponibles.\n";
            } else {
                echo "=== Lista de Tareas ===\n";
                foreach ($this->tareas as $tarea) {
                    echo "ID: " . $tarea->getIdTarea() . " | Nombre: " . $tarea->getNombre() . " | Descripción: " . $tarea->getDescripcion() . "\n";
                }
            }
        }


        // Método para editar tareas
        public function editarTarea($proyecto) {
            echo "Ingrese el ID de la tarea que desea editar: ";
            $id_tarea = trim(fgets(STDIN));

            $tarea = $this->obtenerTarea($id_tarea);
            if ($tarea) {
                echo "=== Elija qué campo desea editar ===\n";
                while (true) {
                    echo "1. Nombre\n";
                    echo "2. Descripción\n";
                    echo "3. Fecha de inicio\n";
                    echo "4. Fecha de finalización\n";
                    echo "0. Volver\n";

                    $eleccion = trim(fgets(STDIN));
                    switch ($eleccion) {
                        case '1':
                            echo "Ingrese el nuevo nombre: ";
                            $nombre = trim(fgets(STDIN));
                            $tarea->setNombre($nombre);
                            break;
                        case '2':
                            echo "Ingrese la nueva descripción: ";
                            $descripcion = trim(fgets(STDIN));
                            $tarea->setDescripcion($descripcion);
                            break;
                        case '3':
                            echo "Ingrese la nueva fecha de inicio (YYYY-MM-DD): ";
                            $fechaInicio = trim(fgets(STDIN));
                            if (strtotime($fechaInicio)) {
                                $tarea->setFechaInicio($fechaInicio);
                            } else {
                                echo "Fecha inválida.\n";
                            }
                            break;
                        case '4':
                            echo "Ingrese la nueva fecha de finalización (YYYY-MM-DD): ";
                            $fechaFin = trim(fgets(STDIN));
                            if (strtotime($fechaFin)) {
                                $tarea->setFechaFin($fechaFin);
                            } else {
                                echo "Fecha inválida.\n";
                            }
                            break;
                        case '0':
                            return;
                        default:
                            echo "Opción no válida. Inténtelo de nuevo.\n";
                            break;
                    }
                   // $this->guardarEnJSON();
                }
            } else {
                echo "Tarea no encontrada.\n";
            }
            $this->guardarEnJSON();
        }

        // Método para eliminar tarea
        public function eliminarTarea($proyecto) {
            echo "Ingrese el ID de la tarea que desea eliminar: ";
            $id_tarea = trim(fgets(STDIN));
            $tarea = $this->obtenerTarea($id_tarea);

            if ($tarea) {
                $proyecto->setTareas(array_filter($proyecto->getTareas(), fn($t) => $t->getIdTarea() !== $id_tarea));
                echo "Tarea eliminada exitosamente.\n";
                $this->guardarEnJSON();
            } else {
                echo "Tarea no encontrada.\n";
            }
        }

       
        public function guardarEnJSON() {
            // Primero, guarda las tareas en el archivo tareas.json
            $tareas = array_map(fn($tarea) => $tarea->toArray(), $this->tareas);
            $jsontarea = json_encode(['tareas' => $tareas], JSON_PRETTY_PRINT);
            file_put_contents($this->archivoJsonTareas, $jsontarea); // Guardar tareas en tareas.json
        
            // Luego, guarda las tareas dentro de los proyectos en proyecto.json
            $proyectos = array_map(function($proyecto) {
                // Para cada proyecto, aseguramos que las tareas estén en su propiedad 'tareas'
                $tareasProyecto = array_map(fn($tarea) => $tarea->toArray(), $proyecto->getTareas());
                $proyectoArray = $proyecto->toArray();
                $proyectoArray['tareas'] = $tareasProyecto; // Incluir tareas en el proyecto
        
                return $proyectoArray;
            }, $this->proyectos);
        
            // Guardar proyectos con tareas actualizadas en proyecto.json
            $jsonproyecto = json_encode(['proyecto' => $proyectos], JSON_PRETTY_PRINT);
            file_put_contents($this->archivoJsonProyectos, $jsonproyecto); // Guardar proyectos en proyecto.json
        }
        
       /* public function cargarDesdeJSON() {
            // Cargar tareas desde el archivo tareas.json
            if (file_exists($this->archivoJsonTareas)) {
                $jsontarea = file_get_contents($this->archivoJsonTareas);
                $data = json_decode($jsontarea, true);
        
                if (isset($data['tareas']) && is_array($data['tareas'])) {
                    $tareas = $data['tareas'];
                    $this->tareas = [];
                    foreach ($tareas as $tareaData) {
                        $tarea = Tarea::fromArray($tareaData); // Asegúrate de que Tarea tenga un método fromArray()
                        $this->tareas[] = $tarea;
                    }
                }
            } else {
                $this->tareas = [];  // Si no existe el archivo, iniciamos la lista de tareas vacía
            }
        
            // Cargar proyectos desde el archivo proyecto.json
            if (file_exists($this->archivoJsonProyectos)) {
                $jsonproyecto = file_get_contents($this->archivoJsonProyectos);
                $data = json_decode($jsonproyecto, true);
        
                if (isset($data['proyecto']) && is_array($data['proyecto'])) {
                    $proyectos = $data['proyecto'];
                    $this->proyectos = [];
                    foreach ($proyectos as $proyectoData) {
                        $proyecto = Proyecto::fromArray($proyectoData); // Asegúrate de que Proyecto tenga un método fromArray()
        
                        // Asegúrate de que las tareas del proyecto sean cargadas
                        if (isset($proyectoData['tareas']) && is_array($proyectoData['tareas'])) {
                            foreach ($proyectoData['tareas'] as $tareaData) {
                                $tarea = Tarea::fromArray($tareaData);
                                $proyecto->agregarTarea($tarea);  // Agregar la tarea al proyecto
                            }
                        }
        
                        $this->proyectos[] = $proyecto;
                    }
                }
            } else {
                $this->proyectos = [];  // Si no existe el archivo, iniciamos la lista de proyectos vacía
            }
        }*/
        public function cargarDesdeJSON() {
            // Cargar tareas desde el archivo tareas.json
            if (file_exists($this->archivoJsonTareas)) {
                $jsontarea = file_get_contents($this->archivoJsonTareas);
                $data = json_decode($jsontarea, true);
        
                if (isset($data['tareas']) && is_array($data['tareas'])) {
                    $this->tareas = []; // Inicializar arreglo de tareas vacío
                    foreach ($data['tareas'] as $tareaData) {
                        // Pasamos todas las tareas para poder reconstruir las dependencias correctamente
                        $tarea = Tarea::fromArray($tareaData, $this->tareas);
                        $this->tareas[] = $tarea;
                    }
                }
            } else {
                $this->tareas = []; // Si no existe el archivo, inicializamos la lista vacía
            }
        }
        
        // Método para obtener tarea por ID
        public function obtenerTarea($id_tarea) {
            foreach ($this->tareas as $tarea) {
                if ($tarea->getIdTarea() == $id_tarea) {
                    return $tarea;
                }
            }
            return null;
        }
    }


