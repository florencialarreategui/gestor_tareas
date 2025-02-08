<?php
require_once 'usuario.php';
require_once 'proyecto.php';


class Tarea {
        private $id_tarea;
        private $nombre;
        private $descripcion;
        private $fecha_inicio;
        private $fecha_fin;
        private $dias_duracion;
        private $id_proyecto;
        private $dependiente = false;  // Nueva propiedad para marcar si es dependiente

    

        public function __construct($id_tarea, $nombre, $descripcion, $fecha_inicio, $fecha_fin, $id_proyecto, $dias_duracion) {
            $this->id_tarea = $id_tarea;
            $this->nombre = $nombre;
            $this->descripcion = $descripcion;
            $this->fecha_inicio = $fecha_inicio;
            $this->fecha_fin = $fecha_fin;
            $this->id_proyecto = $id_proyecto;
            $this->dias_duracion = $dias_duracion;
            
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

        public function getDiasDuracion(){
            return $this->dias_duracion;
        }
    
        public function setDiasDuracion($dias_duracion) {
            $this->dias_duracion = $dias_duracion;
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

        // Método para obtener el estado de la dependencia
    public function isDependiente() {
        return $this->dependiente;
    }

    // Método para cambiar el estado de dependencia y mover la tarea al array correspondiente
    public function setDependiente($dependiente, $proyecto) {
        if ($this->dependiente != $dependiente) {
            // Si cambia el estado de dependiente, mover la tarea entre los arrays
            if ($dependiente) {
                // Si se hace dependiente, agregar al array de tareas dependientes y remover del independiente
                $proyecto->removerTareaIndependiente($this);
                $proyecto->agregarTareaDependiente($this);
            } else {
                // Si se hace independiente, agregar al array de tareas independientes y remover del dependiente
                $proyecto->removerTareaDependiente($this);
                $proyecto->agregarTareaIndependiente($this);
            }
            $this->dependiente = $dependiente; // Actualizar el atributo dependiente
        }
    }

       // Método toArray() modificado para incluir la propiedad dependiente
    public function toArray() {
        return [
            'id_tarea' => $this->id_tarea,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'fecha_inicio' => $this->fecha_inicio,
            'dias_duracion' => $this->dias_duracion,
            'fecha_fin' => $this->fecha_fin,
            'id_proyecto' => $this->id_proyecto,
            'dependiente' => $this->dependiente,  // Se incluye la propiedad dependiente
        ];
    }

    // Método fromArray() modificado para incluir la propiedad dependiente
    public static function fromArray($array) {
        return new self(
            $array['id_tarea'],
            $array['nombre'],
            $array['descripcion'],
            $array['fecha_inicio'],
            $array['dias_duracion'],
            $array['fecha_fin'],
            $array['id_proyecto'],
            isset($array['dependiente']) ? $array['dependiente'] : false  // Se agrega un valor por defecto para dependiente
        );
    }
    

    }


