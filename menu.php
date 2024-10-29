<?php
require_once './gestor/GestorUsuario.php';
require_once './gestor/GestorTarea.php';
require_once './gestor/GestorComentario.php';
require_once './gestor/GestorProyecto.php';
require_once './gestor/GestorEstado.php';



class Menu {
protected $gestorUsuario;
 public function __construct($gestorUsuario,$gestorProyecto,$gestorTarea){
    $this->gestorUsuario= $gestorUsuario;
    $this->gestorProyecto=$gestorProyecto;
    $this->gestorTarea = $gestorTarea;

 }

        public function iniciar() {

            while (true) {
                echo "===Bienvenido===\n";
                echo "1. Ingresar \n";
                echo "2. Registrarse\n";
                echo "0. Salir\n";
        
                $eleccion = trim(fgets(STDIN));
        
                switch ($eleccion) {
                    case '1':  
                        // if ($this->validarIngresoUsuario()) {
                            $this->menuPrincipal(); // Llama al menú de usuario si la validación es correcta
                        // } else {
                        //     echo "Validación fallida. Intente nuevamente.\n";
                        // }
                        // break;
        
                    case '2':
                        $this->crearUsuario(); //validarIngresoUsuario();
                        break;
        
                        case '0':
                            echo "Saliendo del sistema...\n";
                            exit;
        
                    default:
                        echo "Opción no válida. Inténtelo de nuevo.\n";
                        break;
                }
            }
        }
    //-----------------------------------------Menu principal-----------------------------------------
    public function menuPrincipal() {
        echo "=== Menú principal ===\n";
        while (true) {
            echo "1. Menu Usuario\n";
            echo "2. Menu proyecto\n";
            echo "3. Menu Tarea\n";
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

    

      //----------------------------------------Menu  Usuario-----------------------------------------

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

    //------------------------------------Menu Proyecto-------------------------------------------
        public function menuProyecto() {
            echo "=== Menú de Proyecto ===\n";
            while (true) {
                echo "1. Crear Proyecto\n";
                echo "2. Listar Proyectos\n";
                echo "3. Editar Proyecto\n";
                echo "4. Eliminar proyecto\n";
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
                    case '0':
                        return; 
                    default:
                        echo "Opción no válida. Inténtelo de nuevo.\n";
                        break;
                }
            }
        }

         //------------------------------------Menu Tarea-------------------------------------------
         public function menuTarea() {
            echo "=== Menú de Tareas ===\n";
            while (true) {
                echo "1. Agregar tarea a un Proyecto\n";
                echo "2. Listar Tareas\n";
                echo "3. Editar Tarea\n";
                echo "4. Eliminar Tarea\n";
                echo "0. Salir al Menú de Proyecto\n";

                $eleccion = trim(fgets(STDIN));

                switch ($eleccion) {
                    case '1':
                        $this->gestorTarea->agregarTarea();
                        break;
                    case '2':
                        $this->gestorTarea->listarTareas();
                        break;
                     case '3':
                        $this->gestorTarea->editarTarea();
                        break;
                     case '4':
                        $this->gestorTarea->eliminarTarea();
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
    $gestorUsuario = new GestorUsuario();
    $gestorProyecto = new GestorProyecto();
    $gestorTarea = new GestorTarea();
    $menu = new Menu($gestorUsuario, $gestorProyecto, $gestorTarea);
    $menu->iniciar();
