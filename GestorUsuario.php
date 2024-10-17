<?php
require_once 'usuario.php';
class GestorUsuario{

    //----------------------------------------Validacion Usuario-----------------------------------------

    public function validarIngresoUsuario ()= {
        echo "Si ya se encuentra registrado ingrese su nombre: ";
             $nombreUsuarioIngresado = trim(fgets(STDIN));
             echo "Si ya se encuentra registrado ingrese su clave: ";
             $claveUsuarioIngresada = trim(fgets(STDIN));
                        if ($claveUsuario == $claveUsuarioIngresada && $nombreUsuario == $nombreUsuarioIngresado) {
                            $this->menuUsuario(); 
                        } else {
                            echo "Nombre o clave Errónea.\n";
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

        echo "=== Usuarios Registrados ===\n";
        foreach ($this->usuarios as $usuario) {
            echo "Id: " . $nuevoUsuario->getId_usuario() . "Nombre: " . $nuevoUsuario->getNombre(). "\n";
        }
    }

    //-----------------------------editar usurario ---------------------------
    public function editarUsuario() {
        echo "Ingrese el nombre del usuario que desea editar: ";
        $nombre = trim(fgets(STDIN));
    
        echo "Ingrese la clave del usuario que desea editar: ";
        $clave = trim(fgets(STDIN));
        // Buscar el proyecto por ID
        $usuario = null;
        foreach ($this->usuarios as $u) {
            if ($u->getNombre() == $nombre && $u->getClave()==$clave) {
                echo "Ingrese el nuevo nombre del usuario";
                 $nombre = trim(fgets(STDIN));
                 $usuario->setNombre($nombre);

                 echo "Ingrese el nuevo email: ";
                 $email = trim(fgets(STDIN));
                $proyecto->setEmail($email);

                echo "Ingrese una nueva clave: ";
                 $clave = trim(fgets(STDIN));
                $clave->setClave($clave);
            }
        }
    
        echo "Proyecto editado exitosamente: " . $proyecto->getNombre() . "\n";
    }


    //-----------------------------eliminar usurario---------------------------
    public function eliminarUsuario() {
        echo "Ingrese el nombre del usuario que desea eliminar: ";
        $nombreUsuarioIngresado = trim(fgets(STDIN));

        echo "Ingrese el nombre del usuario que desea eliminar: ";
        $claveUsuarioIngreso = trim(fgets(STDIN));
    
        // Buscar el índice del proyecto por ID
        $indiceUsuarios = null;
        foreach ($this->usuarios as $usuario => $p) {
            if ($usuario->getClaveUsuario() === $id_proyecto) {
                $indiceProyecto = $indice;
                break;
            }
        }
    
        if ($indiceProyecto === null) {
            echo "Proyecto no encontrado.\n";
            return;
        }
    
        // Eliminar el proyecto del array
        unset($this->proyectos[$indiceProyecto]);
        $this->proyectos = array_values($this->proyectos); // Reindexar el array
    
        echo "Proyecto eliminado exitosamente.\n";
    }

}