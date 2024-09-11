<?php
require_once('tarea.php');
require_once('usuario.php');
class proyecto{
    private $id_proyecto;
    private $nombre_proyecto;
    private $descripcion_proyecto;
    private $fecha_inicio_proyecto;
    private $fecha_fin_proyecto;
    private $id_tarea;
    private $id_usuario;
    private $id_estado;

    public function __construct($id_proyecyo, $nombre_proyecto, $descripcion_proyecto, $fecha_inicio_proyecto, $fecha_fin_proyecto, $id_tarea, $id_usuario, $id_estado){
        $this-> id_proyecto = $id_proyecto;
        $this-> nombre_proyecto = $nombre_proyecto;
        $this-> descrpcion_proyecto = $descrpcion_proyecto;
        $this-> fecha_inicio_proyecto = $fecha_inicio_proyecto;
        $this-> fecha_fin_proyecto = $fecha_fin_proyecto;
        // $this-> id_tarea = $id_tarea;
        // $this-> id_usuario = $id_usuario;
        // $this-> id_estado = $id_estado;
    }

    public function getId_proyecto (){
        return $this -> $id_tarea;
    }
    public function getNombre_proyecto (){
        return $this -> $nombre_tarea;
    }
    public function getDescripcion_proyecto (){
        return $this -> $descripcion_tarea;
    }
    public function getFecha_inicio_proyecto (){
        return $this -> $fecha_inicio;
    }
    public function getFecha_fin_proyecto (){
        return $this -> $fecha_fin;
    }
    // public function getId_proyecto (){
    //     return $this -> $id_proyecto;
    // }
    // public function getId_estado (){
    //     return $this -> $id_estado;
    // }

    public function setNombre_proyecto ($nombre_proyecto){
        $this -> nombre_proyecto =  $nombre_proyecto;
    }
    public function setDescripcion_proyecto ($descripcion_proyecto){
        $this -> descripcion_proyecto = $descripcion_proyecto;
    }
    public function setFecha_inicio_proyecto ($fecha_inicio_proyecto){
        $this -> fecha_inicio_proyecto = $fecha_inicio_proyecto;
    }
    public function setFecha_fin ($fecha_fin_proyecto){
        $this -> fecha_fin = $fecha_fin;
    }
    public function setId_estado ($id_estado){
         $this -> id_estado = $id_estado;
    }


    public static function agregar_proyecto($proyectos, $proyecto){
        $proyectos[] = $proyecto;
        echo "Proyecto:".$this->nombre_proyecto." se agrega al proyecto". "/n";

    }

    public static function eliminar_proyecto($id_proyecto, $proyecto){
       foreach($proyectos as index => $proyecto){
            if($proyecto -> getId_proyecto == $id_proyecto){
                unset($proyectos[index]);
                echo "El proyecto". $this->nombre_proyecto." ha sido eliminado". "/n";
        
                
            }
       }

    }

    public static function editar_proyecto($id_proyecto, $proyecto, $nuevo_proyecto){
        foreach($proyectos as index => $proyecto){
            if($proyecto -> getId_proyecto == $id_proyecto){
                $proyectos[index] = $nuevo_proyecto;
                echo "El proyecto con ID". $this->id_proyecto." ha sido editado". "/n";
                return
                
            }
       }

    }


    
}
