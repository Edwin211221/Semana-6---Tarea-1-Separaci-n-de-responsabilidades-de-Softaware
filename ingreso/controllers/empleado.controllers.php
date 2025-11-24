<?php
error_reporting(0);

/*TODO: Requerimientos */
require_once('../config/sesiones.php');
require_once("../config/cors.php");
require_once("../models/Empleado.models.php");

$Empleados = new Empleados;
//$Accesos = new Accesos;
switch ($_GET["op"]) {
        /*TODO: Procedimiento para listar todos los registros */
    case 'todos':
        $datos = array();
        $datos = $Empleados->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
    case 'todosData':
        $todos = array();
        $datos = $Empleados->todosData();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
    case 'fechas':
        $inicio = $_POST["inicio"];
        // $inicio = date("d-m-Y", strtotime($inicio));
        $fin = $_POST["fin"];
        //$fin = date("d-m-Y", strtotime($fin));
        $todos = array();
        $datos = $Empleados->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
        /*TODO: Procedimiento para sacar un registro */
    case 'uno':
        $EmpleadoId = $_POST["EmpleadoId"];
        $datos = array();
        $datos = $Empleados->uno($EmpleadoId);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
    case 'unoCedula':
        $Cedula = $_POST["Cedula"];
        $datos = array();
        $datos = $Empleados->unoCedula($Cedula);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
    case 'contarCedula':
        $Cedula = $_POST["Cedula"];
        $datos = array();
        $datos = $Empleados->contarCedula($Cedula);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
    case 'unoCorreo':
        $Correo = $_POST["Correo"];
        $datos = array();
        $datos = $Empleados->unoCorreo($Correo);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
        /*TODO: Procedimiento para insertar */
    case 'insertar':
        $Nombres = $_POST["Nombres"];
        $Apellidos = $_POST["Apellidos"];
        $Correo = $_POST["Correo"];
        $SucursalId = $_POST["SucursalId"];
        $RolId = $_POST["RolId"];
        $Cedula = $_POST["Cedula"];
        $Direccion = $_POST["Direccion"];
        $Telefono = $_POST["Telefono"];
        $datos = array();
        $datos = $Empleados->Insertar($Nombres, $Apellidos, $Direccion, $Telefono, $Cedula, $Correo, $RolId, $SucursalId);
        echo json_encode($datos);
        break;
        /*TODO: Procedimiento para actualizar */
    case 'actualizar':
        $EmpleadoId = $_POST["EmpleadoId"];
        $Nombres = $_POST["Nombres"];
        $Apellidos = $_POST["Apellidos"];
        $Correo = $_POST["Correo"];
        $RolId = $_POST["RolId"];
        $Cedula = $_POST["Cedula"];
        $Direccion = $_POST["Direccion"];
        $Telefono = $_POST["Telefono"];
        $SucursalId = $_POST["SucursalId"];
        $datos = array();
        $datos = $Empleados->Actualizar($EmpleadoId, $Nombres, $Apellidos, $Direccion, $Telefono, $Cedula, $Correo, $RolId, $SucursalId);
        echo json_encode($datos);
        break;
        /*TODO: Procedimiento para eliminar */
    case 'eliminar':
        $EmpleadoId = $_POST["EmpleadoId"];
        $datos = array();
        $datos = $Empleados->Eliminar($EmpleadoId);
        echo json_encode($datos);
        break;
        /*TODO: Procedimiento para insertar */

        $correo = $_POST['correo'];
        $contrasenia = $_POST['contrasenia'];

        //TODO: Si las variables estab vacias rgersa con error
        if (empty($correo) or  empty($contrasenia)) {
            header("Location:../login.php?op=2");
            exit();
        }

        try {
            $datos = array();
            $datos = $Usuarios->login($correo, $contrasenia);
            $res = mysqli_fetch_assoc($datos);
        } catch (Throwable $th) {
            header("Location:../login.php?op=1");
            exit();
        }
        //TODO:Control de si existe el registro en la base de datos
        try {
            if (is_array($res) and count($res) > 0) {
                //if ((md5($contrasenia) == ($res["Contrasenia"]))) {
                if ((($contrasenia) == ($res["Contrasenia"]))) {
                    //$datos2 = array();
                    // $datos2 = $Accesos->Insertar(date("Y-m-d H:i:s"), $res["idUsuarios"], 'ingreso');

                    $_SESSION["idUsuarios"] = $res["idUsuarios"];
                    $_SESSION["Usuarios_Nombres"] = $res["Nombres"];
                    $_SESSION["Usuarios_Apellidos"] = $res["Apellidos"];
                    $_SESSION["Usuarios_Correo"] = $res["Correo"];
                    $_SESSION["Usuario_IdRoles"] = $res["idRoles"];
                    $_SESSION["Rol"] = $res["Rol"];



                    header("Location:../views/home.php");
                    exit();
                } else {
                    header("Location:../login.php?op=1");
                    exit();
                }
            } else {
                header("Location:../login.php?op=1");
                exit();
            }
        } catch (Exception $th) {
            echo ($th->getMessage());
        }
        break;
}
