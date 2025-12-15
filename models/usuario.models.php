<?php
//TODO: Requerimientos 
require_once('../config/conexion.php');

class Usuarios
{
    /*TODO: Procedimiento para sacar todos los registros*/
    public function todos()
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT usuarios.*, roles.id as IdRol, roles.nombre FROM `usuarios` inner JOIN roles on usuarios.id_rol = roles.id where usuarios.activo = 1";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
    /*TODO: Procedimiento para sacar un registro*/
    public function uno($idUsuarios)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM `usuarios` inner JOIN roles on usuarios.id_rol = roles.id where usuarios.id_rol =  $idUsuarios and usuarios.activo = 1";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
   
    public function unoNombreUsuario($NombreUsuario) 
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "SELECT * FROM `usuarios` WHERE `nombre_usuario`='$NombreUsuario' and activo = 1";
        $datos = mysqli_query($con, $cadena);
        return $datos;
        $con->close();
    }
   
    /*TODO: Procedimiento para insertar */
    public function Insertar($nombre_usuario, $contrasena, $id_rol)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "INSERT into usuarios(nombre_usuario, contrasena, id_rol, fecha_creacion, activo) 
        values ( '$nombre_usuario', '$contrasena', $id_rol, curdate(), 1)";
        if (mysqli_query($con, $cadena)) {
            return 'ok';
        } else {
            return 'Error al insertar en la base de datos';
        }
        $con->close();
    }
   

    /*TODO: Procedimiento para actualizar */
    public function Actualizar($idUsuarios, $nombre_usuario, $contrasena, $id_rol)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "update usuarios set nombre_usuario='$nombre_usuario', contrasena='$contrasena', id_rol=$id_rol, fecha_creacion=curdate() where id= $idUsuarios";
      
        if (mysqli_query($con, $cadena)) {

            return 'ok';
        } else {
            return 'error al actualizar el registro';
        }
        $con->close();
    }
    /*TODO: Procedimiento para Eliminar */
    public function Eliminar($idUsuarios)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "DELETE FROM `usuarios` WHERE id = $idUsuarios";
      
        if (mysqli_query($con, $cadena)) {
            return 'ok';
        } else {
            return false;
        }
        $con->close();
    }
    /*TODO: Procedimiento para Eliminar */
    public function Eliminarsuave($idUsuarios)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        $cadena = "UPDATE `usuarios` SET `activo`=0 WHERE id = $idUsuarios";
        if (mysqli_query($con, $cadena)) {
            return 'ok';
        } else {
            return false;
        }
        $con->close();
    }

     public function login1($nombre_usuario, $contrasena){
        
        try{
             $con = new ClaseConectar();
       
        $con = $con->ProcedimientoConectar();
       
        $cadena = "select * from usuarios where nombre_usuario='$nombre_usuario' and contrasena='$contrasena'";
  
        $datos = mysqli_query($con,$cadena);
        $con->close();
        return $datos;
        }
        catch(Throwable $th){
            echo 'Error en el try ' . $th->getMessage();
        }
       
    }
    public function login2($nombre_usuario){
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        // Se obtiene información del usuario y del rol con alias para evitar colisiones de nombres
        $cadena = "SELECT usuarios.id AS usuario_id, usuarios.nombre_usuario, usuarios.contrasena, usuarios.id_rol, roles.nombre AS rol_nombre, roles.descripcion AS rol_descripcion FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id WHERE usuarios.nombre_usuario='$nombre_usuario' LIMIT 1";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    // Nuevo método login (usuario + contraseña) para validar credenciales y devolver fila
    public function login($nombre_usuario, $contrasenia)
    {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoConectar();
        // Obtiene la fila del usuario
        $cadena = "SELECT usuarios.id AS usuario_id, usuarios.nombre_usuario, usuarios.contrasena, usuarios.id_rol, roles.nombre AS rol_nombre, roles.descripcion AS rol_descripcion FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id WHERE usuarios.nombre_usuario='$nombre_usuario' LIMIT 1";
        $datos = mysqli_query($con, $cadena);
        $fila = mysqli_fetch_assoc($datos);
        $con->close();
        return $fila; // retorna array asociativo o null
    }
}
