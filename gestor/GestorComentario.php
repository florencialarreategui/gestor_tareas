<?php

require_once './clases/usuario.php';
require_once './clases/tarea.php';
require_once './clases/comentario.php';

class GestorComentario {
    public $comentarios = [];
    private $archivoJson = 'comentario.json';

    public function __construct() {
        $this->cargarDesdeJSON();
    }

    public function agregarComentario() {
        $id_comentario = generarIdNumerico();
        echo "Ingrese el ID de la tarea: ";
        $id_tarea = trim(fgets(STDIN));
        echo "Ingrese el ID del usuario: ";
        $id_usuario = trim(fgets(STDIN));
        echo "Ingrese la descripción del comentario: ";
        $contenido = trim(fgets(STDIN));
        echo "Ingrese la fecha (YYYY-MM-DD): ";
        $fecha = trim(fgets(STDIN));

        $nuevocomentario = new Comentario($id_comentario, $id_tarea, $id_usuario, $contenido, $fecha);
        $this->comentarios[] = $nuevocomentario;
        echo "Comentario creado exitosamente: " . $nuevocomentario->getIdComentario() . " " . $id_comentario . "\n";
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

    public function editarComentario() {
        echo "Ingrese el ID del comentario que desea editar: ";
        $id_comentario = trim(fgets(STDIN));
        // Busca el comentario por ID
        foreach ($this->comentarios as $comentario) {
            if ($comentario->getIdComentario() == $id_comentario) {
                echo "Ingrese la nueva descripción del comentario: ";
                $contenido = trim(fgets(STDIN));
                $comentario->setContenido($contenido);
                echo "Ingrese la nueva fecha (YYYY-MM-DD): ";
                $fecha = trim(fgets(STDIN));
                $comentario->setFecha($fecha);
                echo "Comentario editado exitosamente: " . $comentario->getIdComentario() . "\n";
                $this->guardarEnJSON();
                return;
            }
        }
        echo "Comentario no encontrado.\n";
    }

    public function eliminarComentario() {
        echo "Ingrese el ID del comentario que desea eliminar: ";
        $id_comentario = trim(fgets(STDIN));
        // Busca el índice del comentario por ID
        $indiceComentario = null;
        foreach ($this->comentarios as $indice => $comentario) {
            if ($comentario->getIdComentario() == $id_comentario) { 
                $indiceComentario = $indice;
                break;
            }
        }
        if ($indiceComentario === null) {
            echo "Comentario no encontrado.\n";
            return;
        }
        unset($this->comentarios[$indiceComentario]);
        $this->comentarios = array_values($this->comentarios); 
        echo "Comentario eliminado exitosamente.\n";
        $this->guardarEnJSON();
    }
    

    public function guardarEnJSON() {
        $comentarios = [];
        foreach ($this->comentarios as $comentario) {
            $comentarios[] = $comentario->toArray();
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
                $comentario = new Comentario(
                    $comentarioData['id_comentario'],
                    $comentarioData['id_tarea'],
                    $comentarioData['id_usuario'],
                    $comentarioData['contenido'],
                    $comentarioData['fecha']
                );
                $this->comentarios[] = $comentario;
            }
        }
    }
}
