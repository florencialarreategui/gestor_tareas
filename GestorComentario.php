<?php
require_once 'usuario.php';
require_once 'proyecto.php';
require_once 'tarea.php';
require_once 'comentario.php';
require_once 'estado.php';

class GestorComentario{

        public $comentarios = [];
        private $archivoJson = 'comentario.json';

        public function __construct()
        {
            $this->cargarDesdeJSON();
        }



        public function agregarComentario($comentario) {
            $this->comentarios[] = $comentario;
            $this->guardarEnJSON();
        }

        public function obtenerComentario($id_comentario) {
            foreach ($this->comentarios as $comentario) {
                if ($comentario->getIdComentario() == $id_comentario) {
                    return $comentario;
                }
            }
            return null;
        }

        public function actualizarComentario($id_comentario, $contenido, $fecha) {
            $comentario = $this->obtenerComentario($id_comentario);
            if ($comentario) {
                $comentario->setContenido($contenido);
                $comentario->setFecha($fecha);
            }
            $this->guardarEnJSON();
        }

        public function eliminarComentario($id_comentario) {
            foreach ($this->comentarios as $index => $comentario) {
                if ($comentario->getIdComentario() == $id_comentario) {
                    unset($this->comentarios[$index]);
                }
            }
            $this->guardarEnJSON();
        }
        public function guardarEnJSON() {
            $comentarios = [];

            foreach ($this->comentarios as $comentario) {
                $comentarios[] = $comentario->ToArray();
            }

            $jsoncomentario = json_encode(['comentario' => $comentarios], JSON_PRETTY_PRINT);
            file_put_contents($this->archivoJson, $jsoncomentario);
        }
        
        public function cargarDesdeJSON() {
            if (file_exists($this->archivoJson)) {
                $jsoncomentario = file_get_contents($this->archivoJson);
                $comentarios = json_decode($jsoncomentario, true)['comentario'];
                $this->comentarios = [];

            
                foreach ($comentarios as $comentarioData) {
                    $comentario = new comentario(
                        $comentarioData['id_comentario'],
                        $comentarioData['id_tarea'],
                        $comentarioData['id_usuario'],
                        $comentarioData['contenido'],
                        $comentarioData['fecha'],
                        
                    );
                    $this->comentarios[] = $comentario;
                }
            }   

        }
        }