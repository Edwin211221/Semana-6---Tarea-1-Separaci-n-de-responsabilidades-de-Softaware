<?php
require_once('../config/conexion.php');

class Vehiculos
{
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();

        $sql = "SELECT v.*, CONCAT(c.nombres,' ',c.apellidos) AS cliente
                FROM vehiculos v
                LEFT JOIN clientes c ON c.id = v.id_cliente
                ORDER BY v.id DESC";

        $datos = mysqli_query($con, $sql);
        $con->close();
        return $datos;
    }

    public function uno($id)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();

        $id = intval($id);
        $sql = "SELECT * FROM vehiculos WHERE id = $id";
        $datos = mysqli_query($con, $sql);
        $con->close();
        return $datos;
    }

    public function Insertar($id_cliente, $marca, $modelo, $anio, $tipo_motor)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();

        $id_cliente = intval($id_cliente);
        $anio = intval($anio);
        $marca  = mysqli_real_escape_string($con, $marca);
        $modelo = mysqli_real_escape_string($con, $modelo);
        $tipo_motor = mysqli_real_escape_string($con, $tipo_motor);

        $sql = "INSERT INTO vehiculos (id_cliente, marca, modelo, anio, tipo_motor, fecha_creacion)
                VALUES ($id_cliente, '$marca', '$modelo', $anio, '$tipo_motor', CURRENT_TIMESTAMP())";

        if (mysqli_query($con, $sql)) {
            $id = mysqli_insert_id($con);
            $con->close();
            return $id; // >0 OK
        } else {
            $con->close();
            return 0; // error
        }
    }

    public function Actualizar($id, $id_cliente, $marca, $modelo, $anio, $tipo_motor)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();

        $id = intval($id);
        $id_cliente = intval($id_cliente);
        $anio = intval($anio);
        $marca  = mysqli_real_escape_string($con, $marca);
        $modelo = mysqli_real_escape_string($con, $modelo);
        $tipo_motor = mysqli_real_escape_string($con, $tipo_motor);

        $sql = "UPDATE vehiculos SET
                    id_cliente = $id_cliente,
                    marca = '$marca',
                    modelo = '$modelo',
                    anio = $anio,
                    tipo_motor = '$tipo_motor'
                WHERE id = $id";

        if (mysqli_query($con, $sql)) {
            $con->close();
            return "ok";
        } else {
            $con->close();
            return "error";
        }
    }

    public function Eliminar($id)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();

        $id = intval($id);
        $sql = "DELETE FROM vehiculos WHERE id = $id";

        if (mysqli_query($con, $sql)) {
            $con->close();
            return "ok";
        } else {
            $con->close();
            return "error";
        }
    }
}