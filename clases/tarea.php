<?php
require_once 'usuario.php';
require_once 'proyecto.php';
require_once 'estado.php';


class Tarea {
        private $id_tarea;
        private $nombre;
        private $descripcion;
        private $fecha_inicio;
        private $fecha_fin;

        public function __construct($id_tarea, $nombre, $descripcion, $fecha_inicio, $fecha_fin, $id_proyecto) {
            $this->id_tarea = $id_tarea;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->fecha_inicio = $fecha_inicio;
            $this->fecha_fin = $fecha_fin;
            $this->id_proyecto = $id_proyecto;

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
            $this->fecha_fin = $fecha_fin;
        }


        public function toArray() {
            return [
                'id_tarea' => $this->id_tarea,
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'fecha_inicio' => $this->fecha_inicio,
                'fecha_fin' => $this->fecha_fin,
                'id_proyecto' => $this->id_proyecto,
            ];
        }
        public static function fromArray($array) {
            return new self(
                $array['id_tarea'],
                $array['nombre'],
                $array['descripcion'],
                $array['fecha_inicio'],
                $array['fecha_fin'],
                $array['id_proyecto'],
            );
        }
    

    }


