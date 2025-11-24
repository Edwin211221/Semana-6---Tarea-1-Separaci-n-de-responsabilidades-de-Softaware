<?php
require_once('../config/conexion.php');

class OrdenTrabajo {

    /* ================================================
       OBTENER TODAS LAS ÓRDENES PARA EL LISTADO
       ================================================ */
    public function todos() {
    $con = new ClaseConectar();
    $con = $con->ProcedimientoConectar();

    $sql = "
        SELECT 
            s.id AS idServicio,
            s.fecha_servicio AS fecha,
            CONCAT(v.marca,' ',v.modelo,' (',v.anio,')') AS vehiculo,
            u.nombre_usuario AS usuario,
            COUNT(ot.id) AS cantidad_items
        FROM servicios s
        INNER JOIN vehiculos v ON v.id = s.id_vehiculo
        INNER JOIN usuarios u ON u.id = s.id_usuario
        LEFT JOIN orden_trabajo ot ON ot.Servicio_Id = s.id
        GROUP BY s.id
        ORDER BY s.id DESC
    ";

    $datos = mysqli_query($con, $sql);
    $con->close();
    return $datos;
}


    /* ================================================
       OBTENER UN ÍTEM
       ================================================ */
    public function uno($idOrdenTrabajo) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();

        $sql = "SELECT * FROM orden_trabajo WHERE id = $idOrdenTrabajo";

        $datos = mysqli_query($con, $sql);
        $con->close();
        return $datos;
    }

    /* ================================================
       OBTENER ITEMS POR SERVICIO
       ================================================ */
    public function itemsPorServicio($idServicio) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();

        $sql = "
            SELECT 
                ot.id,
                ot.Descripcion,
                ot.Servicio_Id,
                ot.TipoServicio_Id,
                ot.Cliente_Id,
                ot.fecha,
                ts.detalle AS tipo_servicio,
                CONCAT(c.nombres,' ',c.apellidos) AS cliente
            FROM orden_trabajo ot
            INNER JOIN tipo_servicio ts ON ts.id = ot.TipoServicio_Id
            INNER JOIN clientes c ON c.id = ot.Cliente_Id
            WHERE ot.Servicio_Id = $idServicio
            ORDER BY ot.id DESC;
        ";

        $datos = mysqli_query($con, $sql);
        $con->close();
        return $datos;
    }

    /* ================================================
       INSERTAR ITEM
       ================================================ */
    public function Insertar($Descripcion, $Servicio_Id, $TipoServicio_Id, $Cliente_Id, $fecha) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();

        $sql = "
            INSERT INTO orden_trabajo
            (Descripcion, Servicio_Id, TipoServicio_Id, Cliente_Id, fecha)
            VALUES
            ('$Descripcion', $Servicio_Id, $TipoServicio_Id, $Cliente_Id, '$fecha')
        ";

        if (mysqli_query($con, $sql)) {
            $con->close();
            return "ok";
        } else {
            $e = mysqli_error($con);
            $con->close();
            return $e;
        }
    }

    /* ================================================
       ACTUALIZAR ITEM
       ================================================ */
    public function Actualizar($id, $Descripcion, $Servicio_Id, $TipoServicio_Id, $Cliente_Id, $fecha) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();

        $sql = "
            UPDATE orden_trabajo
            SET 
                Descripcion = '$Descripcion',
                Servicio_Id = $Servicio_Id,
                TipoServicio_Id = $TipoServicio_Id,
                Cliente_Id = $Cliente_Id,
                fecha = '$fecha'
            WHERE id = $id
        ";

        if (mysqli_query($con, $sql)) {
            $con->close();
            return "ok";
        } else {
            $e = mysqli_error($con);
            $con->close();
            return $e;
        }
    }

    /* ================================================
       ELIMINAR SERVICIO COMPLETO
       ================================================ */
    public function Eliminar($idServicio) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();

        mysqli_begin_transaction($con);

        try {
            mysqli_query($con, "DELETE FROM orden_trabajo WHERE Servicio_Id = $idServicio");
            mysqli_query($con, "DELETE FROM servicios WHERE id = $idServicio");

            mysqli_commit($con);
            $con->close();
            return "ok";

        } catch (Exception $e) {
            mysqli_rollback($con);
            $con->close();
            return $e->getMessage();
        }
    }
}