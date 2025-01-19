<?php
require_once './gestor/GestorUsuario.php';
require_once './gestor/GestorTarea.php';
require_once './gestor/GestorProyecto.php';

class Menu {
    protected $gestorUsuario;
    protected $gestorProyecto;
    protected $gestorTarea;

    public function __construct($gestorUsuario, $gestorProyecto, $gestorTarea) {
        $this->gestorUsuario = $gestorUsuario;
        $this->gestorProyecto = $gestorProyecto;
        $this->gestorTarea = $gestorTarea;
    }

    public function iniciar() {
        while (true) {
            echo "=== Bienvenido ===\n";
            echo "1. Ingresar \n";
            echo "2. Registrarse\n";
            echo "0. Salir\n";

            $eleccion = trim(fgets(STDIN));

            switch ($eleccion) {
                case '1':
                    if ($this->gestorUsuario->validarUsuario()) {
                        $this->menuPrincipal(); 
                    } else {
                        echo "Validación fallida. Intente nuevamente.\n";
                    }
                    break;

                case '2':
                    $this->gestorUsuario->crearUsuario();
                    break;

                case '0':
                    echo "Saliendo del sistema...\n";
                    return; 

                default:
                    echo "Opción no válida. Inténtelo de nuevo.\n";
                    break;
            }
        }
    }

    public function menuPrincipal() {
        echo "=== Menú principal ===\n";
        while (true) {
            echo "1. Menú Usuario\n";
            echo "2. Menú Proyecto\n";
            echo "3. Menú Tarea\n";
            echo "0. Salir al Menú inicial\n";

            $eleccion = trim(fgets(STDIN));

            switch ($eleccion) {
                case '1':
                    $this->menuUsuario();
                    break;
                case '2':
                    $this->menuProyecto();
                    break;
                case '3':
                    $this->menuTarea();
                    break;
                case '0':
                    return; 
                default:
                    echo "Opción no válida. Inténtelo de nuevo.\n";
                    break;
            }
        }
    }

    public function menuUsuario() {
        echo "=== Menú de Usuario ===\n";
        while (true) {
            echo "1. Listar Usuarios\n";
            echo "2. Editar Usuario\n";
            echo "3. Eliminar Usuario\n";
            echo "0. Salir al Menú Principal\n";

            $eleccion = trim(fgets(STDIN));

            switch ($eleccion) {
                case '1':
                    $this->gestorUsuario->listarUsuarios();
                    break;
                case '2':
                    $this->gestorUsuario->editarUsuario();
                    break;
                case '3':
                    $this->gestorUsuario->eliminarUsuario();
                    break;
                case '0':
                    return; 
                default:
                    echo "Opción no válida. Inténtelo de nuevo.\n";
                    break;
            }
        }
    }

    public function menuProyecto() {
        echo "=== Menú de Proyecto ===\n";
        while (true) {
            echo "1. Crear Proyecto\n";
            echo "2. Listar Proyectos\n";
            echo "3. Editar Proyecto\n";
            echo "4. Eliminar Proyecto\n";
            echo "0. Salir al Menú Principal\n";

            $eleccion = trim(fgets(STDIN));

            switch ($eleccion) {
                case '1':
                    $this->gestorProyecto->agregarProyecto();
                    break;
                case '2':
                    $this->gestorProyecto->menuListarProyecto();
                    break;
                case '3':
                    $this->gestorProyecto->editarProyecto();
                    break;
                case '4':
                    $this->gestorProyecto->eliminarProyecto();
                    break;
                case '0':
                    return; 
                default:
                    echo "Opción no válida. Inténtelo de nuevo.\n";
                    break;
            }
        }
    }

    // Menú para gestionar tareas dentro de un proyecto
    public function menuTarea() {
        echo "=== Menú de Tareas ===\n";
        echo "1. Crear Tarea\n";
        echo "2. Listar Tareas\n";
        echo "3. Editar Tarea\n";
        echo "4. Eliminar Tarea\n";
        echo "5. Calcular Camino Crítico\n";
        echo "0. Salir al Menú Principal\n";
        
        $opcion = trim(fgets(STDIN));
    
        switch ($opcion) {
            case '1': 
                $this->crearTarea();
                break;
            case '2':
                $this->listarTareas();
                break;
            case '3':
                $this->editarTarea();
                break;
            case '4':
                $this->eliminarTarea();
                break;
            case '5':
                $this->calcularCaminoCritico();
                break;
            case '0':
                return;
            default:
                echo "Opción no válida. Inténtelo de nuevo.\n";
                break;
        }
    }
    
    private function crearTarea($proyecto) {
        // Primero aseguramos que hay proyectos disponibles
        if (empty($this->gestorTarea->$proyectos)) {
            echo "No hay proyectos disponibles. No se puede crear una tarea.\n";
            return;
        }
    
        // Mostrar los proyectos disponibles para que el usuario elija uno
        echo "Seleccione un proyecto para asignar la tarea:\n";
        foreach ($this->gestorTarea->proyectos as $index => $proyecto) {
            echo ($index + 1) . ". " . $proyecto->getNombre() . "\n";
        }
        echo "Ingrese el número del proyecto: ";
        $opcionProyecto = trim(fgets(STDIN));
    
        // Validar que la opción elegida es válida
        if ($opcionProyecto < 1 || $opcionProyecto > count($this->gestorTarea->proyectos)) {
            echo "Opción no válida. Inténtelo de nuevo.\n";
            return;
        }
    
        // Obtener el proyecto elegido
        $proyectoSeleccionado = $this->gestorTarea->proyectos[$opcionProyecto - 1];
    
        // Llamar al método para agregar la tarea al proyecto seleccionado
        $this->gestorTarea->agregarTarea($proyectoSeleccionado);
    }
    
    
    public function menuListarProyecto() {
        echo "=== Menú listar proyectos ===\n";
        while (true) {
            echo "1. Listar todos los proyectos\n";
            echo "2. Listar proyecto por ID\n";
            echo "3. Listar proyectos activos\n";
            echo "4. Listar proyectos terminados\n";
            echo "0. Volver al menú proyectos\n";

            $eleccion = trim(fgets(STDIN));

            switch ($eleccion) {
                case '1':
                    $this->gestorProyecto->listarProyectos();
                    break;
                case '2':
                    $this->gestorProyecto->listarProyectoPorId();
                    break;
                case '3':
                    $this->gestorProyecto->listarProyectoActivo();
                    break;
                case '4':
                    $this->gestorProyecto->listarProyectoInactivo();
                    break;
                case '0':
                    return; 
                default:
                    echo "Opción no válida. Inténtelo de nuevo.\n";
                    break;
            }
        }
    }
}

// Crear instancias de los gestores y menú
$gestorUsuario = new GestorUsuario();
$gestorTarea = new GestorTarea();
$gestorProyecto = new GestorProyecto($gestorTarea);
$menu = new Menu($gestorUsuario, $gestorProyecto, $gestorTarea);
$menu->iniciar();
