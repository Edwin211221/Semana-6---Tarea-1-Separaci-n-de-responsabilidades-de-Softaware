<?php
require_once('../config/conexion.php');
class Empleados
{
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT Empleado.*, Sucursales.Nombre as Sucursal, Roles.Rol FROM `Empleado` INNER JOIN Roles on Empleado.RolId = Roles.idRoles INNER JOIN Sucursales on Empleado.SucursalId = Sucursales.SucursalId where Roles.Rol <> 'Control' and Roles.Rol <> 'ADMINISTRADOR';";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    public function todosData()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT DISTINCT Accesos.imagen,  Accesos.Ultimo, Accesos.IdTipoAcceso, Accesos.EmpleadoId, Tipo_Acceso.Detalle as tipo, CONCAT(Empleado.Nombres,' ', Empleado.Apellidos) as nombres, Sucursales.Nombre as sucursal	 FROM `Accesos` INNER JOIN Tipo_Acceso on Accesos.IdTipoAcceso = Tipo_Acceso.IdTipoAcceso INNER JOIN Empleado on Accesos.EmpleadoId = Empleado.EmpleadoId inner JOIN Sucursales on Empleado.SucursalId = Sucursales.SucursalId;";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    public function fechas($inicio, $fin)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT DISTINCT Accesos.imagen,  Accesos.Ultimo, Accesos.IdTipoAcceso, Accesos.EmpleadoId, Tipo_Acceso.Detalle as tipo, CONCAT(Empleado.Nombres,' ', Empleado.Apellidos) as nombres, Sucursales.Nombre as sucursal	 FROM `Accesos` INNER JOIN Tipo_Acceso on Accesos.IdTipoAcceso = Tipo_Acceso.IdTipoAcceso INNER JOIN Empleado on Accesos.EmpleadoId = Empleado.EmpleadoId inner JOIN Sucursales on Empleado.SucursalId = Sucursales.SucursalId WHERE Accesos.Ultimo >= '$inicio' AND Accesos.Ultimo <= '$fin'";
        echo $cadena;
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }
    public function uno($EmpleadoId)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT Empleado.*, Sucursales.Nombre as Sucursal, Roles.Rol FROM `Empleado` INNER JOIN Roles on Empleado.RolId = Roles.idRoles INNER JOIN Sucursales on Empleado.SucursalId = Sucursales.SucursalId  WHERE `EmpleadoId`=$EmpleadoId";

        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    public function unoCedula($Cedula)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM `Empleado` WHERE `Cedula`='$Cedula'";

        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    public function contarCedula($Cedula)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT count(*) as numero FROM `Empleado` WHERE `Cedula`='$Cedula'";

        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    public function unoCorreo($Correo)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM `Empleado` WHERE `Correo`='$Correo'";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    public function Insertar($Nombres, $Apellidos, $Direccion, $Telefono, $Cedula, $Correo, $idRoles, $SucursalId)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "INSERT into Empleado(`Nombres`, `Apellidos`, `Direccion`, `Telefono`, `Cedula`, `Correo`, `RolId`, `SucursalId`) values ( '$Nombres', '$Apellidos','$Direccion','$Telefono','$Cedula', '$Correo', $idRoles, $SucursalId)";

        if (mysqli_query($con, $cadena)) {
            return "ok";
        } else {
            return 'Error al insertar en la base de datos';
        }
        $con->close();
    }
    public function Actualizar($EmpleadoId, $Nombres, $Apellidos, $Direccion, $Telefono, $Cedula, $Correo, $idRoles, $SucursalId)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "UPDATE `Empleado` SET `Nombres`='$Nombres',`Apellidos`='$Apellidos',`Direccion`='$Direccion',`Telefono`='$Telefono',`Cedula`='$Cedula',`Correo`='$Correo',`RolId`='$idRoles',`SucursalId`='$SucursalId' WHERE `EmpleadoId`='$EmpleadoId'";
        if (mysqli_query($con, $cadena)) {
            return "ok";
        } else {
            return 'error al actualizar el registro';
        }
        $con->close();
    }
    public function Eliminar($EmpleadoId)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "delete from Empleado where EmpleadoId = $EmpleadoId";
        if (mysqli_query($con, $cadena)) {
            return "ok";
        } else {
            return false;
        }
        $con->close();
    }
}
