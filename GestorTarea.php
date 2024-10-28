<?php
// require_once 'usuario.php';
// require_once 'proyecto.php';
require_once 'tarea.php';
// require_once 'comentario.php';
// require_once 'estado.php';
require_once 'tarea.json';

class GestorTarea{
        public $tareas = [];
        private $archivoJson = 'tareas.json';
        private $id_tarea = 0;

        public function __construct()
        {
            $this->cargarDesdeJSON();
        }
        //----------------- Agregar tarea--------------------------------
        public function agregarTarea() {

            $this->id_tarea++;
                
            echo "Ingrese el nombre de al tarea: ";
            $nombre = trim(fgets(STDIN));

            echo "Ingrese el descripción de la tarea: ";
            $descripcion = trim(fgets(STDIN));

            echo "Ingrese la fecha de inicio (YYYY-MM-DD): ";
            $fecha_inicio= trim(fgets(STDIN));

            echo "Ingrese la fecha de finalización (YYYY-MM-DD): ";
            $fecha_fin = trim(fgets(STDIN));
            $id_proyecto =1;
            $id_usuario = 1;
            $id_estado = 1;

            $nuevaTarea = new Tarea( $this->id_tarea, $nombre, $descripcion, $fecha_inicio, $fecha_fin, $id_proyecto, $id_usuario, $id_estado);
            $this->tareas[] = $nuevaTarea;


            echo "tarea creado exitosamente: " . $nuevaTarea->getNombre() ." ". $id_tarea . "\n";
            $this->guardarEnJSON();
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

        //-------------listar Tareas--------------------------------------

        public function listarTareas() {
            if (empty($this->tareas)) {
                echo "No hay tareas registradas.\n";
                return;
            }

            echo "=== Tareas Registradas ===\n";
            foreach ($this->tareas as $tarea) {
                 echo "Id: " . $tarea->getIdTarea() . "  Nombre: " . $tarea->getNombre()  . "\n"; //" Descripción: ". $tarea->getDescripcion() "Fecha de Inicio: " . $tarea->getFechaInicio() . ", Fecha de Finalización: " . $tarea->getFechaFin() . "\n";
            }

        }

        //----------------- Editar tarea--------------------------------

        public function editarTarea() {
            echo "Ingrese el ID de la tarea que desea editar: ";
            $id_tarea = trim(fgets(STDIN));
            // Busca el proyecto por ID
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


  //----------------- Guardar en Json--------------------------------

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
                        $tareaData['id_proyecto'],
                        $tareaData['id_usuario'],
                        $tareaData['id_estado']
                    );
                    $this->tareas[] = $tarea;
                }
            }   

        }


       
        }

         //----------------- Pruebas--------------------------------
$nuevaTarea = new GestorTarea ();
$nuevaTarea->agregarTarea();
$nuevaTarea->listarTareas();
$nuevaTarea->agregarTarea();
$nuevaTarea->listarTareas();
$nuevaTarea->agregarTarea();
$nuevaTarea->listarTareas();
$nuevaTarea->editarTarea();
$nuevaTarea->listarTareas();
$nuevaTarea->eliminarTarea();
$nuevaTarea->listarTareas();
