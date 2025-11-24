<?php
/*TODO: Requerimientos */
require_once("../config/cors.php");
require_once("../models/Accesos.models.php");
//header('Content-Type: application/json');
error_reporting(0);

$Accesos = new Accesos;
switch ($_GET["op"]) {
        /*TODO: Procedimiento para listar todos los registros */
    case 'todos':
        $inicio = $_POST["fechainicio"];
        $fin = $_POST["fechafin"];
        $SucursalId = $_POST["SucursalId"];
        $data = array();
        $datos = $Accesos->todos($inicio, $fin, $SucursalId);
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }

        echo json_encode($todos);
        break;
    case 'general':
        $data = array();
        $datos = $Accesos->general();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($results);
        break;
        /*TODO: Procedimiento para sacar un registro */
    case 'uno':
        $idAccesos = $_POST["idAccesos"];
        $datos = array();
        $datos = $Accesos->uno($idAccesos);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
        /*TODO: Procedimiento para insertar */
    case 'insertar':
        $usuariosId = $_POST["usuariosId"];
        $tipo = $_POST["tipo"];
        $datos = array();
        $datos = $Accesos->Insertar($usuariosId, $tipo);
        echo json_encode($datos);
        break;
        /*TODO: Procedimiento para actualizar */
    case 'actualizar':
        $idAccesos = $_POST["idAccesos"];
        $Ultimo = $_POST["Ultimo"];
        $Usuarios_idUsuarios = $_POST["Usuarios_idUsuarios"];
        $datos = array();
        $datos = $Accesos->Actualizar($idAccesos, $Ultimo, $Usuarios_idUsuarios);
        echo json_encode($datos);
        break;
        /*TODO: Procedimiento para eliminar */
    case 'eliminar':
        $idAccesos = $_POST["idAccesos"];
        $datos = array();
        $datos = $Accesos->Eliminar($idAccesos);
        echo json_encode($datos);
        break;

    case 'repo':
        $inicio = $_POST["inicio"];
        $fin = $_POST["fin"];
        echo 'aqui';
        $data = array();
        $datos = $Accesos->reporte_general();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($results);
        break;
}
