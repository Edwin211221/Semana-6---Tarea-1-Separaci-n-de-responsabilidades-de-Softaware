<?php
//TODO: Requerimientos 
require_once('../config/conexion.php');

class Servicios
{
    /*TODO: Procedimiento para sacar todos los registros*/
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM `servicios`";
        $datos = mysqli_query($con, $cadena);
        // Cerrar conexión
        $con->close();
        return $datos;
    }

    /*TODO: Procedimiento para sacar un registro*/
    public function uno($idServicio)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM `servicios` WHERE `id` = $idServicio";
        $datos = mysqli_query($con, $cadena);
        // Cerrar conexión
        $con->close();
        return $datos;
    }

    /*TODO: Procedimiento para insertar */
    // Si no envías fecha_servicio, se usa el DEFAULT (CURRENT_TIMESTAMP)
    public function Insertar($id_vehiculo, $id_usuario)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
            $cadena = "INSERT INTO `servicios`(id_vehiculo, id_usuario, fecha_servicio) 
                       VALUES ($id_vehiculo, $id_usuario, curdate())";

     if (mysqli_query($con, $cadena)) {
        $idGenerado = mysqli_insert_id($con);
        $con->close();
        return $idGenerado;
        } else {
            $con->close();
            return 0; // 0 = error
        }
    }

    // Nuevo: insertar y retornar id permitiendo fecha opcional enviada
    public function InsertarRetornarId($id_vehiculo, $id_usuario, $fecha_servicio = null)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();

        // Si se envía fecha válida se usa, caso contrario curdate()
        $fechaSql = ($fecha_servicio !== null && $fecha_servicio !== '') ? "'" . $fecha_servicio . "'" : "curdate()";
        $cadena = "INSERT INTO `servicios`(id_vehiculo, id_usuario, fecha_servicio) VALUES ($id_vehiculo, $id_usuario, $fechaSql)";

        if (mysqli_query($con, $cadena)) {
            $idGenerado = mysqli_insert_id($con);
            $con->close();
            return $idGenerado;
        } else {
            $con->close();
            return 0; // 0 = error
        }
    }

    /*TODO: Procedimiento para actualizar */
    public function Actualizar($idServicio, $id_vehiculo, $id_usuario, $fecha_servicio)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();

        $cadena = "UPDATE `servicios` 
                   SET `id_vehiculo` = $id_vehiculo,
                       `id_usuario` = $id_usuario,
                       `fecha_servicio` = 'curdate()'
                   WHERE `id` = $idServicio";

        if (mysqli_query($con, $cadena)) {
            $respuesta = 'ok';
        } else {
            $respuesta = 'error al actualizar el registro';
        }

        // Cerrar conexión
        $con->close();
        return $respuesta;
    }

    /*TODO: Procedimiento para Eliminar */
    public function Eliminar($idServicio)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "DELETE FROM `servicios` WHERE `id` = $idServicio";

        if (mysqli_query($con, $cadena)) {
            $respuesta = 'ok';
        } else {
            $respuesta = false;
        }

        // Cerrar conexión
        $con->close();
        return $respuesta;
    }
}
