<?php
require_once 'usuario.php';
require_once 'proyecto.php';
require_once 'tarea.php';
require_once 'comentario.php';
require_once 'estado.php';
require_once 'tarea.json';

class GestorTarea{
        public $tareas = [];
        private $archivoJson = 'tareas.json';

        public function __construct()
        {
            $this->cargarDesdeJSON();
        }

        public function agregarTarea($tarea) {
            $this->tareas[] = $tarea;
            $this->guardarEnJSON();
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