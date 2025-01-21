<?php
require_once './clases/tarea.php';

class Proyecto {
    private $id_proyecto;
    private $nombre;
    private $descripcion;
    private $fechaInicio;
    private $fechaFin;
    private $estado;
    private $tareas = [];

    public function __construct($id_proyecto, $nombre, $descripcion, $fechaInicio, $fechaFin, $estado, $tareas = []) {
        $this->id_proyecto = $id_proyecto;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->fechaInicio = new DateTime($fechaInicio); // Convertimos a DateTime
        $this->fechaFin = new DateTime($fechaFin); // Convertimos a DateTime
        $this->estado = $estado;
        $this->tareas = $tareas;  // Inicializa tareas
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

    public function agregarTarea($tarea) {
        $this->tareas[] = $tarea;
    }

    public function getTareas() {
        return $this->tareas;
    }

    public function setTareas($tareas) {
        $this->tareas = $tareas;
    }

    public function calcularCaminoCritico() {
        $caminoCritico = [];
        $duraciones = [];
        $finMaximo = 0;
        
        // Inicializar duración de cada tarea
        foreach ($this->tareas as $tarea) {
            $duraciones[$tarea->getIdTarea()] = $tarea->getDuracion();
        }

        // Buscar el camino crítico recorriendo las tareas y sus dependencias
        foreach ($this->tareas as $tarea) {
            $this->evaluarDependencias($tarea, $duraciones, $caminoCritico, 0);
        }

        return $caminoCritico;
    }

    private function evaluarDependencias($tarea, &$duraciones, &$caminoCritico, $tiempoPrevio) {
        // Si la tarea ya está en el camino crítico, no hacer nada
        if (in_array($tarea->getIdTarea(), $caminoCritico)) {
            return;
        }

        // Añadir la tarea al camino crítico
        $caminoCritico[] = $tarea->getIdTarea();
        
        // Calcular el tiempo total acumulado
        $tiempoTotal = $tiempoPrevio + $tarea->getDuracion();

        // Evaluar dependencias de la tarea
        foreach ($tarea->getDependencias() as $idDependencia) {
            $dependencia = $this->obtenerTareaPorId($idDependencia);
            if ($dependencia) {
                $this->evaluarDependencias($dependencia, $duraciones, $caminoCritico, $tiempoTotal);
            }
        }

        // Devolver el tiempo total acumulado de la tarea
        return $tiempoTotal;
    }

    private function obtenerTareaPorId($id) {
        foreach ($this->tareas as $tarea) {
            if ($tarea->getIdTarea() == $id) {
                return $tarea;
            }
        }
        return null;
    }

    public function toArray() {
        return [
            'id_proyecto' => $this->id_proyecto,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'fechaInicio' => $this->fechaInicio->format('Y-m-d'),
            'fechaFin' => $this->fechaFin->format('Y-m-d'),
            'estado' => $this->estado,
            'tareas' => array_map(function($tarea) {
                return $tarea->toArray();
            }, $this->tareas),
        ];
    }

    public static function fromArray($array) {
        $proyecto = new self(
            $array['id_proyecto'],
            $array['nombre'],
            $array['descripcion'],
            $array['fechaInicio'],
            $array['fechaFin'],
            $array['estado']
        );

        if (isset($array['tareas']) && is_array($array['tareas'])) {
            foreach ($array['tareas'] as $tareaData) {
                $tarea = Tarea::fromArray($tareaData);
                $proyecto->agregarTarea($tarea);
            }
        }

        return $proyecto;
    }
}



   

