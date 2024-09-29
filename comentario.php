<?php
require_once 'usuario.php';
require_once 'tarea.php';

class Comentario {
        private $id_comentario;
        private $id_tarea;
        private $id_usuario;
        private $contenido;
        private $fecha;

        public function __construct($id_comentario, $id_tarea, $id_usuario, $contenido, $fecha) {
            $this->id_comentario = $id_comentario;
            $this->id_tarea = $id_tarea;
            $this->id_usuario = $id_usuario;
            $this->contenido = $contenido;
            $this->fecha = $fecha;
        }

        public function getIdComentario() {
            return $this->id_comentario;
        }

        public function getIdTarea() {
            return $this->id_tarea;
        }

        public function getIdUsuario() {
            return $this->id_usuario;
        }

        public function getContenido() {
            return $this->contenido;
        }

        public function getFecha() {
            return $this->fecha;
        }

        public function setIdComentario($id_comentario) {
            $this->id_comentario = $id_comentario;
        }

        public function setIdTarea($id_tarea) {
            $this->id_tarea = $id_tarea;
        }

        public function setIdUsuario($id_usuario) {
            $this->id_usuario = $id_usuario;
        }

        public function setContenido($contenido) {
            $this->contenido = $contenido;
        }

        public function setFecha($fecha) {
            $this->fecha = $fecha;
        }
    }
