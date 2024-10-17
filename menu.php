<?php
require_once 'GestorUsuario.php';
require_once 'GestorTarea.php';
require_once 'GestorComentario.php';
require_once 'estado.php';
require_once 'GestorProyecto.php';
require_once 'funcionesAuxiliares.php';


class Menu {
        private $usuarios = [];
        
        public function iniciar() {
            $clave = 9876; 
            while (true) {
                echo "===Bienvenido===\n";
                echo "1. Ingresar\n";
                echo "2. Registrarse\n";
                echo "3. Salir\n";
        
                $eleccion = trim(fgets(STDIN));
        
                switch ($eleccion) {
                    case '1':  
                         $this->menuUsuario(); //validarIngresoUsuario();
                        break;
        
                    case '2':
                        $this->crearUsuario(); 
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
    

    

      //----------------------------------------Menu  Usuario-----------------------------------------
        public function menuUsuario() {
            echo "=== Menú de Usuario ===\n";
            while (true) {
                echo "1. Crear Proyecto\n";
                echo "2. Listar Proyectos\n";
                echo "3. Editar Proyecto\n";
                echo "4. Eliminar proyecto\n";
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

    $menu = new Menu();
    $menu->iniciar();
