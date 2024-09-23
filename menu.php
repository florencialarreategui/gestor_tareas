<?php
include_once 'Usuario.php';
include_once 'proyecto.php';
include_once 'tarea.php';
include_once 'comentario.php';
include_once 'estado.php';
include_once 'GestorProyecto.php';

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

    public function crearProyecto() {
        echo "Ingrese el nombre del proyecto: ";
        $nombre = trim(fgets(STDIN));

        echo "Ingrese la fecha de inicio (YYYY-MM-DD): ";
        $fechaInicio = trim(fgets(STDIN));

        echo "Ingrese la fecha de finalización (YYYY-MM-DD): ";
        $fechaFin = trim(fgets(STDIN));

        $nuevoProyecto = new Proyecto($nombre, $fechaInicio, $fechaFin);
        $this->proyectos[] = $nuevoProyecto;

        echo "Proyecto creado exitosamente: " . $nuevoProyecto->getNombre() . "\n";
    }

    public function listarProyectos() {
        if (empty($this->proyectos)) {
            echo "No hay proyectos registrados.\n";
            return;
        }

        echo "=== Proyectos Registrados ===\n";
        foreach ($this->proyectos as $proyecto) {
            echo "Nombre: " . $proyecto->getNombre() . ", Fecha de Inicio: " . $proyecto->getFechaInicio() . ", Fecha de Finalización: " . $proyecto->getFechaFin() . "\n";
        }
    }


    public function crearUsuario() {
        echo "Ingrese ID de usuario: ";
        $id_usuario = trim(fgets(STDIN));

        echo "Ingrese nombre: ";
        $nombre = trim(fgets(STDIN));

        echo "Ingrese email: ";
        $email = trim(fgets(STDIN));

        // Crear un nuevo usuario
        $nuevoUsuario = new Usuario($id_usuario, $nombre, $email);

        // Almacenar el nuevo usuario en el array
        $this->usuarios[] = $nuevoUsuario;

        echo "Usuario creado exitosamente: " . $nuevoUsuario->getNombre() . "\n";
    }
}


$menu = new Menu();
$menu->iniciar();
