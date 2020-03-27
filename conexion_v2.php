<?php

//incluimos configuracion
include_once('config.ini.php'); 


//Se declara una clase para hacer la conexion con la base de datos
//para llamar siempre a la misma instancia utilizamos la siguiente forma: Conexion::getInstance()->conectar();

class Conexion  {

	var $conexion;
	private static $instance;


    public static function getInstance() {

        if (!self::$instance instanceof self) {

            self::$instance = new self();
        }

        return self::$instance;
    }



    public function conectar() {

        $this->conexion = mysqli_connect(HOST, USER, PASS, DBNAME);
        if (!$this->conexion ) DIE("Lo sentimos, no se ha podido conectar con MySQL: " . mysql_error());
		
		//mysqli_set_charset($this->conexion,"utf8");

		$this->conexion->set_charset("utf8");

        return $this->conexion;
    }


	public function desconectar() { // cierra la conexion
	
		    if ($this->conexion) {
            mysqli_close($this->conexion);
        }
    }

		
}


?>