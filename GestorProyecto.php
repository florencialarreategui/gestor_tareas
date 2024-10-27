<?php
require_once 'funcionesAuxiliares.php';
require_once 'proyecto.php';
require_once 'tarea.php';
require_once 'comentario.php';
require_once 'estado.php';

class GestorProyecto {
        public $proyectos = [];    
        private $archivoJson = 'proyecto.json';

        public function __construct()
        {
            $this->cargarDesdeJSON();
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

                echo "Proyecto creado exitosamente: " . $nuevoProyecto->getNombre() ." ". $id_proyecto . "\n";

                $this->guardarEnJSON();
            }
    //-----------------------------listar proyectos----------------------------
            public function listarProyectos() {
                if (empty($this->proyectos)) {
                    echo "No hay proyectos registrados.\n";
                    return;
                }

                echo "=== Proyectos Registrados ===\n";
                foreach ($this->proyectos as $proyecto) {
                    echo "Id: " . $proyecto->getIdProyecto() . "  Nombre: " . $proyecto->getNombre() . ", Fecha de Inicio: " . $proyecto->getFechaInicio() . ", Fecha de Finalización: " . $proyecto->getFechaFin() . "\n";
                }
                $this->guardarEnJSON();


            }


    //-----------------------------editar proyectos ----------------------------
    public function editarProyecto() {
        echo "Ingrese el ID del proyecto que desea editar: ";
        $id_proyecto = trim(fgets(STDIN));

        // Buscar el proyecto por ID

        foreach ($this->proyectos as $proyecto) {
            if ($proyecto->getIdProyecto() == $id_proyecto) {
            
                echo "Ingrese el nuevo nombre del proyecto: ";
                    $nombre = trim(fgets(STDIN));
                    $proyecto->setNombre($nombre);
        

                echo "Ingrese la nueva descripción del proyecto: ";
                    $descripcion = trim(fgets(STDIN));
                    $proyecto->setDescripcion($descripcion);
                

                echo "Ingrese la nueva fecha de inicio (YYYY-MM-DD): ";
                    $fechaInicio = trim(fgets(STDIN));
                    $proyecto->setFechaInicio($fechaInicio);


                echo "Ingrese la nueva fecha de finalización (YYYY-MM-DD): ";
                    $fechaFin = trim(fgets(STDIN));
                    $proyecto->setFechaFin($fechaFin);
                break;
            }       
                else {
                echo "Proyecto no encontrado.\n";
                };
        }
            echo "Proyecto editado exitosamente: " . $proyecto->getNombre() . "\n";
            $this->guardarEnJSON();
    }

    //-----------------------------eliminar proyectos----------------------------
    public function eliminarProyecto() {
        echo "Ingrese el ID del proyecto que desea eliminar: ";
        $id_proyecto = trim(fgets(STDIN));

        // Buscar el índice del proyecto por ID
        $indiceProyecto = null;
        foreach ($this->proyectos as $indice => $p) {
            if ($p->getIdProyecto() === $id_proyecto) {
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
        $this->guardarEnJSON();
    }    
        

        public function guardarEnJSON() {
            $proyectos = [];

            foreach ($this->proyectos as $proyecto) {
                $proyectos[] = $proyecto->ToArray();
            }

            $jsonusuario = json_encode(['proyecto' => $proyectos], JSON_PRETTY_PRINT);
            file_put_contents($this->archivoJson, $jsonproyecto);
        }
        

        
        public function cargarDesdeJSON() {
            if (file_exists($this->archivoJson)) {
                $json = file_get_contents($this->archivoJson);
                $proyectos = json_decode($json, true)['proyecto'];
                $this->proyectos = [];
                foreach ($proyectos as $proyectoData) {
                    $proyecto = new Proyecto(
                        $proyectoData['id_proyecto'],
                        $proyectoData['nombre'],
                        $proyectoData['descripcion'],
                        $proyectoData['fechaInicio'],
                        $proyectoData['fechaFin']
                    );
                    $this->proyectos[] = $proyecto;
                }
            }       

        }
       

 }
    

$nuevoProyecto = new GestorProyecto ();
$nuevoProyecto->crearProyecto();
$nuevoProyecto->crearProyecto();
$nuevoProyecto->crearProyecto();
$nuevoProyecto->crearProyecto();
// $gestor->validarIngresoUsuario ("florencia", 1234);
$nuevoProyecto->listarProyectos();
$nuevoProyecto->editarProyecto();
$nuevoProyecto->listarProyectos();
$nuevoProyecto->eliminarProyecto();
$nuevoProyecto->listarProyectos();