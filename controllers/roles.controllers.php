<?php
error_reporting(0);
require_once('../config/sesiones.php');
require_once("../models/roles.models.php");
$Roles = new Roles;
switch ($_GET["op"]) {
    case 'todos':
        $datos = array();
        $datos = $Roles->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;
    case 'uno':
        $idRoles = $_POST["idRoles"];
        $datos = array();
        $datos = $Roles->uno($idRoles);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;
}
