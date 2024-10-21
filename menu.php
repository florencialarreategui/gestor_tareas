<?php
require_once 'GestorUsuario.php';
require_once 'GestorTarea.php';
require_once 'GestorComentario.php';
require_once 'GestorProyecto.php';
require_once 'GestorEstado.php';



class Menu {
        public function iniciar() {
//llamo a un metodo que cargo todos los datos de usuarios

            while (true) {
                echo "===Bienvenido===\n";
                echo "1. Ingresar \n";
                echo "2. Registrarse\n";
                echo "3. Salir\n";
        
                $eleccion = trim(fgets(STDIN));
        
                switch ($eleccion) {
                    case '1':  
                        if ($this->validarIngresoUsuario()) {
                            $this->menuPrincipal(); // Llama al menú de usuario si la validación es correcta
                        } else {
                            echo "Validación fallida. Intente nuevamente.\n";
                        }
                        break;
        
                    case '2':
                        $this->crearUsuario(); //validarIngresoUsuario();
                        break;
        
                        case '3':
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
        //
        echo "=== Menú principal ===\n";
        while (true) {
            echo "1. Menu Usuario\n";
            echo "2. Menu proyecto\n";
            echo "3. Salir al Menú inicial\n";

            $eleccion = trim(fgets(STDIN));

            switch ($eleccion) {
                case '1':
                    $this->menuUsuario();
                    break;
                 case '2':
                      $this->menuProyecto();
                    break;
                 case '3':
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
            echo "4. Salir al Menú Principal\n";

            $eleccion = trim(fgets(STDIN));

            switch ($eleccion) {
                case '1':
                    $this->listarUsuarios();
                    break;
                 case '2':
                      $this->editarUsuario();
                    break;
                 case '3':
                     $this->eliminarUsuario();
                    break;
                case '4':
                    return; 
                default:
                    echo "Opción no válida. Inténtelo de nuevo.\n";
                    break;
            }
        }
    }
// previo a ingresar al menu proyectos deberiamos cargar los datos 
    //------------------------------------Menu Proyecto-------------------------------------------
        public function menuProyecto() {
            echo "=== Menú de Proyecto ===\n";
            while (true) {
                echo "1. Crear Proyecto\n";
                echo "2. Listar Proyectos\n";
                // una vez que listo pregunto que proyecto quiero abrir y lo abro por id y ahi ejecuto las funciones de tareas 
                echo "3. Editar Proyecto\n";
                echo "4. Eliminar proyecto\n";
                //opcion abrir proyecto, cuando se abre ese proyecto queda en un estado activo con una variable global, puede ser una especie de singleton 
                //creo una opcion para agregar una tarea a un proyecto podemos hacer un menu tarea y me pregunta en que proyecto quiero agregar esa tarea 
                // arreglo de proyecto que almacena tarea 
                //un arreglo ue se compone de objetos tareas
                echo "5. Salir al Menú Principal\n";

                $eleccion = trim(fgets(STDIN));

                switch ($eleccion) {
                    case '1':
                        $this->crearProyecto();
                        break;
                    case '2':
                        $this->listarProyectos();
                        break;
                     case '3':
                          $this->editarProyecto();
                        break;
                     case '4':
                         $this->eliminarProyecto();
                        break;
                    case '5':
                        return; 
                    default:
                        echo "Opción no válida. Inténtelo de nuevo.\n";
                        break;
                }
            }
        }

        

    }
    // funcion cargar datos de usuarios primero 

    $menu = new Menu();
    $menu->iniciar();
    
