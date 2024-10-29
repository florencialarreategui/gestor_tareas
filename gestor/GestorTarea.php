<?php
require_once 'tarea.php';

class GestorTarea{
        public $tareas = [];
        private $archivoJson = './Json/tareas.json';
        private $ultimoId;

        public function __construct()
        {
            
            $this->calcularUltimoId();
            $this->cargarDesdeJSON();
        }
        //----------------- Agregar tarea--------------------------------
        public function agregarTarea() {

            $this->ultimoId++;
                
            echo "Ingrese el nombre de al tarea: ";
            $nombre = trim(fgets(STDIN));

            echo "Ingrese el descripción de la tarea: ";
            $descripcion = trim(fgets(STDIN));

            echo "Ingrese la fecha de inicio (YYYY-MM-DD): ";
            $fecha_inicio= trim(fgets(STDIN));

            echo "Ingrese la fecha de finalización (YYYY-MM-DD): ";
            $fecha_fin = trim(fgets(STDIN));
           

            $nuevaTarea = new Tarea( $this->ultimoId, $nombre, $descripcion, $fecha_inicio, $fecha_fin);
            $this->tareas[] = $nuevaTarea;


            echo "Tarea creada exitosamente: " . $nuevaTarea->getNombre() ." ". $this->ultimoId . "\n";
            $this->guardarEnJSON();
        }


        //----------------- calcularUltimoId --------------------------------
        private function calcularUltimoId() {
            if (!empty($this->tareas)) {
                $this->ultimoId = max(array_map(function($tarea) {
                    return $tarea->getIdTarea();
                }, $this->tareas));
            } else {
                $this->ultimoId = 0; // Comienza desde 0 si no hay tareas
            }
            echo gettype($this->ultimoId);
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
                    );
                    $this->tareas[] = $tarea;
                }
            }   

        }


       
        }

