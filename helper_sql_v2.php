<?php
include_once 'conexion_v2.php';


	#Verifica si existe una tabla en la BD. Retorna 1 si existe, 0 si no existe
	function check_table($table){

		$conn = Conexion::getInstance()->conectar();

		$SQL = "	SELECT count(*) FROM information_schema.tables 
					WHERE table_schema = '".DBNAME."' AND table_name = '$table' ";

		$result = mysqli_query($conn, $SQL) ;    
		if ($result) {  
			$data = mysqli_fetch_array($result);
		}

		//echo $data[0] ; die($SQL);

		Conexion::getInstance()->desconectar();

		return $data[0];
	}



	#Crea una tabla en la bd con los valores que toma del array $atributos 
	#toma el id como nombres de las columnas y como tipo de dato el valor de los atributos
	#EJ: $atributos=("nombre"=>"varchar(10)","edad"=>"int");
	#Retorna 1 si la consulta se realizó con exito.
	function create_table($table_name, $atributos){

		$conn = Conexion::getInstance()->conectar();

		$atributos_sql="";

		foreach ($atributos as $key => $value) {
			
			$atributos_sql .= $key." ".$value.",";
		}

		$atributos_sql = substr($atributos_sql,0,-1);//para eliminar la ultima coma

		//die($atributos_sql);

		$SQL = " CREATE TABLE $table_name ( id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,

				 $atributos_sql
				
				  ) ENGINE = InnoDB; ";

		$result = mysqli_query($conn, $SQL) ; 
		
		//die($SQL);
		
		Conexion::getInstance()->desconectar();

		return $result;
	}



	#Inserta en la tabla $table_name los valores del array $data, el cual debe tener la estructura de 
	#la tabla: la key como el nombre de la columna y los value como los datos. Retorna el id del nuevo dato.
	function insert_data($table_name, $data){

		//die(var_dump($data) );

		$conn = Conexion::getInstance()->conectar();

		foreach ($data as $key => $value) {
			
			@$atributos_sql .= $key.",";
			@$values_sql .= "'".$value."',";
		}

		$atributos_sql = substr($atributos_sql,0,-1);//para eliminar la ultima coma
		$values_sql = substr($values_sql,0,-1);//para eliminar la ultima coma

		//die($atributos_sql);

		$SQL = " INSERT INTO $table_name ($atributos_sql)
				 VALUES ($values_sql)";

		$result = mysqli_query($conn, $SQL) ;  

		//obtenemos en numero de id que se genero
		$query2 = "SELECT MAX(id) AS id FROM $table_name"; 
			
		$result =  mysqli_query($conn, $query2); // ejecuta la consulta para recuperar el id
			
		$row = @mysqli_fetch_array($result);
		$id = $row['id'];

		Conexion::getInstance()->desconectar();

		return $id;	
	}



	#Recibe un nombre de tabla y un id y retona como resultado un array con los datos de la tupla correspondiente.
	function select_data($table_name, $id){

		$conn = Conexion::getInstance()->conectar();

		$SQL = "SELECT * FROM $table_name WHERE id = $id";

		$result = mysqli_query($conn, $SQL) ;  

		if ($result) {  
			$data = mysqli_fetch_assoc($result);
		}	

		Conexion::getInstance()->desconectar();

		return $data;	
	}



	#Recibe el nombre de una tabla y como resultado retorna un array de arrays completado con los datos de la tabla.
	function select_all($table_name){

		$conn = Conexion::getInstance()->conectar();

		$array = array();

		$SQL = "SELECT * FROM $table_name";

		$result = mysqli_query($conn, $SQL);

		//die($SQL);

		if ($result) {  

			while ( $rows = mysqli_fetch_assoc($result) ){

				$array[$rows['id']] = $rows;
			}
		}	

		Conexion::getInstance()->desconectar();

		return $array;
	}


	#Modifica una tupla completa de la tabla $table_name, reeplazando sus datos por los del array $data, 
	#el campo id no se modifica. Retorna 1 si la consulta se realizó con exito.
	function update_data($table_name, $data){

		$conn = Conexion::getInstance()->conectar();

		foreach ($data as $key => $value) {
			
			@$set_sql.=$key."='".$value."',";
		}

		$set_sql = substr($set_sql,0,-1);//para eliminar la ultima coma

		$SQL = " UPDATE $table_name
				 SET $set_sql 
				 WHERE id=".$data['id'];

		//die($SQL);

		$result = mysqli_query($conn, $SQL) ;

		Conexion::getInstance()->desconectar();

		return $result;	
	}



	#Recibe una tabla y u id y elimina la fila correspondiente.
	#Retorna 1 si la consulta se realizó con exito.
	function delete_data($table_name, $id){

		$conn = Conexion::getInstance()->conectar();

		$SQL = " DELETE FROM $table_name 
				 WHERE id = $id";

		$result = mysqli_query($conn, $SQL) ;	

		Conexion::getInstance()->desconectar();

		return $result;	
	}



	#ejecuta una consulta sql recibida y retorna su resultado en forma de array
	function executeQuery($SQL){

		$conn = Conexion::getInstance()->conectar();

		$result = mysqli_query($conn, $SQL) ;

		if (mysqli_num_rows($result) > 1) {  

			while ( $rows = mysqli_fetch_assoc($result) ){

				$array[$rows['id']] = $rows;
			}
		}
		else{
			$array = mysqli_fetch_assoc($result);
		}

		Conexion::getInstance()->desconectar();

		return $array;
	}

