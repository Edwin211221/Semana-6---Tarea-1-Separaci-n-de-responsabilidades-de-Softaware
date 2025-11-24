<?php
/*TODO: Requerimientos */
require_once("../config/cors.php");
require_once("../models/faltas.models.php");
//header('Content-Type: application/json');
error_reporting(0);

$faltas = new Faltas;
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
        /*TODO: Procedimiento para sacar un registro */
    case 'uno':
        $idAccesos = $_POST["idAccesos"];
        $datos = array();
        $datos = $faltas->uno($idAccesos);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case "observaciones":
        $EmpleadoId = $_POST["EmpleadoId"];
        $Fecha = $_POST["Fecha"];
        $datos = array();
        $datos = $faltas->observaciones($EmpleadoId, $Fecha);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
        /*TODO: Procedimiento para insertar */
    case 'insertar':
        $EmpleadoId = $_POST["EmpleadoId"];
        $Fecha = $_POST["Fecha"];
        $Observacion = $_POST["Observacion"];
        $datos = array();
        $datos = $faltas->Insertar($EmpleadoId, $Fecha, $Observacion);
        echo json_encode($datos);
        break;
        /*TODO: Procedimiento para actualizar */


    case 'actualizar':
        $FaltaId = $_POST["FaltaId"];
        $EmpleadoId = $_POST["EmpleadoId"];
        $Fecha = $_POST["Fecha"];
        $Observacion = $_POST["Observacion"];
        $datos = array();
        $datos = $faltas->Actualizar($FaltaId, $EmpleadoId, $Fecha, $Observacion);
        echo json_encode($datos);
        break;
        /*TODO: Procedimiento para eliminar */
    case 'eliminar':
        $idAccesos = $_POST["idAccesos"];
        $datos = array();
        $datos = $faltas->Eliminar($idAccesos);
        echo json_encode($datos);
        break;
}
