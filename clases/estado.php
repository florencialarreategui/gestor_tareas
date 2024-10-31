<?php
class estado {
    private $estado;
    private $nombre;

    public function __construct($estado = true, $nombre) {
        $this->setEstado($estado); // inicio el estado
        $this->nombre = $nombre;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setEstado($estado) {
        if ($estado === true || $estado === false) {
            $this->estado = $estado;
        } else {
            echo "Estado inválido: $estado";
           
        }
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function toArray() {
        return [
            'estado' => $this->estado,
            'nombre' => $this->nombre,
        ];
    }

    public static function fromArray($array) {
        return new self(
            $array['estado'],
            $array['nombre']
        );
    }
}
