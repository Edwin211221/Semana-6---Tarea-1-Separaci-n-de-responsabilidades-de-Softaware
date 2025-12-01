<?php
class ClaseConectar
{
    private $host = "localhost";
    private $usu  = "root";
    private $clave = "";
    private $base = "mecanica";

    public function ProcedimientoConectar()
    {
        $con = new mysqli($this->host, $this->usu, $this->clave, $this->base);

        if ($con->connect_errno) {
            die("Error de conexión MySQL: " . $con->connect_error);
        }

        // UTF-8 correcto
        $con->set_charset("utf8");

        return $con;
    }
}
?>