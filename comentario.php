<?php
class comentario{
    private $id_comentario;
    private $descripcion_comentario;
    private $estado_comentario;


public function __construct ($id_comentario, $descripcion_comentario, $estado_comentario){
    $this-> id_comentario = $id_comentario;
    $this-> descripcion_comentario = $descripcion_comentario;
    $this-> estado_comentario = $estado_comentario;
}
public function getId_comentario (){
    return $this-> Id_comentario;
}
public function getDescripcion_comentario (){
    return $this-> descripcion_comentario;
}
public function getEstado_comentario(){
    return $this-> estado_comentario;
}
public function setDescripcion_comentario ($descripcion_comentario){
    $this-> descripcion_comentario = $descripcion_comentario;
}
public function setEstado_comentario ($estado_comentario){
    $this-> estado_comentario= $estado_comentario;
}

}
