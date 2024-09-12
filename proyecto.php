<?php
class Proyecto {
    private $id_proyecto;
    private $nombre;
    private $descripcion;

    public function __construct($id_proyecto, $nombre, $descripcion) {
        $this->id_proyecto = $id_proyecto;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
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

    public function setIdProyecto($id_proyecto) {
        $this->id_proyecto = $id_proyecto;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
}