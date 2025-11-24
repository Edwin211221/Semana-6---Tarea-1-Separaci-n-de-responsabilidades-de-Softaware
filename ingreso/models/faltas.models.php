<?php
//TODO: Requerimientos 
require_once('../config/conexion.php');
class Faltas
{
    /*TODO: Procedimiento para sacar todos los registros*/
    public function todos($inicio, $fin, $SucursalId)
    {
        if ($inicio == null || $fin == null) {
            $inicio = date('Y-m-01');
            $fin = date('Y-m-t');
        }
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        if ($SucursalId > 0) {
            $cadena = "SELECT * FROM `Faltas` INNER JOIN Empleado on Faltas.EmpleadoId = Empleado.EmpleadoId INNER JOIN Sucursales on Empleado.SucursalId = Sucursales.SucursalId  where Faltas.Fecha BETWEEN '$inicio' AND '$fin' and Sucursales.SucursalId=$SucursalId";
        } else {
            $cadena = "SELECT * FROM `Faltas` INNER JOIN Empleado on Faltas.EmpleadoId = Empleado.EmpleadoId INNER JOIN Sucursales on Empleado.SucursalId = Sucursales.SucursalId  where Faltas.Fecha BETWEEN '$inicio' AND '$fin' ";
        }
        echo $cadena;
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }

    public function uno($FaltaId)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT `FaltaId`, `EmpleadoId`, `Fecha`, `Observacion`, `archivo` FROM `Faltas` WHERE `FaltaId`=$FaltaId";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    public function observaciones($EmpleadoId, $Fecha)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT *  FROM `Faltas` WHERE `EmpleadoId`= $EmpleadoId and `Fecha`='$Fecha'";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }

    /*TODO: Procedimiento para insertar */
    public function Insertar($EmpleadoId, $Fecha, $Observacion)
    {
        $fechaConHorasMinutos = date("YmdHis");
        $extension = explode('.', $_FILES['archivo']['name']);
        $new_name = $fechaConHorasMinutos . "." . $extension[1];
        $destination = '../../public/justificaciones/' . $new_name;
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "INSERT INTO `Faltas`(`EmpleadoId`, `Fecha`, `Observacion`, `archivo`) VALUES ($EmpleadoId,'$Fecha','$Observacion','$destination')";
        if (mysqli_query($con, $cadena)) {
            if ($_FILES["archivo"]["name"] != '') {
                $acc = new Faltas;
                return $acc->upload_file(mysqli_insert_id($con));
            } else {
                return 'ok';
            }
        } else {
            return mysqli_error($con);
        }
        $con->close();
    }
    public function upload_file()
    {
        if ($_FILES["archivo"]["name"] != '') {
            $fechaConHorasMinutos = date("YmdHis");
            $extension = explode('.', $_FILES['archivo']['name']);
            $new_name = $fechaConHorasMinutos . "." . $extension[1];
            $destination = '../public/justificaciones/' . $new_name;
            if (copy($_FILES['archivo']['tmp_name'], $destination)) {
                return "ok";
            } else {
                return 'Error al guardar el archivo';
            }
        }
    }
    /*TODO: Procedimiento para actualizar */
    public function Actualizar($FaltaId, $EmpleadoId, $Fecha, $Observacion)
    {
        $fechaConHorasMinutos = date("YmdHis");
        $extension = explode('.', $_FILES['archivo']['name']);
        $new_name = $fechaConHorasMinutos . "." . $extension[1];
        $destination = '../../public/justificaciones/' . $new_name;
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        if ($_FILES['archivo']['name'] == '') {
            $cadena = "UPDATE `Faltas` SET `EmpleadoId`=$EmpleadoId,`Fecha`='$Fecha',`Observacion`='$Observacion' WHERE `FaltaId`='$FaltaId'";

            if (mysqli_query($con, $cadena)) {
                return 'ok';
            } else {
                return mysqli_error($con);
            }
            return 'ok';
        } else {
            $cadena = "UPDATE `Faltas` SET `EmpleadoId`=$EmpleadoId,`Fecha`='$Fecha',`Observacion`='$Observacion',`archivo`='$destination' WHERE `FaltaId`='$FaltaId'";

            if (mysqli_query($con, $cadena)) {
                $acc = new Faltas;
                return $acc->upload_file();
            } else {
                return mysqli_error($con);
            }
        }

        $con->close();
    }
    /*TODO: Procedimiento para Eliminar */
    public function Eliminar($idAccesos)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "delete from Accesos where idAccesos = $idAccesos";
        if (mysqli_query($con, $cadena)) {
            return "ok";
        } else {
            return false;
        }
        $con->close();
    }
    //public function reporte_general($inicio, $fin)
    public function reporte_general()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SET lc_time_names = 'es_ES';SELECT Sucursales.Nombre AS sucursal, CONCAT(Empleado.Nombres, ' ', Empleado.Apellidos) AS empleados, COALESCE(DAYNAME(Accesos.Ultimo), DAYNAME(Faltas.Fecha)) AS dia, CONCAT(LPAD(HOUR(COALESCE(Accesos.Ultimo, Faltas.Fecha)), 2, '0'), ':', LPAD(MINUTE(COALESCE(Accesos.Ultimo, Faltas.Fecha)), 2, '0')) AS tiempo, COALESCE(Tipo_Acceso.Detalle, 'Falta') AS acceso, COALESCE(Accesos.Ultimo, Faltas.Fecha, '') AS fecha, Faltas.Observacion, Faltas.archivo FROM `Empleado` INNER JOIN `Sucursales` ON Empleado.SucursalId = Sucursales.SucursalId LEFT JOIN `Accesos` ON Empleado.EmpleadoId = Accesos.EmpleadoId AND Accesos.Ultimo BETWEEN '2024-03-01' AND '2024-03-31' LEFT JOIN `Tipo_Acceso` ON Accesos.IdTipoAcceso = Tipo_Acceso.IdTipoAcceso LEFT JOIN `Faltas` ON Empleado.EmpleadoId = Faltas.EmpleadoId AND Faltas.Fecha BETWEEN '2024-03-01' AND '2024-03-31' ORDER BY sucursal, empleados, acceso, fecha;";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
}
