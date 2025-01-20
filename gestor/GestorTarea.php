    <?php
    require_once './clases/tarea.php';
    require_once './clases/proyecto.php';
    require_once './json/proyecto.json';
   
    class GestorTarea {
        public $tareas = [];
        public $proyectos = [];
        private $archivoJsonTareas = './Json/tareas.json';
        private $archivoJsonProyectos = './Json/proyecto.json';

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

        // Método para agregar una nueva tarea a un proyecto

        public function agregarTarea($proyecto) {
            // Generar un ID para la nueva tarea
            $id_tarea = count($this->tareas) + 1; // Asegúrate de que este ID sea único
        
            echo "Ingrese el nombre de la tarea: ";
            $nombre = trim(fgets(STDIN));
        
            echo "Ingrese la descripción de la tarea: ";
            $descripcion = trim(fgets(STDIN));
        
            echo "Ingrese la fecha de inicio de la tarea (YYYY-MM-DD): ";
            $fecha_inicio = trim(fgets(STDIN));
        
            echo "Ingrese la fecha de finalización de la tarea (YYYY-MM-DD): ";
            $fecha_fin = trim(fgets(STDIN));
        
            // Validación de fechas
            if (!strtotime($fecha_inicio) || !strtotime($fecha_fin)) {
                echo "Fecha inválida.\n";
                return;
            }
        
            // Crear la nueva tarea con los datos proporcionados
            $nuevaTarea = new Tarea($id_tarea, $nombre, $descripcion, $fecha_inicio, $fecha_fin, $proyecto->getIdProyecto());
        
            // Agregar la tarea al proyecto
            $proyecto->agregarTarea($nuevaTarea);
        
            // También agregar la tarea a la lista global de tareas
            $this->tareas[] = $nuevaTarea;
        
            echo "Tarea agregada exitosamente: " . $nuevaTarea->getNombre() . " (ID: " . $id_tarea . ")\n";
        
            // Guardar las tareas en JSON
            $this->guardarEnJSON();
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

        // Método para guardar tareas y proyectos en JSON
        public function guardarEnJSON() {
            // Guardamos las tareas
            $tareas = array_map(fn($tarea) => $tarea->toArray(), $this->tareas);
            $jsontarea = json_encode(['tarea' => $tareas], JSON_PRETTY_PRINT);
            file_put_contents($this->archivoJsonTareas, $jsontarea);

            // Guardamos los proyectos
            $proyectos = array_map(fn($proyecto) => $proyecto->toArray(), $this->proyectos);
            $jsonproyecto = json_encode(['proyectos' => $proyectos], JSON_PRETTY_PRINT);
            file_put_contents($this->archivoJsonProyectos, $jsonproyecto);
        }

        // Método para cargar desde JSON (tareas y proyectos)
        public function cargarDesdeJSON() {
            echo "Cargando desde archivo JSON: " . $this->archivoJsonProyectos . "\n"; // Mensaje de depuración
            if (file_exists($this->archivoJsonProyectos)) {
                $jsonproyecto = file_get_contents($this->archivoJsonProyectos);
                $data = json_decode($jsonproyecto, true);
        
                if (isset($data['proyectos']) && is_array($data['proyectos'])) {
                    $proyectos = $data['proyectos'];
                    $this->proyectos = [];
                    foreach ($proyectos as $proyectoData) {
                        $proyecto = Proyecto::fromArray($proyectoData);
        
                        if (isset($proyectoData['tareas']) && is_array($proyectoData['tareas'])) {
                            foreach ($proyectoData['tareas'] as $tareaData) {
                                $tarea = Tarea::fromArray($tareaData);
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
        
        
        
            // Verifica que los proyectos se cargaron correctamente
            var_dump($this->proyectos);  // Esto te ayudará a depurar si los proyectos están siendo cargados correctamente
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


