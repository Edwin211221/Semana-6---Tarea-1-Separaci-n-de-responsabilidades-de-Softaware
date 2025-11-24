<?php
//TODO: Requerimientos 
require_once('../config/conexion.php');
class Sucursales
{
    /*TODO: Procedimiento para sacar todos los registros*/
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM `Sucursales`";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    /*TODO: Procedimiento para sacar un registro*/
    public function uno($SucursalId)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM `Sucursales` WHERE `SucursalId`=$SucursalId";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    /*TODO: Procedimiento para insertar */
    public function Insertar($Nombre, $Direccion, $Telefono, $Correo, $Parroquia, $Canton, $Provincia)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "INSERT INTO `Sucursales`(`Nombre`, `Direccion`, `Telefono`, `Correo`, `Parroquia`, `Canton`, `Provincia`) VALUES('$Nombre','$Direccion','$Telefono','$Correo','$Parroquia','$Canton','$Provincia')";

        if (mysqli_query($con, $cadena)) {
            return "ok";
        } else {
            return mysqli_error($con);
        }
        $con->close();
    }
    /*TODO: Procedimiento para actualizar */
    public function Actualizar($SucursalId, $Nombre, $Direccion, $Telefono, $Correo, $Parroquia, $Canton, $Provincia)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "UPDATE `Sucursales` SET `Nombre`='$Nombre',`Direccion`='$Direccion',`Telefono`='$Telefono',`Correo`='$Correo',`Parroquia`='$Parroquia',`Canton`='$Canton',`Provincia`='$Provincia' WHERE `SucursalId`=$SucursalId";
        if (mysqli_query($con, $cadena)) {
            return "ok";
        } else {
            return 'error al actualizar el registro';
        }
        $con->close();
    }
    /*TODO: Procedimiento para Eliminar */
    public function Eliminar($SucursalId)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "DELETE FROM `Sucursales` WHERE `SucursalId`=$SucursalId";
        if (mysqli_query($con, $cadena)) {
            return "ok";
        } else {
            return false;
        }
        $con->close();
    }
}
//CRUD