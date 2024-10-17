<?php
require_once 'estado.php';

class GestorEstado {

public function agregarEstado($estado) {
            $this->estados[] = $estado;
        }

        public function obtenerEstado($id_estado) {
            foreach ($this->estados as $estado) {
                if ($estado->getIdEstado() == $id_estado) {
                    return $estado;
                }
            }
            return null;
        }

        public function actualizarEstado($id_estado, $nombre) {
            $estado = $this->obtenerEstado($id_estado);
            if ($estado) {
                $estado->setNombre($nombre);
            }
        }

        public function eliminarEstado($id_estado) {
            foreach ($this->estados as $index => $estado) {
                if ($estado->getIdEstado() == $id_estado) {
                    unset($this->estados[$index]);
                }
            }
        }
    }