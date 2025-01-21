<?php
class Tarea {
    private $id_tarea;
    private $nombre;
    private $descripcion;
    private $fechaInicio;
    private $fechaFin;
    private $id_proyecto;
    private $dependencias = [];

    public function __construct($id_tarea, $nombre, $descripcion, $fechaInicio, $fechaFin, $id_proyecto) {
        $this->id_tarea = $id_tarea;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->fechaInicio = new DateTime($fechaInicio); // Convertimos a DateTime
        $this->fechaFin = new DateTime($fechaFin); // Convertimos a DateTime
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
        return $this->fechaInicio;
    }

    public function getFechaFin() {
        return $this->fechaFin;
    }

    public function getIdProyecto() {
        return $this->id_proyecto;
    }

    public function agregarDependencia($idDependencia) {
        $this->dependencias[] = $idDependencia;
    }

    public function getDependencias() {
        return $this->dependencias;
    }

    public function getDuracion() {
        $intervalo = $this->fechaInicio->diff($this->fechaFin);
        return $intervalo->days; // Retorna la duración en días
    }

    public function toArray() {
        return [
            'id_tarea' => $this->id_tarea,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'fecha_inicio' => $this->fechaInicio->format('Y-m-d'),
            'fecha_fin' => $this->fechaFin->format('Y-m-d'),
            'id_proyecto' => $this->id_proyecto,
            'dependencias' => $this->dependencias
        ];
    }

    public static function fromArray($array) {
        $tarea = new self(
            $array['id_tarea'],
            $array['nombre'],
            $array['descripcion'],
            $array['fecha_inicio'],
            $array['fecha_fin'],
            $array['id_proyecto']
        );

        if (isset($array['dependencias']) && is_array($array['dependencias'])) {
            foreach ($array['dependencias'] as $idDependencia) {
                $tarea->agregarDependencia($idDependencia);
            }
        }

        return $tarea;
    }
}

