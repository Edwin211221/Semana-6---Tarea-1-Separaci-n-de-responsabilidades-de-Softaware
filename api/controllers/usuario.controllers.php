<?php

error_reporting(0);
require_once('../models/usuario.models.php');

$usuario = new Usuario_Model();


/**
 * GET => OP
 * POST => VALORES
 */
switch($_GET["op"]){
    case "todos":
        $datos = array();
        $datos = $usuario->todos();
        while($fila = mysqli_fetch_assoc($datos)){
            $todos[]=$fila;
        }
        echo json_encode($todos);
        break;
    case "uno":
        $id = $_POST["id"];
    
        $datos = array();
        $datos = $usuario->uno($id);
        $uno = mysqli_fetch_assoc($datos);
        echo json_encode($uno);
        break;
    case "insertar":
        $nombre=$_POST["nombre"];
        $apellido=$_POST["apellido"];
        $email=$_POST["email"];
        $contrasenia=$_POST["contrasenia"];

        $datos = array();
        $datos = $usuario->insertar($nombre, $apellido, $email, $contrasenia);
        echo json_encode($datos);
        break;
    case "actualizar":
        $id = $_POST["id"];

        $nombre=$_POST["nombre"];
        $apellido=$_POST["apellido"];
        $email=$_POST["email"];
        $contrasenia=$_POST["contrasenia"];

        $datos = array();
        $datos = $usuario->actualizar($id, $nombre, $apellido, $email, $contrasenia);
        echo json_encode($datos);
        break;
    case "eliminar":
        $id = $_POST["id"];
        $datos = array();
        $datos = $usuario->eliminar($id);
        echo json_encode($datos);
        break;
    default:
        break;
}
//