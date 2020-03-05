<?php

//incluimos configuración
include_once('../config/config.ini.php'); 

class Conexion  // se declara una clase para hacer la conexion con la base de datos
{
	var $conexion;

    public function conectar() {

        $this->conexion = mysqli_connect(HOST, USER, PASS, DBNAME);
        if (!$this->conexion ) DIE("Lo sentimos, no se ha podido conectar con MySQL: " . mysql_error());
		
		mysqli_set_charset($this->conexion,"utf8");

        return $this->conexion;

    }


	public function Close() { // cierra la conexion
	
		/*mysql_close($this->con);*/
		    if ($this->conexion) {
            mysqli_close($this->conexion);
        }
    }


	public function desconectar() { // cierra la conexion
	
		/*mysql_close($this->con);*/
		    if ($this->conexion) {
            mysqli_close($this->conexion);
        }
    }

		
}


?>