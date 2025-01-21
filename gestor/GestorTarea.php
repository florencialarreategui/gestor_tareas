<?php
require_once './clases/Tarea.php';

class GestorTarea {
    protected $archivoTareas = './archivos/tareas.json';

    public function __construct() {
        // Aquí no necesitamos un gestorProyecto, ya que las tareas se manejan por separado
    }

    // Método para crear una tarea
    public function crearTarea($gestorProyecto) {
        echo "Ingrese el nombre de la tarea: ";
        $nombre = trim(fgets(STDIN));

        echo "Ingrese la descripción de la tarea: ";
        $descripcion = trim(fgets(STDIN));

        echo "Ingrese la fecha de inicio (YYYY-MM-DD): ";
        $fechaInicio = trim(fgets(STDIN));

        echo "Ingrese la fecha de fin (YYYY-MM-DD): ";
        $fechaFin = trim(fgets(STDIN));

        echo "Ingrese la duración de la tarea en días: ";
        $duracion = trim(fgets(STDIN));

        echo "Ingrese el ID del proyecto al que pertenece la tarea: ";
        $idProyecto = trim(fgets(STDIN));

        // Buscar el proyecto por ID
        $proyecto = $gestorProyecto->buscarProyectoPorId($idProyecto);
        if ($proyecto) {
            // Crear la tarea
            $idTarea = uniqid(); // Generamos un ID único para la tarea
            $tarea = new Tarea($idTarea, $nombre, $descripcion, $fechaInicio, $fechaFin, $duracion, $idProyecto);

            // Agregar la tarea al proyecto
            $proyecto->agregarTarea($tarea);

            // Guardar la tarea en el archivo JSON
            $this->guardarEnJson($tarea);

            echo "Tarea creada y agregada al proyecto exitosamente.\n";
        } else {
            echo "Proyecto no encontrado. No se puede asociar la tarea.\n";
        }
    }

    // Método para listar todas las tareas
    public function listarTareas() {
        $tareas = $this->cargarDesdeJson();  // Cargar tareas desde el archivo JSON
        echo "=== Lista de Tareas ===\n";
        foreach ($tareas as $tarea) {
            echo "ID: {$tarea->getIdTarea()}\n";
            echo "Nombre: {$tarea->getNombre()}\n";
            echo "Descripción: {$tarea->getDescripcion()}\n";
            echo "Fecha de Inicio: {$tarea->getFechaInicio()}\n";
            echo "Fecha de Fin: {$tarea->getFechaFin()}\n";
            echo "Duración: {$tarea->getDuracion()} días\n";
            echo "ID Proyecto: {$tarea->getIdProyecto()}\n";
            echo "-------------------------\n";
        }
    }

    // Método para editar una tarea
    public function editarTarea() {
        echo "Ingrese el ID de la tarea a editar: ";
        $idTarea = trim(fgets(STDIN));

        $tarea = $this->buscarTareaPorId($idTarea);
        if ($tarea) {
            echo "Tarea encontrada. Ingrese los nuevos datos.\n";

            echo "Nuevo nombre: ";
            $tarea->setNombre(trim(fgets(STDIN)));

            echo "Nueva descripción: ";
            $tarea->setDescripcion(trim(fgets(STDIN)));

            echo "Nueva fecha de inicio (YYYY-MM-DD): ";
            $tarea->setFechaInicio(trim(fgets(STDIN)));

            echo "Nueva fecha de fin (YYYY-MM-DD): ";
            $tarea->setFechaFin(trim(fgets(STDIN)));

            echo "Nueva duración (en días): ";
            $tarea->setDuracion(trim(fgets(STDIN)));

            echo "Tarea actualizada exitosamente.\n";

            // Guardar la tarea actualizada en el archivo JSON
            $this->guardarEnJson($tarea);
        } else {
            echo "Tarea no encontrada.\n";
        }
    }

    // Método para eliminar una tarea
    public function eliminarTarea() {
        echo "Ingrese el ID de la tarea a eliminar: ";
        $idTarea = trim(fgets(STDIN));

        $tarea = $this->buscarTareaPorId($idTarea);
        if ($tarea) {
            // Eliminar tarea del archivo JSON
            $this->eliminarTareaPorId($idTarea);
            echo "Tarea eliminada exitosamente.\n";
        } else {
            echo "Tarea no encontrada.\n";
        }
    }

    // Método para calcular el camino crítico (ejemplo básico, puede extenderse)
    public function calcularCaminoCritico($tareas) {
        // Este método debe implementarse de acuerdo a la lógica del algoritmo del camino crítico (CPM)
        echo "Calculando el camino crítico...\n";
        
        // Un ejemplo simple sería solo imprimir las tareas con la mayor duración o las que dependen de otras
        foreach ($tareas as $tarea) {
            echo "Tarea: {$tarea->getNombre()}, Duración: {$tarea->getDuracion()} días\n";
        }

        // Aquí debería ir la lógica del algoritmo para determinar el camino crítico basado en dependencias y duración
    }

    // Métodos de soporte para manejar tareas en archivos JSON

    // Cargar tareas desde el archivo JSON
    public function cargarDesdeJson() {
        if (file_exists($this->archivoTareas)) {
            $json = file_get_contents($this->archivoTareas);
            $datos = json_decode($json, true);  // Decodificar el contenido JSON a un array
            $tareas = [];
            foreach ($datos as $tareaData) {
                $tareas[] = Tarea::fromArray($tareaData);  // Crear objetos Tarea desde los datos
            }
            return $tareas;
        }
        return [];  // Si el archivo no existe, devolver un array vacío
    }

    // Guardar una tarea en el archivo JSON
    public function guardarEnJson(Tarea $tarea) {
        // Leer las tareas actuales
        $tareas = $this->cargarDesdeJson();
        // Agregar la nueva tarea
        $tareas[] = $tarea->toArray();  // Convertir a array antes de guardar
        // Guardar nuevamente en el archivo JSON
        file_put_contents($this->archivoTareas, json_encode($tareas, JSON_PRETTY_PRINT));
    }

    // Buscar una tarea por ID
    private function buscarTareaPorId($idTarea) {
        $tareas = $this->cargarDesdeJson();
        foreach ($tareas as $tarea) {
            if ($tarea->getIdTarea() == $idTarea) {
                return $tarea;
            }
        }
        return null;
    }

    // Eliminar una tarea por ID
    private function eliminarTareaPorId($idTarea) {
        $tareas = $this->cargarDesdeJson();
        $tareasFiltradas = array_filter($tareas, function($tarea) use ($idTarea) {
            return $tarea->getIdTarea() != $idTarea;
        });
        // Guardar las tareas filtradas en el archivo JSON
        file_put_contents($this->archivoTareas, json_encode(array_values($tareasFiltradas), JSON_PRETTY_PRINT));
    }
}

    
    
