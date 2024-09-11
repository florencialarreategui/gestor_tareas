<?php
require_once('proyecto.php');
require_once('usuario.php');
require_once('estado.php');
class tarea{
    private $id_tarea;
    private $nombre_tarea;
    private $descripcion_tarea;
    private $fecha_inicio;
    private $fecha_fin;
    private $id_proyecto;
    private $id_usuario;
    private $id_estado;

    public function __construct($id_tarea, $nombre_tarea, $descripcion_tarea, $fecha_inicio, $fecha_fin, $id_proyecto, $id_usuario, $id_estado){
        $this-> id_tarea = $id_tarea;
        $this-> nombre_tarea = $nombre_tarea;
        $this-> descrpcion_tarea = $descrpcion_tarea;
        $this-> fecha_inicio = $fecha_inicio;
        $this-> fecha_fin = $fecha_fin;
        $this-> id_proyecto = $id_proyecto;
        $this-> id_usuario = $id_usuario;
        $this-> id_estado = $id_estado;
    }

    public function getId_tarea (){
        return $this -> $id_tarea;
    }
    public function getNombre_tarea (){
        return $this -> $nombre_tarea;
    }
    public function getDescripcion_tarea (){
        return $this -> $descripcion_tarea;
    }
    public function getFecha_inicio (){
        return $this -> $fecha_inicio;
    }
    public function getFecha_fin (){
        return $this -> $fecha_fin;
    }
    public function getId_proyecto (){
        return $this -> $id_proyecto;
    }
    public function getId_estado (){
        return $this -> $id_estado;
    }


    public function setNombre_tarea ($nombre_tarea){
        $this -> nombre_tarea =  $nombre_tarea;
    }
    public function setDescripcion_tarea ($descripcion_tarea){
        $this -> descripcion_tarea = $descripcion_tarea;
    }
    public function setFecha_inicio ($fecha_inicio){
        $this -> fecha_inicio = $fecha_inicio;
    }
    public function setFecha_fin ($fecha_fin){
        $this -> fecha_fin = $fecha_fin;
    }
    public function setId_proyecto ($id_proyecto){
       $this -> id_proyecto = $id_proyecto;
    }
    public function setId_estado ($id_estado){
         $this -> id_estado = $id_estado;
    }
    public  function agregar_tarea($tareas, $tarea){
        $tareas[] = $tarea;
        echo "Tarea:".$this->nombre_tarea." se agrega al proyecto". "/n";

    }
    public  function eliminar_tarea(&$tareas, $tarea){
       foreach($tareas as index -> $tarea){
            if($tarea -> getId_tarea == $id_tarea){
                unset($tareas[index]);
                echo "La tarea". $this->nombre." ha sido eliminada". "/n";
                return;
                
            }
       }

    }

    public function editar_tarea($id_tarea, $tarea, $nueva_tarea){
        foreach($tareas as index -> $tarea){
            if($tarea -> getId_tarea == $id_tarea){
                $tareas[index] = $nueva_tarea;
                echo "La tarea con ID". $this->id_tarea." ha sido editada". "/n";
                return;
                
            }
       }

    }


    
}


