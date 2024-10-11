<?php
require_once 'usuario.php';
require_once 'proyecto.php';
require_once 'tarea.php';
require_once 'comentario.php';
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
                        echo "Ingrese la clave: ";
                        $claveUsuario = trim(fgets(STDIN));
                        if ($clave == $claveUsuario) {
                            $this->menuUsuario(); 
                        } else {
                            echo "Clave Errónea.\n";
                        }
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

        public function menuUsuario() {
            echo "=== Menú de Usuario ===\n";
            while (true) {
                echo "1. Crear Proyecto\n";
                echo "2. Listar Proyectos\n";
                echo "3. Salir al Menú Principal\n";

                $eleccion = trim(fgets(STDIN));

                switch ($eleccion) {
                    case '1':
                        $this->crearProyecto();
                        break;
                    case '2':
                        $this->listarProyectos();
                        break;
                    case '3':
                        return; 
                    default:
                        echo "Opción no válida. Inténtelo de nuevo.\n";
                        break;
                }
            }
        }

        //-----------------------------crear proyectos----------------------------

        public function crearProyecto() {

            $id_proyecto = generarIdNumerico();
            
            echo "Ingrese el nombre del proyecto: ";
            $nombre = trim(fgets(STDIN));

            echo "Ingrese el descripción del proyecto: ";
            $descripcion = trim(fgets(STDIN));

            echo "Ingrese la fecha de inicio (YYYY-MM-DD): ";
            $fechaInicio = trim(fgets(STDIN));

            echo "Ingrese la fecha de finalización (YYYY-MM-DD): ";
            $fechaFin = trim(fgets(STDIN));

            $nuevoProyecto = new Proyecto($id_proyecto, $nombre, $descripcion, $fechaInicio, $fechaFin);
            $this->proyectos[] = $nuevoProyecto;

            echo "Proyecto creado exitosamente: " . $nuevoProyecto->getNombre() . "\n". $id_proyecto;
        }
//-----------------------------listar proyectos----------------------------
        public function listarProyectos() {
            if (empty($this->proyectos)) {
                echo "No hay proyectos registrados.\n";
                return;
            }

            echo "=== Proyectos Registrados ===\n";
            foreach ($this->proyectos as $proyecto) {
                echo "Id: " . $proyecto->getIdProyecto() . "Nombre: " . $proyecto->getNombre() . ", Fecha de Inicio: " . $proyecto->getFechaInicio() . ", Fecha de Finalización: " . $proyecto->getFechaFin() . "\n";
            }
        }

//-----------------------------crear usurario ---------------------------
        public function crearUsuario() {
            $id_usuario = generarIdNumerico();

            echo "Ingrese nombre: ";
            $nombre = trim(fgets(STDIN));

            echo "Ingrese email: ";
            $email = trim(fgets(STDIN));

            echo "Ingrese clave: ";
            $clave = trim(fgets(STDIN));

          
            // Crear un nuevo usuario
            $nuevoUsuario = new Usuario($id_usuario, $nombre, $email, $clave);

            // Almacenar el nuevo usuario en el array
            $this->usuarios[] = $nuevoUsuario;

            echo "Usuario creado exitosamente: " . $nuevoUsuario->getNombre() . " con ID" .  $nuevoUsuario->getId_usuario() . "\n";
        }

        //-----------------------------listar usuarios----------------------------
        public function listarUsuarios() {
            if (empty($this->usuarios)) {
                echo "No hay usuarios registrados.\n";
                return;
            }

            echo "=== Proyectos Registrados ===\n";
            foreach ($this->usuarios as $usuario) {
                echo "Id: " . $nuevoUsuario->getId_usuario() . "Nombre: " . $nuevoUsuario->getNombre(). "\n";
            }
        }
    }


    $menu = new Menu();
    $menu->iniciar();
