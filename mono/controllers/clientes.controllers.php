<?php
error_reporting(0);
require_once('../config/sesiones.php');
require_once("../models/clientes.models.php");

$Clientes = new Clientes;

switch ($_GET["op"]) {

    case 'todos':
        $datos = $Clientes->todos();
        $lista = array();
        while ($row = mysqli_fetch_assoc($datos)) {
            $lista[] = $row;
        }
        echo json_encode($lista);
        break;

    case 'uno':
        $id = $_POST["idCliente"];
        $datos = $Clientes->uno($id);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar':
        $res = $Clientes->Insertar(
            $_POST["nombres"],
            $_POST["apellidos"],
            $_POST["telefono"],
            $_POST["correo_electronico"]
        );
        echo json_encode($res);   // 'ok' o 'error: ...'
        break;

    case 'actualizar':
        $res = $Clientes->Actualizar(
            $_POST["idCliente"],
            $_POST["nombres"],
            $_POST["apellidos"],
            $_POST["telefono"],
            $_POST["correo_electronico"]
        );
        echo json_encode($res);   // 'ok' o 'error: ...'
        break;

    case 'eliminar':
        $res = $Clientes->Eliminar($_POST["idCliente"]);
        echo json_encode($res);   // 'ok' o 'error: ...'
        break;
}