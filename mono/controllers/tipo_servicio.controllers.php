<?php
error_reporting(0);
/*TODO: Requerimientos */
require_once('../config/sesiones.php');
require_once("../models/tipo_serivicio.models.php");

$Tipo_Servicio = new Tipo_Servicio;

switch ($_GET["op"]) {
        /*TODO: Procedimiento para listar todos los registros */
    case 'todos':
        $datos = array();
        $datos = $Tipo_Servicio->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
        /*TODO: Procedimiento para sacar un registro */
    case 'uno':
        $idTipoServicio = $_POST["id_tipo_servicio"];
        $datos = array();
        $datos = $Tipo_Servicio->uno($idTipoServicio);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
    case 'unoDetalle':
        $Detalle = $_POST["Detalle"];
        $datos = array();
        $datos = $Tipo_Servicio->unoDetalle($Detalle);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
    
    case 'insertar':
        $detalle = $_POST["detalle"];
        $valor = $_POST["valor"];
       
        $datos = array();
        $datos = $Tipo_Servicio->Insertar($detalle, $valor);
        echo json_encode($datos);
        break;
        /*TODO: Procedimiento para actualizar */
    case 'actualizar':
        $idTipoServicio = $_POST["idTipoServicio"];
        $detalle = $_POST["detalle"];
        $valor = $_POST["valor"];
        $estado = $_POST["estado"];
            
        $datos = array();
        $datos = $Tipo_Servicio->Actualizar($idTipoServicio, $detalle, $valor, $estado=="on"?1:0);
        echo json_encode($datos);
        break;
        /*TODO: Procedimiento para eliminar */
    case 'eliminar':
        $idTipoServicio = $_POST["idTipoServicio"];
        $datos = array();
        $datos = $Tipo_Servicio->Eliminar($idTipoServicio);
        echo json_encode($datos);
        break;
     case 'eliminarsuave':
        $idTipoServicio = $_POST["idTipoServicio"];
        $datos = array();
        $datos = $Tipo_Servicio->Eliminarsuave($idTipoServicio);
        echo json_encode($datos);
        break;
        /*TODO: Procedimiento para insertar */
    default:
        break;
}
