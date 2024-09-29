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
        private $id_proyecto;
        private $id_usuario;
        private $id_estado;

        public function __construct($id_tarea, $nombre, $descripcion, $fecha_inicio, $fecha_fin, $id_proyecto, $id_usuario, $id_estado) {
            $this->id_tarea = $id_tarea;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->fecha_inicio = $fecha_inicio;
            $this->fecha_fin = $fecha_fin;
            $this->id_proyecto = $id_proyecto;
            $this->id_usuario = $id_usuario;
            $this->id_estado = $id_estado;
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

        public function getIdUsuario() {
            return $this->id_usuario;
        }

        public function getIdEstado() {
            return $this->id_estado;
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

        public function setIdUsuario($id_usuario) {
            $this->id_usuario = $id_usuario;
        }

        public function setIdEstado($id_estado) {
            $this->id_estado = $id_estado;
        }
    

    }


