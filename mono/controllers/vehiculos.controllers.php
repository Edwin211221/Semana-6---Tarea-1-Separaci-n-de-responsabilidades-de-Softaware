<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
header('Content-Type: application/json; charset=utf-8');
error_reporting(0);

require_once('../config/sesiones.php');
require_once("../models/vehiculos.models.php");

$Vehiculos = new Vehiculos();

switch ($_GET["op"]) {

    case "todos":
        $datos = $Vehiculos->todos();
        $lista = [];
        while ($row = mysqli_fetch_assoc($datos)) {
            $lista[] = $row;
        }
        echo json_encode($lista);
        break;

    case "uno":
        $id = $_POST["idVehiculo"];
        $datos = $Vehiculos->uno($id);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case "insertar":
        $res = $Vehiculos->Insertar(
            $_POST["id_cliente"],
            $_POST["marca"],
            $_POST["modelo"],
            $_POST["anio"],
            $_POST["tipo_motor"]
        );

        echo json_encode(["status" => ($res > 0 ? "ok" : "error")]);
        break;

    case "actualizar":
        $res = $Vehiculos->Actualizar(
            $_POST["idVehiculo"],
            $_POST["id_cliente"],
            $_POST["marca"],
            $_POST["modelo"],
            $_POST["anio"],
            $_POST["tipo_motor"]
        );

        echo json_encode(["status" => $res]);
        break;

    case "eliminar":
        $res = $Vehiculos->Eliminar($_POST["idVehiculo"]);
        echo json_encode(["status" => $res]);
        break;
}