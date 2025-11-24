<?php
/* CRUD DE USUARIOS*/

require_once('../config/conexion.php');

class Usuario_Model{
    public function todos(){
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "select * from usuarios";
        $datos = mysqli_query($con,$cadena);
        $con->close();
        return $datos;
    }
    public function uno($id){
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = 'select * from usuarios where id='.$id;
        $datos = mysqli_query($con,$cadena);
        $con->close();
        return $datos;
    }

    public function insertar($nombre, $apellido, $email, $contrasenia){
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "insert into usuarios(nombres, apellidos, email, contrasenia) values ('$nombre','$apellido','$email','$contrasenia')";
        $datos = mysqli_query($con,$cadena);
        $con->close();
        return $datos;
    }
    public function actualizar($id, $nombre, $apellido, $email,$contrasenia){
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "UPDATE `usuarios` SET `nombres`='$nombre',`apellidos`='$apellido',`email`='$email',`contrasenia`='$contrasenia' WHERE  `id`='$id'";
        $datos = mysqli_query($con,$cadena);
        $con->close();
        return $datos;
    }
    public function eliminar($id){
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = 'DELETE FROM `usuarios` WHERE id='.$id;
        $datos = mysqli_query($con,$cadena);
        $con->close();
        return $datos;
    }
     public function login1($email, $contrasenia){
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "select * from usuarios where email='$email' and contrasenia='$contrasenia'";
        $datos = mysqli_query($con,$cadena);
        $con->close();
        return $datos;
    }
    public function login2($email){
        $con = new Clase_Conectar();
        $con = $con->Procedimiento_Conectar();
        $cadena = "select * from usuarios where email='$email'";
        $datos = mysqli_query($con,$cadena);
        $con->close();
        return $datos;
    }
}