<?php
require_once './gestor/GestorUsuario.php';
require_once './gestor/GestorProyecto.php';
require_once './gestor/GestorTarea.php';

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
            echo "0. Salir al Menú inicial\n";

            $eleccion = trim(fgets(STDIN));

            switch ($eleccion) {
                case '1':
                    $this->menuUsuario();
                    break;
                case '2':
                    $this->menuProyecto();
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
            echo "5. Crear Tarea\n";
            echo "6. Listar Tareas de Proyecto\n";
            echo "7. Calcular Camino Crítico\n";
            echo "0. Salir al Menú Principal\n";
    
            $eleccion = trim(fgets(STDIN));
    
            switch ($eleccion) {
                case '1':
                    $this->gestorProyecto->agregarProyecto();
                    break;
                case '2':
                    $this->gestorProyecto->listarProyectos();
                    break;
                case '3':
                    $this->gestorProyecto->editarProyecto();
                    break;
                case '4':
                    $this->gestorProyecto->eliminarProyecto();
                    break;
                case '5':
                    // Pasar $gestorProyecto a la función crearTarea
                    $this->gestorTarea->crearTarea($this->gestorProyecto);
                    break;
                case '6':
                    $this->gestorProyecto->listarTareasDelProyecto();
                    break;
                case '7':
                    $this->gestorProyecto->calcularCaminoCritico();
                    break;
                case '0':
                    return; 
                default:
                    echo "Opción no válida. Inténtelo de nuevo.\n";
                    break;
            }
        }
    }
    

// Crear instancias de los gestores y menú
$gestorUsuario = new GestorUsuario(); 
$gestorTarea = new GestorTarea(); // El gestor de tareas sigue existiendo
$gestorProyecto = new GestorProyecto($gestorTarea); 
$menu = new Menu($gestorUsuario, $gestorProyecto, $gestorTarea);
$menu->iniciar(); 



