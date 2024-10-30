<?php
require_once './clases/estado.php';


class GestorEstado {
    public $estados = [];

    public function __construct() {
        $this->cargarDesdeJSON();
    }

    public function agregarEstado($estado) {
        $this->estados[] = $estado;
        $this->guardarEnJSON();
    }

    public function obtenerEstado($estado) {
        foreach ($this->estados as $estadoObj) {
            if ($estadoObj->getEstado() == $estado) {
                return $estadoObj;
            }
        }
        return null;
    }

    public function actualizarEstado($estado, $nombre) {
        $estadoObj = $this->obtenerEstado($estado);
        if ($estadoObj) {
            $estadoObj->setNombre($nombre);
            $this->guardarEnJSON();
        }
    }

    public function guardarEnJSON() {
        $estados = [];
        foreach ($this->estados as $estado) {
            $estados[] = $estado->toArray();
        }
        $jsonestado = json_encode(['estado' => $estados], JSON_PRETTY_PRINT);
        file_put_contents($this->archivoJson, $jsonestado);
    }

    public function cargarDesdeJSON() {
        if (file_exists($this->archivoJson)) {
            $jsonestado = file_get_contents($this->archivoJson);
            $estados = json_decode($jsonestado, true)['estado'];
            $this->estados = [];
            foreach ($estados as $estadoData) {
                $estado = new Estado(
                    $estadoData['estado'],
                    $estadoData['nombre']
                );
                $this->estados[] = $estado;
            }
        }
    }
}
