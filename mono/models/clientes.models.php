<?php
require_once('../config/conexion.php');

class Clientes
{
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM clientes ORDER BY id DESC";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function uno($idCliente)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM clientes WHERE id = $idCliente";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function Insertar($nombres, $apellidos, $telefono, $correo)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();

        $telefono = $telefono == '' ? "NULL" : "'$telefono'";
        $correo   = $correo   == '' ? "NULL" : "'$correo'";

        $cadena = "INSERT INTO clientes (nombres, apellidos, telefono, correo_electronico, fecha_creacion)
                   VALUES ('$nombres', '$apellidos', $telefono, $correo, CURRENT_TIMESTAMP())";

        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $error = mysqli_error($con);
            $con->close();
            return 'error: ' . $error;
        }
    }

    public function Actualizar($id, $nombres, $apellidos, $telefono, $correo)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();

        $telefono = $telefono == '' ? "NULL" : "'$telefono'";
        $correo   = $correo   == '' ? "NULL" : "'$correo'";

        $cadena = "UPDATE clientes SET 
                        nombres = '$nombres',
                        apellidos = '$apellidos',
                        telefono = $telefono,
                        correo_electronico = $correo
                   WHERE id = $id";

        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $error = mysqli_error($con);
            $con->close();
            return 'error: ' . $error;
        }
    }

    public function Eliminar($idCliente)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "DELETE FROM clientes WHERE id = $idCliente";

        if (mysqli_query($con, $cadena)) {
            $con->close();
            return 'ok';
        } else {
            $error = mysqli_error($con);
            $con->close();
            return 'error: ' . $error;
        }
    }
}