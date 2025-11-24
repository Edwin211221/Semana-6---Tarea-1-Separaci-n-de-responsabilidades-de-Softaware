<?php
//TODO: Requerimientos 
require_once('../config/conexion.php');
class Accesos
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
            $cadena = " SELECT 
            Sucursales.Nombre AS sucursal,
            CONCAT(Empleado.Nombres, ' ', Empleado.Apellidos) AS empleados, Empleado.EmpleadoId,
            ((Accesos.Ultimo)) AS dia,
            CONCAT(
                LPAD(HOUR((Accesos.Ultimo)), 2, '0'),
                ':',
                LPAD(MINUTE((Accesos.Ultimo)), 2, '0')
            ) AS tiempo,
            (Tipo_Acceso.Detalle) AS acceso,
            (Accesos.Ultimo) AS fecha,
            Accesos.imagen
        FROM 
            Empleado 
            INNER JOIN Sucursales ON Empleado.SucursalId = Sucursales.SucursalId
            
            INNER JOIN Accesos ON Empleado.EmpleadoId = Accesos.EmpleadoId 
            INNER JOIN Tipo_Acceso ON Accesos.IdTipoAcceso = Tipo_Acceso.IdTipoAcceso
            where 
            Accesos.Ultimo BETWEEN '$inicio' AND '$fin' and Sucursales.SucursalId=$SucursalId  
        ORDER BY 
            sucursal, empleados, acceso, fecha;";
        } else {
            $cadena = " SELECT 
        Sucursales.Nombre AS sucursal,
        CONCAT(Empleado.Nombres, ' ', Empleado.Apellidos) AS empleados, Empleado.EmpleadoId,
        ((Accesos.Ultimo)) AS dia,
        CONCAT(
            LPAD(HOUR((Accesos.Ultimo)), 2, '0'),
            ':',
            LPAD(MINUTE((Accesos.Ultimo)), 2, '0')
        ) AS tiempo,
        (Tipo_Acceso.Detalle) AS acceso,
        (Accesos.Ultimo) AS fecha,
        Accesos.imagen
       
    FROM 
        Empleado 
        INNER JOIN Sucursales ON Empleado.SucursalId = Sucursales.SucursalId
        
        INNER JOIN Accesos ON Empleado.EmpleadoId = Accesos.EmpleadoId 
        INNER JOIN Tipo_Acceso ON Accesos.IdTipoAcceso = Tipo_Acceso.IdTipoAcceso
        where 
        Accesos.Ultimo BETWEEN '$inicio' AND '$fin' 
    ORDER BY 
        sucursal, empleados, acceso, fecha;";
        }


        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    public function general()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT Sucursales.Nombre, COUNT(Accesos.EmpleadoId) as conteo, Accesos.Ultimo FROM `Accesos` INNER JOIN Empleado on Accesos.EmpleadoId = Empleado.EmpleadoId INNER JOIN Sucursales on Empleado.SucursalId = Sucursales.SucursalId GROUP by Sucursales.Nombre;";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    /*TODO: Procedimiento para sacar un registro*/
    public function uno($idAccesos)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT  * FROM Accesos WHERE idAccesos = $idAccesos";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    /*TODO: Procedimiento para insertar */
    public function Insertar($usuariosId, $IdTipoAcceso)
    {
        $fechaConHorasMinutos = date("YmdHis");
        $new_name = $fechaConHorasMinutos . '.png';
        $destination = '../../public/images/registros/' . $new_name;
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "INSERT into Accesos(IdTipoAcceso, ultimo, imagen,EmpleadoId ) values ($IdTipoAcceso, CURRENT_TIMESTAMP(),'$destination',$usuariosId)";

        if (mysqli_query($con, $cadena)) {
            $acc = new Accesos;
            return $acc->imagen(mysqli_insert_id($con));
        } else {
            return mysqli_error($con);
        }
        $con->close();
    }
    public function imagen($usuariosId)
    {
        $fechaConHorasMinutos = date("YmdHis");
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                $imagenBase64 =   $_POST['emplea']; //file_get_contents("php://input");
                $imagenBinaria = base64_decode($imagenBase64);
                $carpetaDestino = '../public/images/registros/';
                if (!file_exists($carpetaDestino)) {
                    mkdir($carpetaDestino, 0777, true);
                }
                $nombreArchivo =  $fechaConHorasMinutos . '.png';
                $rutaCompleta = $carpetaDestino . $nombreArchivo;
                file_put_contents($rutaCompleta, $imagenBinaria);
                return 'ok';
            } catch (Exception $e) {
                return 'no se enceuntra la imagen';
            }
        } else {
            return 'no entra al proceso';
        }
    }
    /*TODO: Procedimiento para actualizar */
    public function Actualizar($idAccesos, $Ultimo, $Usuarios_idUsuarios)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "update Accesos set Ultimo='$Ultimo',Usuarios_idUsuarios=$Usuarios_idUsuarios where idAccesos= $idAccesos";
        if (mysqli_query($con, $cadena)) {
            return "ok";
        } else {
            return 'error al actualizar el registro';
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
            return true;
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
