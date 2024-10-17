<?php
require_once 'usuario.php';
require_once 'funcionesAuxiliares.php';
// require_once 'menu.php';

class GestorUsuario{
    private $usuarios = [];
    //----------------------------------------Validacion Usuario-----------------------------------------

    public function validarIngresoUsuario ($nombreUsuario,$claveUsuario) {
        echo "Si ya se encuentra registrado ingrese su nombre: ";
             $nombreUsuarioIngresado = trim(fgets(STDIN));
             echo "Si ya se encuentra registrado ingrese su clave: ";
             $claveUsuarioIngresada = trim(fgets(STDIN));
                        if ($claveUsuario == $claveUsuarioIngresada && $nombreUsuario == $nombreUsuarioIngresado) {
                            echo "ingresaste"; // $this->menuUsuario(); 
                        } else {
                            echo "Nombre o clave incorrecta.\n";
                        }
    }
 
    // //-----------------------------crear usurario ---------------------------
    public function crearUsuario() {
        $id_usuario = generarIdNumerico();

        echo "Ingrese nombre: ";
        $nombre = trim(fgets(STDIN));

        echo "Ingrese email: ";
        $email = trim(fgets(STDIN));

        echo "Ingrese clave: ";
        $clave = trim(fgets(STDIN));

      
        // Crear un nuevo usuario
        $nuevoUsuario = new usuario($id_usuario, $nombre, $email, $clave);

        // Almacenar el nuevo usuario en el array
        $this->usuarios[] = $nuevoUsuario;

        echo "Usuario creado exitosamente: " . $nuevoUsuario->getNombre() . " con ID" .  $nuevoUsuario->getId_usuario() . "\n";
    }

    // //-----------------------------listar usuarios----------------------------
    public function listarUsuarios() {
        if (empty($this->usuarios)) {
            echo "No hay usuarios registrados.\n";
            return;
        }

        echo "=== Usuarios Registrados ===\n";
        foreach ($this->usuarios as $usuario) {
            echo "Id: " . $usuario->getId_usuario() . "\n". " Nombre: " . $usuario->getNombre(). "\n". " Email: " . $usuario->getEmail(). "\n";
        }
    }

    // //-----------------------------editar usurario ---------------------------
    public function editarUsuario() {
        echo "Ingrese el nombre del usuario que desea editar: ";
        $nombre = trim(fgets(STDIN));
    
        echo "Ingrese la clave del usuario que desea editar: ";
        $clave = trim(fgets(STDIN));
        // Buscar el proyecto por ID
        
        foreach ($this->usuarios as $usuario) {
            if ($usuario->getNombre() == $nombre && $usuario->getClave()==$clave) {
                echo "Ingrese el nuevo nombre del usuario: ";
                 $nombre = trim(fgets(STDIN));
                 $usuario->setNombre($nombre);

                 echo "Ingrese el nuevo email: ";
                 $email = trim(fgets(STDIN));
                $usuario->setEmail($email);

                echo "Ingrese una nueva clave: ";
                 $clave = trim(fgets(STDIN));
                $usuario->setClave($clave);
            }
        }
    
        echo "Usuario editado exitosamente: " . $usuario->getNombre() . "\n";
    }


    // //-----------------------------eliminar usurario---------------------------
    public function eliminarUsuario() {
        echo "Ingrese el nombre del usuario que desea eliminar: ";
        $nombreIngresado = trim(fgets(STDIN));
    
        echo "Ingrese la clave del usuario que desea eliminar: ";
        $claveIngresada = trim(fgets(STDIN));
    
        // Buscar el índice del usuario por nombre y clave
        $indiceUsuarios = null;
        foreach ($this->usuarios as $key => $usuario) {
            if ($usuario->getNombre() === $nombreIngresado && $usuario->getClave() === $claveIngresada) {
                $indiceUsuarios = $key;
                break;
            }
        }
    
        if ($indiceUsuarios === null) {
            echo "Usuario no encontrado.\n";
            return;
        }
    
        // Eliminar el usuario del array
        unset($this->usuarios[$indiceUsuarios]);
        $this->usuarios = array_values($this->usuarios); // Reindexar el array
    
        echo "Usuario eliminado exitosamente.\n";
    }
    


}
$gestor = new GestorUsuario ();
$gestor->crearUsuario();
$gestor->crearUsuario();
$gestor->crearUsuario();
$gestor->crearUsuario();
// $gestor->validarIngresoUsuario ("florencia", 1234);
$gestor->listarUsuarios();
$gestor->editarUsuario();
$gestor->eliminarUsuario();
$gestor->listarUsuarios();