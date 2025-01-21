<?php
require_once './clases/Proyecto.php';
require_once './clases/Tarea.php';  // Aseguramos que cargamos también la clase Tarea
require_once './gestor/GestorTarea.php';

class GestorProyecto {
    protected $gestorTarea;
    private $archivoProyectos = './archivos/proyectos.json';
    private $archivoTareas = './archivos/tareas.json';

    public function __construct($gestorTarea) {
        $this->gestorTarea = $gestorTarea;
    }

    // Método para agregar un nuevo proyecto
    public function agregarProyecto() {
        echo "Ingrese el nombre del proyecto: ";
        $nombre = trim(fgets(STDIN));

        echo "Ingrese la descripción del proyecto: ";
        $descripcion = trim(fgets(STDIN));

        echo "Ingrese la fecha de inicio (YYYY-MM-DD): ";
        $fechaInicio = trim(fgets(STDIN));

        echo "Ingrese la fecha de fin (YYYY-MM-DD): ";
        $fechaFin = trim(fgets(STDIN));

        echo "Ingrese el estado del proyecto (activo/inactivo): ";
        $estado = trim(fgets(STDIN));

        // Creación del proyecto
        $idProyecto = uniqid(); // Asignamos un ID único al proyecto
        $proyecto = new Proyecto($idProyecto, $nombre, $descripcion, $fechaInicio, $fechaFin, $estado);

        echo "Proyecto creado exitosamente.\n";

        // Guardar el proyecto en el archivo JSON
        $this->guardarEnJson($proyecto);
    }

    // Método para listar todos los proyectos
    public function listarProyectos() {
        $proyectos = $this->cargarDesdeJson();  // Obtener proyectos desde archivo JSON
        echo "=== Lista de Proyectos ===\n";
        foreach ($proyectos as $proyecto) {
            echo "ID: {$proyecto->getIdProyecto()}\n";
            echo "Nombre: {$proyecto->getNombre()}\n";
            echo "Descripción: {$proyecto->getDescripcion()}\n";
            echo "Fecha de Inicio: {$proyecto->getFechaInicio()}\n";
            echo "Fecha de Fin: {$proyecto->getFechaFin()}\n";
            echo "Estado: {$proyecto->getEstado()}\n";
            echo "-------------------------\n";
        }
    }

    // Método para editar un proyecto
    public function editarProyecto() {
        echo "Ingrese el ID del proyecto a editar: ";
        $idProyecto = trim(fgets(STDIN));

        $proyecto = $this->buscarProyectoPorId($idProyecto);
        if ($proyecto) {
            echo "Proyecto encontrado. Ingrese los nuevos datos.\n";

            echo "Nuevo nombre: ";
            $proyecto->setNombre(trim(fgets(STDIN)));

            echo "Nueva descripción: ";
            $proyecto->setDescripcion(trim(fgets(STDIN)));

            echo "Nueva fecha de inicio (YYYY-MM-DD): ";
            $proyecto->setFechaInicio(trim(fgets(STDIN)));

            echo "Nueva fecha de fin (YYYY-MM-DD): ";
            $proyecto->setFechaFin(trim(fgets(STDIN)));

            echo "Nuevo estado (activo/inactivo): ";
            $proyecto->setEstado(trim(fgets(STDIN)));

            echo "Proyecto actualizado exitosamente.\n";

            // Guardar proyecto actualizado en el archivo JSON
            $this->guardarEnJson($proyecto);
        } else {
            echo "Proyecto no encontrado.\n";
        }
    }

    // Método para eliminar un proyecto
    public function eliminarProyecto() {
        echo "Ingrese el ID del proyecto a eliminar: ";
        $idProyecto = trim(fgets(STDIN));

        $proyecto = $this->buscarProyectoPorId($idProyecto);
        if ($proyecto) {
            // Eliminar proyecto del archivo JSON
            $this->eliminarProyectoPorId($idProyecto);
            echo "Proyecto eliminado exitosamente.\n";
        } else {
            echo "Proyecto no encontrado.\n";
        }
    }

    // Método para listar proyectos activos
    public function listarProyectoActivo() {
        $proyectos = $this->cargarDesdeJson();
        echo "=== Proyectos Activos ===\n";
        foreach ($proyectos as $proyecto) {
            if ($proyecto->getEstado() == 'activo') {
                echo "ID: {$proyecto->getIdProyecto()}\n";
                echo "Nombre: {$proyecto->getNombre()}\n";
                echo "Descripción: {$proyecto->getDescripcion()}\n";
                echo "Fecha de Inicio: {$proyecto->getFechaInicio()}\n";
                echo "Fecha de Fin: {$proyecto->getFechaFin()}\n";
                echo "-------------------------\n";
            }
        }
    }

    // Método para listar proyectos inactivos
    public function listarProyectoInactivo() {
        $proyectos = $this->cargarDesdeJson();
        echo "=== Proyectos Inactivos ===\n";
        foreach ($proyectos as $proyecto) {
            if ($proyecto->getEstado() == 'inactivo') {
                echo "ID: {$proyecto->getIdProyecto()}\n";
                echo "Nombre: {$proyecto->getNombre()}\n";
                echo "Descripción: {$proyecto->getDescripcion()}\n";
                echo "Fecha de Inicio: {$proyecto->getFechaInicio()}\n";
                echo "Fecha de Fin: {$proyecto->getFechaFin()}\n";
                echo "-------------------------\n";
            }
        }
    }

    // Método para listar un proyecto por ID
    public function listarProyectoPorId() {
        echo "Ingrese el ID del proyecto: ";
        $idProyecto = trim(fgets(STDIN));

        $proyecto = $this->buscarProyectoPorId($idProyecto);
        if ($proyecto) {
            echo "ID: {$proyecto->getIdProyecto()}\n";
            echo "Nombre: {$proyecto->getNombre()}\n";
            echo "Descripción: {$proyecto->getDescripcion()}\n";
            echo "Fecha de Inicio: {$proyecto->getFechaInicio()}\n";
            echo "Fecha de Fin: {$proyecto->getFechaFin()}\n";
        } else {
            echo "Proyecto no encontrado.\n";
        }
    }

    // Método para calcular el camino crítico
    public function calcularCaminoCritico() {
        echo "Calculando el camino crítico...\n";
        
        // Obtener todas las tareas del proyecto (asumiendo que cada proyecto tiene tareas asociadas)
        $proyectos = $this->cargarDesdeJson();
        foreach ($proyectos as $proyecto) {
            echo "=== Proyecto: {$proyecto->getNombre()} ===\n";
            $tareas = $proyecto->getTareas();
            $this->gestorTarea->calcularCaminoCritico($tareas);  // Llamamos al método del GestorTarea para calcular el camino crítico
        }
    }

    // Métodos de soporte para manejar proyectos (almacenamiento en archivos JSON)

    // Cargar proyectos desde el archivo JSON
    public function cargarDesdeJson() {
        if (file_exists($this->archivoProyectos)) {
            $json = file_get_contents($this->archivoProyectos);
            $datos = json_decode($json, true);  // Decodificar el contenido JSON a un array
            $proyectos = [];
            foreach ($datos as $proyectoData) {
                $proyectos[] = Proyecto::fromArray($proyectoData);  // Crear objetos Proyecto desde los datos
            }
            return $proyectos;
        }
        return [];  // Si el archivo no existe, devolver un array vacío
    }

    // Guardar un proyecto en el archivo JSON
    public function guardarEnJson(Proyecto $proyecto) {
        // Leer los proyectos actuales
        $proyectos = $this->cargarDesdeJson();
        // Agregar el nuevo proyecto
        $proyectos[] = $proyecto->toArray();  // Convertir a array antes de guardar
        // Guardar nuevamente en el archivo JSON
        file_put_contents($this->archivoProyectos, json_encode($proyectos, JSON_PRETTY_PRINT));
    }

    // Buscar un proyecto por ID
    public function buscarProyectoPorId($idProyecto) {
        $proyectos = $this->cargarDesdeJson();
        foreach ($proyectos as $proyecto) {
            if ($proyecto->getIdProyecto() == $idProyecto) {
                return $proyecto;
            }
        }
        return null;
    }

    // Eliminar un proyecto por ID
    public function eliminarProyectoPorId($idProyecto) {
        $proyectos = $this->cargarDesdeJson();
        $proyectosFiltrados = array_filter($proyectos, function($proyecto) use ($idProyecto) {
            return $proyecto->getIdProyecto() != $idProyecto;
        });
        // Guardar los proyectos filtrados en el archivo JSON
        file_put_contents($this->archivoProyectos, json_encode(array_values($proyectosFiltrados), JSON_PRETTY_PRINT));
    }
}


        
       
