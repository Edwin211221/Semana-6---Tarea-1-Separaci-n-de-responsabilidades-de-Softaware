<?php
error_reporting(0);
/*TODO: Requerimientos */
require_once('../config/sesiones.php');
require_once("../models/usuario.models.php");

$Usuarios = new Usuarios;

switch ($_GET["op"]) {
        /*TODO: Procedimiento para listar todos los registros */
    case 'todos':
        $datos = array();
        $datos = $Usuarios->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
        /*TODO: Procedimiento para sacar un registro */
    case 'uno':
        $idUsuarios = $_POST["idUsuarios"];
        $datos = array();
        $datos = $Usuarios->uno($idUsuarios);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
    case 'unoNombreUsuario':
        $NombreUsuario = $_POST["NombreUsuario"];
        $datos = array();
        $datos = $Usuarios->unoNombreUsuario($NombreUsuario);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
    
    case 'insertar':
        $NombreUsuario = $_POST["NombreUsuario"];
        $Contrasenia = $_POST["contrasenia"];
        $id_rol = $_POST["id_rol"];
        $datos = array();
        $datos = $Usuarios->Insertar($NombreUsuario,  md5($Contrasenia),  $id_rol);
        echo json_encode($datos);
        break;
        /*TODO: Procedimiento para actualizar */
    case 'actualizar':
        $idUsuarios = $_POST["id"];
        $nombre_usuario = $_POST["NombreUsuario"];
        $contrasena = $_POST["contrasenia"];
        $id_rol = $_POST["id_rol"];
        $datos = array();
        $datos = $Usuarios->Actualizar($idUsuarios, $nombre_usuario, $contrasena, $id_rol);
        echo json_encode($datos);
        break;
        /*TODO: Procedimiento para eliminar */
    case 'eliminar':
        $idUsuarios = $_POST["idUsuarios"];
        $datos = array();
        $datos = $Usuarios->Eliminar($idUsuarios);
        echo json_encode($datos);
        break;
     case 'eliminarsuave':
        $idUsuarios = $_POST["idUsuarios"];
        $datos = array();
        $datos = $Usuarios->Eliminarsuave($idUsuarios);
        echo json_encode($datos);
        break;
        /*TODO: Procedimiento para insertar */
    case 'login2':
        $nombre_usuario = isset($_POST['nombre_usuario']) ? trim($_POST['nombre_usuario']) : '';
        $contrasenia = isset($_POST['contrasenia']) ? trim($_POST['contrasenia']) : '';

        if ($nombre_usuario === '' || $contrasenia === '') {
            header("Location:../login.php?op=2");
            exit();
        }

        // Obtener fila del usuario
        $fila = $Usuarios->login($nombre_usuario, md5($contrasenia));

        if (!$fila) {
            header("Location:../login.php?op=1"); // Usuario no encontrado
            exit();
        }

        // Validar contraseña (se guarda ya como md5 en la BD según Insertar)
        if (md5($contrasenia) !== $fila['contrasena']) {
            header("Location:../login.php?op=1"); // Contraseña incorrecta
            exit();
        }

        // Setear variables de sesión con nombres reales de columnas
        $_SESSION["idUsuarios"] = $fila["usuario_id"]; // alias en SELECT
        $_SESSION["NombreUsuario"] = $fila["nombre_usuario"];
        $_SESSION["Rol"] = $fila["rol_nombre"]; // alias rol

        // Redirección según rol
        if ($_SESSION['Rol'] === 'Control') {
            header("Location:../views/control.php");
        } elseif ($_SESSION['Rol'] === 'ADMINISTRADOR') {
            header("Location:../views/home.php");
        } else {
            // Otros roles también pueden ir al home (ajusta si necesitas otra vista)
            header("Location:../views/home.php");
        }
        exit();
        break;
    case 'login1':   // para para inyeccion sql 
        
        $nombre_usuario = $_POST['nombre_usuario'];
        $contrasenia = $_POST['contrasenia'];

        
        //TODO: Si las variables estab vacias rgersa con error
        if (empty($nombre_usuario) or  empty($contrasenia)) {
            header("Location:../login.php?op=2");
            exit();
        }

        try {
            $datos = array();
            $datos = $Usuarios->login1($nombre_usuario, md5($contrasenia));
            $res = mysqli_fetch_assoc($datos);
        } catch (Throwable $th) {
            header("Location:../login.php?op=1");
            exit();
        }
        try {
            if (is_array($res) and count($res) > 0) {
                $_SESSION['Rol'] = 'ADMINISTRADOR';
                $_SESSION["idUsuarios"] = $res["id"];
                $_SESSION["NombreUsuario"] = $res["nombre_usuario"];
                header("Location:../views/home.php"); 
                exit();
         } else {
                header("Location:../login.php?op=1");
            exit();
            }
        } catch (Exception $th) {
            error_log($th->getMessage());
        }
        break;
}
