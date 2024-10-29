<?php


class Proyecto {
    private $id_proyecto;
    private $nombre;
    private $descripcion;
    private $fechaInicio;
    private $fechaFin;
    private $estado;

    public function __construct($id_proyecto, $nombre, $descripcion, $fechaInicio, $fechaFin,$estado) {
        $this->id_proyecto = $id_proyecto;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->estado= $estado;
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

    public function getEstado() {
        return $this->estado;
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
    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function toArray() {
        return [
            'id_proyecto' => $this->id_proyecto,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
            'estado' => $this->estado,
        ];
    }

    public static function fromArray($array) {
        return new self(
            $array['id_proyecto'],
            $array['nombre'],
            $array['descripcion'],
            $array['fechaInicio'],
            $array['fechaFin'],
            $array['estado'],
        );
    }
}
