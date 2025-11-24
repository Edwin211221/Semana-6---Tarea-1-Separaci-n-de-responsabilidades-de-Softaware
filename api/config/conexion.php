<?php
class Clase_Conectar{
    public $conexion;
    protected $db;
    private $host= 'localhost';
    private $uid = 'root';
    private $pwd='root';
    private $database='QuintoApi';

    public function Procedimiento_Conectar(){
        $this->conexion = mysqli_connect( $this->host,  $this->uid,  $this->pwd);
        mysqli_query($this->conexion,"SET NAMES utf8");
        if($this->conexion == 0){
            die("error al conectarse con mysql ". mysqli_error($this->conexion));
        }
        $this->db = mysqli_select_db($this->conexion, $this->database);
        if($this->db==0) die("error al conectar con la base de datos". mysql_error($this->conexion));

        return $this->conexion;
    }

}