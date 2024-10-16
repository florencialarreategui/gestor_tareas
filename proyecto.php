<?php
class Proyecto {
        private $id_proyecto;
        private $nombre;
        private $descripcion;
        private $fechaInicio;
        private $fechaFin;

        public function __construct($id_proyecto, $nombre, $descripcion, $fechaInicio, $fechaFin) {
            $this->id_proyecto = $id_proyecto;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->fechaInicio = $fechaInicio;
            $this->fechaFin= $fechaFin;
        }

        public function getIdProyecto() {
            return $this->id_proyecto;
        }

        public function getNombre() {
            return $this->nombre;
        }

        public function getDescripcion() {
            return $this->descripcion;
        }

        public function getFechaInicio() {
            return $this->fechaInicio;
        }

        public function getFechaFin() {
            return $this->fechaFin;
        }

        public function setIdProyecto($id_proyecto) {
            $this->id_proyecto = $id_proyecto;
        }

        public function setNombre($nombre) {
            $this->nombre = $nombre;
        }

        public function setDescripcion($descripcion) {
            $this->descripcion = $descripcion;
        }

        public function setFechaInicio($fechaInicio) {
            $this->fechaInicio = $fechaInicio;
        }

        public function setFechaFin($fechaFin) {
            $this->fechaFin = $fechaFin;
        }

        public function guardarProyectoEnJson($proyecto) {
            $proyectoArray = [
                'id' => $this->id_proyecto, // Asegúrate de tener un método getId() en la clase Proyecto
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,// Asegúrate de tener este método
                'fechaInicio' => $this->getFechaInicio, // Asegúrate de tener este método
                'fechaFin' => $this->setFechaFin, // Asegúrate de tener este método
            ];
    }
    
}