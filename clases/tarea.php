<?php
require_once 'usuario.php';
require_once 'proyecto.php';


class Tarea {
        private $id_tarea;
        private $nombre;
        private $descripcion;
        private $fecha_inicio;
        private $fecha_fin;
        private $id_proyecto;
        private $dependencias = [];  // Array para almacenar tareas dependientes


        public function __construct($id_tarea, $nombre, $descripcion, $fecha_inicio, $fecha_fin, $id_proyecto) {
            $this->id_tarea = $id_tarea;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->fecha_inicio = $fecha_inicio;
            $this->fecha_fin = $fecha_fin;
            $this->id_proyecto = $id_proyecto;

        }

        // Método para agregar dependencias
        public function agregarDependencia($tarea) {
            $this->dependencias[] = $tarea;
        }
        
        public function getDependencias() {
            return $this->dependencias;
        }

        public function getIdTarea() {
            return $this->id_tarea;
        }

        public function getNombre() {
            return $this->nombre;
        }

        public function getDescripcion() {
            return $this->descripcion;
        }

        public function getFechaInicio() {
            return $this->fecha_inicio;
        }

        public function getFechaFin() {
            return $this->fecha_fin;
        }

        public function getIdProyecto() {
            return $this->id_proyecto;
        }

        public function setIdTarea($id_tarea) {
            $this->id_tarea = $id_tarea;
        }

        public function setNombre($nombre) {
            $this->nombre = $nombre;
        }

        public function setDescripcion($descripcion) {
            $this->descripcion = $descripcion;
        }

        public function setFechaInicio($fecha_inicio) {
            $this->fecha_inicio = $fecha_inicio;
        }

        public function setFechaFin($fecha_fin) {
            $this->fecha_fin = $fecha_fin;
        }

        public function setIdProyecto($id_proyecto) {
            $this->id_proyecto = $id_proyecto;
        }


        public function toArray() {
              // Convertir las dependencias a solo sus IDs (o a otro formato representativo)
                $dependencias = array_map(function($tarea) {
                    return $tarea->getIdTarea();
                }, $this->dependencias);
            return [
                'id_tarea' => $this->id_tarea,
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin' => $this->fecha_fin,
                'id_proyecto' => $this->id_proyecto,
                'dependencias' => $this->dependencias ,  // Guardar solo los IDs de las dependencias
            ];
        }
        public static function fromArray($array, $todasLasTareas = []) {
            // Crear la tarea base sin dependencias
            $tarea = new self(
                $array['id_tarea'],
                $array['nombre'],
                $array['descripcion'],
                $array['fecha_inicio'],
                $array['fecha_fin'],
                $array['id_proyecto']
            );
        
            // Asociar las dependencias utilizando los IDs
            if (isset($array['dependencias']) && is_array($array['dependencias'])) {
                foreach ($array['dependencias'] as $id_dependencia) {
                    // Buscar la tarea dependiente en la lista de todas las tareas (pasada como parámetro)
                    foreach ($todasLasTareas as $tareaExistente) {
                        if ($tareaExistente->getIdTarea() == $id_dependencia) {
                            // Agregar la dependencia
                            $tarea->agregarDependencia($tareaExistente);
                            break;
                        }
                    }
                }
            }
        
            return $tarea;
        }
        
           
    

    }


