<?php
class estado{
    private $id_estado;
private $activo;
private $inactivo;


public function __construct ($id_estado, $activo, $inactivo){
    $this-> id_estado = $id_estado;
    $this-> activo = $activo;
    $this-> inactivo = $inactivo;
}
public function getId_estado (){
    return $this-> Id_estado;
}
public function getActivo (){
    return $this-> activo;
}
public function getInactivo (){
    return $this-> inactivo;
}
public function setActivo ($activo){
    $this-> activo = $activo;
}
public function setInactivo ($inactivo){
    $this-> inactivo= $inactivo;
}

}