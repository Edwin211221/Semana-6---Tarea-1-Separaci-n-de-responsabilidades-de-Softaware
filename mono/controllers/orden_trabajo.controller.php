<?php
header('Content-Type: application/json; charset=utf-8');
require_once('../config/sesiones.php');
require_once("../models/servicios.models.php");
require_once("../models/orden_trabajo.models.php");

$Servicios    = new Servicios();
$OrdenTrabajo = new OrdenTrabajo();

$op = isset($_GET["op"]) ? $_GET["op"] : "";

switch ($op) {

    case 'todos':
        $datos = $OrdenTrabajo->todos();
        $todos = [];
        if ($datos) {
            while ($row = mysqli_fetch_assoc($datos)) {
                $todos[] = $row;
            }
        }
        echo json_encode($todos);
        break;

    // Traer servicio + items para editar
    case 'unoServicio':
        $idServicio = intval($_POST["idServicio"] ?? 0);
        if ($idServicio <= 0) {
            echo json_encode(["ok"=>false, "mensaje"=>"ID de servicio inválido."]);
            break;
        }

        $servicio = $Servicios->uno($idServicio);
        $srvRow = $servicio ? mysqli_fetch_assoc($servicio) : null;

        $itemsData = $OrdenTrabajo->itemsPorServicio($idServicio);
        $items = [];
        if ($itemsData) {
            while ($it = mysqli_fetch_assoc($itemsData)) {
                $items[] = $it;
            }
        }

        echo json_encode([
            "ok" => true,
            "servicio" => $srvRow,
            "items" => $items
        ]);
        break;

    case 'insertar':

        $id_vehiculo = intval($_POST["id_vehiculo"] ?? 0);
        $id_usuario  = intval($_POST["id_usuario"] ?? 0); // quien registra
        $fecha_servicio = $_POST["fecha_servicio"] ?? null;

        $items = [];
        if (!empty($_POST["items"])) {
            $items = json_decode($_POST["items"], true);
            if (!is_array($items)) $items = [];
        }

        $respuesta = ["ok"=>false, "mensaje"=>"", "idServicio"=>null];

        if ($id_vehiculo <= 0) {
            $respuesta["mensaje"] = "Debe seleccionar un vehículo.";
            echo json_encode($respuesta); break;
        }
        if ($id_usuario <= 0) {
            $respuesta["mensaje"] = "Debe seleccionar el usuario que registra.";
            echo json_encode($respuesta); break;
        }
        if (count($items) === 0) {
            $respuesta["mensaje"] = "Debe ingresar al menos un ítem.";
            echo json_encode($respuesta); break;
        }

        // 1) Inserta Servicio
        $idServicio = $Servicios->InsertarRetornarId($id_vehiculo, $id_usuario, $fecha_servicio);
        if ($idServicio <= 0) {
            $respuesta["mensaje"] = "No se pudo registrar el servicio.";
            echo json_encode($respuesta); break;
        }

        // 2) Inserta items
        $errores = 0;
        foreach ($items as $item) {
            $descripcion = trim($item["descripcion"] ?? "");
            $tipo_id     = intval($item["tipo_servicio_id"] ?? 0);
            $cliente_id  = intval($item["usuario_id"] ?? 0); // cliente seleccionado
            $fecha_item  = $item["fecha"] ?? ($fecha_servicio ?: date('Y-m-d'));

            // ✅ validación fuerte
            if ($descripcion === "" || $tipo_id <= 0 || $cliente_id <= 0) {
                $errores++;
                continue;
            }

            $resItem = $OrdenTrabajo->Insertar(
                $descripcion,
                $idServicio,
                $tipo_id,
                $cliente_id,
                $fecha_item
            );

            if ($resItem !== "ok") $errores++;
        }

        $respuesta["idServicio"] = $idServicio;

        if ($errores === 0) {
            $respuesta["ok"] = true;
            $respuesta["mensaje"] = "Orden de trabajo registrada correctamente.";
        } else {
            $respuesta["mensaje"] = "Servicio registrado, pero $errores ítem(s) fallaron. Revisa que todos tengan cliente.";
        }

        echo json_encode($respuesta);
        break;

    // Elimina servicio completo (lo usa tu JS eliminarOrden)
    case 'eliminar':
        $idServicio = intval($_POST["idServicio"] ?? 0);
        if ($idServicio <= 0) {
            echo json_encode(["ok"=>false, "mensaje"=>"ID inválido."]); break;
        }

        $res = $OrdenTrabajo->Eliminar($idServicio);
        echo json_encode(["ok"=>$res==="ok", "mensaje"=>$res]);
        break;

    default:
        echo json_encode(["ok"=>false, "mensaje"=>"op no válido"]);
        break;
}