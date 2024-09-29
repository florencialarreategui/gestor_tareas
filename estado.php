<?php
class Estado {
        private $id_estado;
        private $nombre;

        public function __construct($id_estado, $nombre) {
            $this->id_estado = $id_estado;
            $this->nombre = $nombre;
        }

        public function getIdEstado() {
            return $this->id_estado;
        }

        public function getNombre() {
            return $this->nombre;
        }

        public function setIdEstado($id_estado) {
            $this->id_estado = $id_estado;
        }

        public function setNombre($nombre) {
            $this->nombre = $nombre;
        }
    }