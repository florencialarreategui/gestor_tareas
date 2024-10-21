<?php
require_once 'usuario.php';
require_once 'proyecto.php';
require_once 'tarea.php';
require_once 'comentario.php';
require_once 'estado.php';
require_once 'tarea.json';
require_once 'funcionesAuxiliares.php';

class GestorTarea{
        public $tareas = [];
        private $archivoJson = 'tareas.json';

        public function __construct()
        {
            $this->cargarDesdeJSON();
        }

        public function agregarTarea() {
            $id_tarea = generarIdNumerico();
            echo "Ingrese el nombre de la tarea: ";
            $nombre = trim(fgets(STDIN));
        
            echo "Ingrese la descripción de la tarea: ";
            $descripcion = trim(fgets(STDIN));

            echo "Ingrese fecha de inicio de la tarea: ";
            $fecha_inicio = trim(fgets(STDIN));

            echo "Ingrese fecha de fin de la tarea: ";
            $fecha_fin = trim(fgets(STDIN));

            $id_proyecto= 1; //getIdProyecto()
            $id_usuario= 1; //getIdUsuario()
            $id_estado =1; //getIdProyecto()
        
            // Crear un nuevo objeto de tarea
            $nuevaTarea = new tarea($id_tarea, $nombre, $descripcion, $fecha_inicio, $fecha_fin, $id_proyecto, $id_usuario, $id_estado);
         
            // Agregar la tarea al array
            $this->tareas[] = $nuevaTarea;
            $this->guardarEnJSON(); // Guardar en JSON
        
            echo "Tarea agregada exitosamente: " . $nuevaTarea->getNombre() ." ". $id_tarea . "\n";
        }

        public function obtenerTarea($id_tarea) {
            foreach ($this->tareas as $tarea) {
                if ($tarea->getIdTarea() == $id_tarea) {
                    return $tarea;
                }
            }
            return null;
        }

        public function actualizarTarea($id_tarea, $nombre, $descripcion, $fecha_inicio, $fecha_fin, $id_proyecto, $id_usuario, $id_estado) {
            $tarea = $this->obtenerTarea($id_tarea);
            if ($tarea) {
                $tarea->setNombre($nombre);
                $tarea->setDescripcion($descripcion);
                $tarea->setFechaInicio($fecha_inicio);
                $tarea->setFechaFin($fecha_fin);
                $tarea->setIdProyecto($id_proyecto);
                $tarea->setIdEstado($id_estado);
                $tarea->setIdUsuario($id_usuario);// ver error 
                
            }
            $this->guardarEnJSON();
        }

        public function eliminarTarea($id_tarea) {
            foreach ($this->tareas as $index => $tarea) {
                if ($tarea->getIdTarea() == $id_tarea) {
                    unset($this->tareas[$index]);
                    $this->tareas = array_values($this->tareas); // Reindexamos
                
                    break;
                }
               
            }
            $this->guardarEnJSON();
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
                        $tareaData['id_proyecto'],
                        $tareaData['id_usuario'],
                        $tareaData['id_estado']
                    );
                    $this->tareas[] = $tarea;
                }
            }   

        }


       
        }

        $tareaAgregada = new GestorTarea();
        $tareaAgregada->agregarTarea();

