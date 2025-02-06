<?php
require_once './clases/proyecto.php';
require_once './clases/tarea.php';  
require_once './gestor/GestorTarea.php';



class GestorProyecto {
    private $proyectos = [];
    private $archivoJson = './Json/proyecto.json';
    private $gestorTarea; // Atributo para gestionar tareas

    public function __construct($gestorTarea) {
        $this->gestorTarea = $gestorTarea; // Asignar la instancia de GestorTarea
        $this->cargarDesdeJSON();
    }
    public function setGestorTarea($gestorTarea) {
        $this->gestorTarea = $gestorTarea;
    }

    // Crear un nuevo proyecto
    public function crearProyecto() {
        $id_proyecto = count($this->proyectos) + 1;

        echo "Ingrese el nombre del proyecto: ";
        $nombre = trim(fgets(STDIN));

        echo "Ingrese la descripción del proyecto: ";
        $descripcion = trim(fgets(STDIN));

        echo "Ingrese la fecha de inicio (formato: Y-m-d): ";
        $fechaInicio = trim(fgets(STDIN));

        echo "Ingrese la fecha de fin (formato: Y-m-d): ";
        $fechaFin = trim(fgets(STDIN));

        echo "Ingrese el estado del proyecto (por ejemplo: en progreso, finalizado): ";
        $estado = trim(fgets(STDIN));

        // Crear un nuevo proyecto
        $nuevoProyecto = new Proyecto($id_proyecto, $nombre, $descripcion, $fechaInicio, $fechaFin, $estado);

        // Almacenar el nuevo proyecto en el array
        $this->proyectos[] = $nuevoProyecto;

        echo "Proyecto creado exitosamente: " . $nuevoProyecto->getNombre() . " con ID " . $nuevoProyecto->getId_proyecto() . "\n";

        $this->guardarEnJSON();
    }

    // Listar proyectos
    public function listarProyectosPorId() {

        $proyectos = $this->cargarDesdeJson(); // Cargar todos los proyectos
    
        if (empty($proyectos)) {
            echo "No hay proyectos disponibles.\n";
            return;
        }
    
        // Ordenar proyectos por ID
        usort($proyectos, function($a, $b) {
            return $a-> getId_proyecto() <=> $b-> getId_proyecto();  // Ordenar por ID
        });
    
        echo "=== Lista de Proyectos Ordenados por ID ===\n";
        foreach ($proyectos as $proyecto) {
            echo "ID: {$proyecto->getId_proyecto()}\n";
            echo "Nombre: {$proyecto->getNombre()}\n";
            echo "Descripción: {$proyecto->getDescripcion()}\n";
            echo "Fecha de Inicio: {$proyecto->getFechaInicio()->format('Y-m-d')}\n";
            echo "Fecha de Fin: {$proyecto->getFechaFin()->format('Y-m-d')}\n";
            echo "Estado: {$proyecto->getEstado()}\n";
            echo "-------------------------\n";
        }
    }
    
    public function listarProyectosPorNombre() {
        $proyectos = $this->cargarDesdeJson(); // Cargar todos los proyectos
    
        if (empty($proyectos)) {
            echo "No hay proyectos disponibles.\n";
            return;
        }
    
        usort($proyectos, function($a, $b) {
            return strcmp($a->getNombre(), $b->getNombre());  // Ordenar por nombre
        });
    
        echo "=== Lista de Proyectos Ordenados por Nombre ===\n";
        foreach ($proyectos as $proyecto) {
            echo "ID: {$proyecto->getId_proyecto()}\n";
            echo "Nombre: {$proyecto->getNombre()}\n";
            echo "Descripción: {$proyecto->getDescripcion()}\n";
            echo "Fecha de Inicio: {$proyecto->getFechaInicio()->format('Y-m-d')}\n";
            echo "Fecha de Fin: {$proyecto->getFechaFin()->format('Y-m-d')}\n";
            echo "Estado: {$proyecto->getEstado()}\n";
            echo "-------------------------\n";
        }
    }
    
    public function listarProyectosPorFechaInicio() {
        $proyectos = $this->cargarDesdeJson(); // Cargar todos los proyectos
    
        if (empty($proyectos)) {
            echo "No hay proyectos disponibles.\n";
            return;
        }
    
        usort($proyectos, function($a, $b) {
            return strtotime($a->getFechaInicio()->format('Y-m-d')) <=> strtotime($b->getFechaInicio()->format('Y-m-d'));  // Ordenar por fecha de inicio
        });
    
        echo "=== Lista de Proyectos Ordenados por Fecha de Inicio ===\n";
        foreach ($proyectos as $proyecto) {
            echo "ID: {$proyecto->getId_proyecto()}\n";
            echo "Nombre: {$proyecto->getNombre()}\n";
            echo "Descripción: {$proyecto->getDescripcion()}\n";
            echo "Fecha de Inicio: {$proyecto->getFechaInicio()->format('Y-m-d')}\n";  // Corregido
            echo "Fecha de Fin: {$proyecto->getFechaFin()->format('Y-m-d')}\n";        // Corregido
            echo "Estado: {$proyecto->getEstado()}\n";
            echo "-------------------------\n";
        }
    }
    
    public function listarProyectosPorFechaFin() {
        $proyectos = $this->cargarDesdeJson(); // Cargar todos los proyectos
    
        if (empty($proyectos)) {
            echo "No hay proyectos disponibles.\n";
            return;
        }
    
        usort($proyectos, function($a, $b) {
            return strtotime($a->getFechaFin()->format('Y-m-d')) <=> strtotime($b->getFechaFin()->format('Y-m-d'));  // Ordenar por fecha de fin
        });
    
        echo "=== Lista de Proyectos Ordenados por Fecha de Fin ===\n";
        foreach ($proyectos as $proyecto) {
            echo "ID: {$proyecto->getId_proyecto()}\n";
            echo "Nombre: {$proyecto->getNombre()}\n";
            echo "Descripción: {$proyecto->getDescripcion()}\n";
            echo "Fecha de Inicio: {$proyecto->getFechaInicio()->format('Y-m-d')}\n";
            echo "Fecha de Fin: {$proyecto->getFechaFin()->format('Y-m-d')}\n";
            echo "Estado: {$proyecto->getEstado()}\n";
            echo "-------------------------\n";
        }
    }
    
    public function listarProyectosPorEstado() {
        $proyectos = $this->cargarDesdeJson(); // Cargar todos los proyectos
    
        if (empty($proyectos)) {
            echo "No hay proyectos disponibles.\n";
            return;
        }
    
        usort($proyectos, function($a, $b) {
            return strcmp(strtolower($a->getEstado()), strtolower($b->getEstado()));  // Ordenar por estado (en minúsculas)
        });
    
        echo "=== Lista de Proyectos Ordenados por Estado ===\n";
        foreach ($proyectos as $proyecto) {
            echo "ID: {$proyecto->getId_proyecto()}\n";
            echo "Nombre: {$proyecto->getNombre()}\n";
            echo "Descripción: {$proyecto->getDescripcion()}\n";
            echo "Fecha de Inicio: {$proyecto->getFechaInicio()->format('Y-m-d')}\n";
            echo "Fecha de Fin: {$proyecto->getFechaFin()->format('Y-m-d')}\n";
            echo "Estado: {$proyecto->getEstado()}\n";
            echo "-------------------------\n";
        }
    }
     // Agregar un proyecto al gestor
     public function agregarProyecto($proyecto) {
        $this->proyectos[] = $proyecto;
    }
      // Listar tareas de un proyecto
      public function listarTareasPorProyecto($id_proyecto) {
        $proyecto = null;
        foreach ($this->proyectos as $p) {
            if ($p->getId_proyecto() == $id_proyecto) {
                $proyecto = $p;
                break;
            }
        }

        if (!$proyecto) {
            echo "Proyecto con ID {$id_proyecto} no encontrado.\n";
            return;
        }

        // Usamos el GestorTarea para obtener las tareas asociadas a este proyecto
        $tareas = $this->gestorTarea->getTareasPorProyecto($id_proyecto);
        
        if (empty($tareas)) {
            echo "No hay tareas asociadas a este proyecto.\n";
            return;
        }

        echo "=== Tareas del Proyecto: {$proyecto->getNombre()} ===\n";
        foreach ($tareas as $tarea) {
            echo "ID Tarea: {$tarea->getIdTarea()}\n";
            echo "Nombre: {$tarea->getNombre()}\n";
            echo "Descripción: {$tarea->getDescripcion()}\n";
            echo "Fecha de Inicio: {$tarea->getFechaInicio()->format('Y-m-d')}\n";
            echo "Fecha de Fin: {$tarea->getFechaFin()->format('Y-m-d')}\n";
            echo "-------------------------\n";
        }
    }
         // Método privado para buscar un proyecto por su ID
    private function buscarProyectoPorId($id_proyecto) {
        foreach ($this->proyectos as $proyecto) {
            if ($proyecto->getId_proyecto() == $id_proyecto) {
                return $proyecto;
            }
        }
        return null;  // Si no se encuentra el proyecto
    }


    // Editar un proyecto
    public function editarProyecto($id_proyecto) {
        // Buscar el proyecto con el ID proporcionado
        $proyecto = null;
        foreach ($this->proyectos as $p) {
            if ($p->getId_proyecto() == $id_proyecto) {
                $proyecto = $p;
                break;
            }
        }
    
        if (!$proyecto) {
            echo "Proyecto con ID {$id_proyecto} no encontrado.\n";
            return;
        }
    
        // Mostrar los detalles actuales del proyecto
        echo "Proyecto encontrado:\n";
        echo "ID: {$proyecto->getId_proyecto()}\n";
        echo "Nombre: {$proyecto->getNombre()}\n";
        echo "Descripción: {$proyecto->getDescripcion()}\n";
        echo "Fecha de Inicio: {$proyecto->getFechaInicio()->format('Y-m-d')}\n";
        echo "Fecha de Fin: {$proyecto->getFechaFin()->format('Y-m-d')}\n";
        echo "Estado: {$proyecto->getEstado()}\n";
    
        // Preguntar qué campo desea editar
        echo "¿Qué campo desea editar?\n";
        echo "1. Nombre\n";
        echo "2. Descripción\n";
        echo "3. Fecha de Inicio\n";
        echo "4. Fecha de Fin\n";
        echo "5. Estado\n";
        echo "0. Volver\n";
        
        $opcion = trim(fgets(STDIN));
    
        switch ($opcion) {
            case '1':
                echo "Ingrese el nuevo nombre del proyecto: ";
                $nuevoNombre = trim(fgets(STDIN));
                $proyecto->setNombre($nuevoNombre);
                echo "Nombre actualizado.\n";
                break;
            case '2':
                echo "Ingrese la nueva descripción del proyecto: ";
                $nuevaDescripcion = trim(fgets(STDIN));
                $proyecto->setDescripcion($nuevaDescripcion);
                echo "Descripción actualizada.\n";
                break;
            case '3':
                echo "Ingrese la nueva fecha de inicio (formato: Y-m-d): ";
                $nuevaFechaInicio = trim(fgets(STDIN));
                $proyecto->setFechaInicio(new DateTime($nuevaFechaInicio));
                echo "Fecha de inicio actualizada.\n";
                break;
            case '4':
                echo "Ingrese la nueva fecha de fin (formato: Y-m-d): ";
                $nuevaFechaFin = trim(fgets(STDIN));
                $proyecto->setFechaFin(new DateTime($nuevaFechaFin));
                echo "Fecha de fin actualizada.\n";
                break;
            case '5':
                echo "Ingrese el nuevo estado del proyecto: ";
                $nuevoEstado = trim(fgets(STDIN));
                $proyecto->setEstado($nuevoEstado);
                echo "Estado actualizado.\n";
                break;
            case '0':
                echo "Volviendo al menú anterior...\n";
                return;
            default:
                echo "Opción no válida.\n";
                break;
        }
    
        // Guardar los cambios en el archivo JSON
        $this->guardarEnJSON();
    }
    
    public function eliminarProyecto($id_proyecto) {
        $indiceProyecto = null;
        foreach ($this->proyectos as $key => $proyecto) {
            if ($proyecto->getId_proyecto() == $id_proyecto) {
                $indiceProyecto = $key;
                break;
            }
        }
    
        if ($indiceProyecto === null) {
            echo "Proyecto con ID {$id_proyecto} no encontrado.\n";
            return;
        }
    
        // Eliminar el proyecto del array
        unset($this->proyectos[$indiceProyecto]);
        $this->proyectos = array_values($this->proyectos); // Reindexar el array
    
        echo "Proyecto eliminado exitosamente.\n";
        $this->guardarEnJSON();
    }
    
    public function cargarDesdeJson() {
        // Cargar proyectos desde el archivo JSON
        if (file_exists($this->archivoJson)) {
            $contenidoJson = file_get_contents($this->archivoJson);
            $data = json_decode($contenidoJson, true); // Decodificar JSON en un array asociativo

            if (isset($data['proyecto'])) {
                $this->proyectos = [];
                foreach ($data['proyecto'] as $proyectoData) {
                    // Verificar si el proyecto tiene tareas y cargarlas correctamente
                    $tareas = [];
                    if (isset($proyectoData['tareas']) && is_array($proyectoData['tareas'])) {
                        foreach ($proyectoData['tareas'] as $idTarea) {
                            $tarea = $this->gestorTarea->buscarTareaPorId($idTarea); // Buscar tarea por ID
                            if ($tarea) {
                                $tareas[] = $tarea; // Asignar la tarea al proyecto
                            }
                        }
                    }

                    // Crear el objeto Proyecto, pasando las tareas cargadas
                    $this->proyectos[] = new Proyecto(
                        $proyectoData['id_proyecto'],
                        $proyectoData['nombre'],
                        $proyectoData['descripcion'],
                        new DateTime($proyectoData['fechaInicio']),
                        new DateTime($proyectoData['fechaFin']),
                        $proyectoData['estado'],
                        $tareas // Pasar las tareas como un array de objetos Tarea
                    );
                }
            }
        }
    }
   
    // Guardar los proyectos en el archivo JSON
    public function guardarEnJSON() {
        $proyectos = [];

        foreach ($this->proyectos as $proyecto) {
            // Obtener solo los IDs de las tareas asociadas
            $tareasIds = [];
            foreach ($proyecto->getTareas() as $tarea) {
                $tareasIds[] = $tarea->getIdTarea(); // Obtener el ID de la tarea
            }

            // Convertir cada proyecto a un array
            $proyectos[] = [
                'id_proyecto' => $proyecto->getId_proyecto(),
                'nombre' => $proyecto->getNombre(),
                'descripcion' => $proyecto->getDescripcion(),
                'fechaInicio' => $proyecto->getFechaInicio()->format('Y-m-d'),
                'fechaFin' => $proyecto->getFechaFin()->format('Y-m-d'),
                'estado' => $proyecto->getEstado(),
                'tareas' => $tareasIds // Guardar solo los IDs de las tareas
            ];
        }

        // Convertir el array de proyectos a JSON y guardarlo en el archivo
        $jsonProyectos = json_encode(['proyecto' => $proyectos], JSON_PRETTY_PRINT);
        file_put_contents($this->archivoJson, $jsonProyectos);
    }
    public function agregarTareaAlProyecto($id_proyecto, $nuevaTarea) {
        foreach ($this->proyectos as $proyecto) {
            if ($proyecto->getId_proyecto() == $id_proyecto) {
                $proyecto->agregarTarea($nuevaTarea); // Usar un método para agregar la tarea al proyecto
                break;
            }
        }
    
        // Guardar el archivo 'proyecto.json' actualizado
        $this->guardarEnJSON();
    }
    public function eliminarTareaDeProyecto($id_proyecto, $id_tarea) {
        foreach ($this->proyectos as $proyecto) {
            if ($proyecto->getId_proyecto() == $id_proyecto) {
                $proyecto->eliminarTarea($id_tarea); // Método para eliminar la tarea del proyecto
                break;
            }
        }
    
        // Guardar el archivo 'proyecto.json' actualizado
        $this->guardarEnJSON();
    }
    public function actualizarFechaFinProyecto($id_proyecto) {
        // Buscar el proyecto
        $proyecto = null;
        foreach ($this->proyectos as $p) {
            if ($p->getId_proyecto() == $id_proyecto) {
                $proyecto = $p;
                break;
            }
        }
    
        if ($proyecto) {
            // Recalcular la fecha de fin del proyecto según las tareas
            $fechaFinMaxima = new DateTime('1970-01-01');  // Fecha mínima posible
            foreach ($this->gestorTarea->getTareasPorProyecto($id_proyecto) as $tarea) {
                if ($tarea->getFechaFin() > $fechaFinMaxima) {
                    $fechaFinMaxima = $tarea->getFechaFin();
                }
            }
    
            // Actualizar la fecha de fin del proyecto
            $proyecto->setFechaFin($fechaFinMaxima);
            $this->guardarEnJSON();  // Guardar cambios en proyecto.json
    
            echo "Fecha de fin del proyecto actualizada: " . $fechaFinMaxima->format('Y-m-d') . "\n";
        } else {
            echo "Proyecto con ID {$id_proyecto} no encontrado.\n";
        }
    }
    

   
}
    
    


