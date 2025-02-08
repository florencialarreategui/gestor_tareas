<?php


class Proyecto {
    private $id_proyecto;
    private $nombre;
    private $descripcion;
    private $fechaInicio;
    private $fechaFin;
    private $estado;
    private $tareasDependientes = [];
    private $tareasIndependientes = [];

    public function __construct($id_proyecto, $nombre, $descripcion, $fechaInicio, $fechaFin, $estado) {
        $this->id_proyecto = $id_proyecto;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->estado = $estado;
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
    
    public function getTareasDependientes() {
        return $this->tareasDependientes;
    }
    
    public function getTareasIndependientes() {
        return $this->tareasIndependientes;
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

    public function setTareas($tareasIndependientes) {
        $this->tareasIndependientes = $tareasIndependientes;
    }

    public function agregarTarea($tareasDedependientes) {
        $this->tareasDedependientes[] = $tareasDedependientes;
    }

    // Agregar tarea dependiente
    public function agregarTareaDependiente($tarea) {
        $this->tareasDependientes[] = $tarea;
    }

    // Agregar tarea independiente
    public function agregarTareaIndependiente($tarea) {
        $this->tareasIndependientes[] = $tarea;
    }

    // Remover tarea dependiente
    public function removerTareaDependiente($tarea) {
        foreach ($this->tareasDependientes as $key => $t) {
            if ($t->getIdTarea() == $tarea->getIdTarea()) {
                unset($this->tareasDependientes[$key]);
                break;
            }
        }
    }

    // Remover tarea independiente
    public function removerTareaIndependiente($tarea) {
        foreach ($this->tareasIndependientes as $key => $t) {
            if ($t->getIdTarea() == $tarea->getIdTarea()) {
                unset($this->tareasIndependientes[$key]);
                break;
            }
        }
    }

    // Obtener todas las tareas (dependientes + independientes)
    public function getTareas() {
        return array_merge($this->tareasDependientes, $this->tareasIndependientes);
    }

   public function toArray() {
        return [
            'id_proyecto' => $this->id_proyecto,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'fechaInicio' => $this->fechaInicio,
            'fechaFin' => $this->fechaFin,
            'estado' => $this->estado,
            'tareasDependientes' => array_map(function($tarea) {
                return $tarea->toArray(); //  la clase Tarea tiene un método toArray()
            }, $this->tareasDependientes),
            'tareasIndependientes' => array_map(function($tarea) {
                return $tarea->toArray(); //  la clase Tarea tiene un método toArray()
            }, $this->tareasIndependientes),
        ];
    }

    public static function guardarEnJSON($proyectos) {
        $data = [];

        foreach ($proyectos as $proyecto) {
            $data[] = $proyecto->toArray();
        }

        // Guardar en un archivo JSON
        file_put_contents('proyectos.json', json_encode($data, JSON_PRETTY_PRINT));
    }

    // Método estático para cargar los proyectos desde un archivo JSON
    public static function cargarDesdeJSON() {
        if (file_exists('proyectos.json')) {
            $jsonData = file_get_contents('proyectos.json');
            $proyectosArray = json_decode($jsonData, true);

            $proyectos = [];
            foreach ($proyectosArray as $proyectoData) {
                $proyectos[] = self::fromArray($proyectoData);
            }

            return $proyectos;
        }

        return [];
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

   

