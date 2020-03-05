<?php
include_once 'conexion.php';



	#Verifia si existe una tabla en la BD, retorna 1 si existe, 0 si no existe
	function check_table($table){

		$conexion = new Conexion();
		$conn = $conexion->conectar();

		$SQL = "	SELECT count(*) FROM information_schema.tables 
					WHERE table_schema = '".DBNAME."' AND table_name = '$table' ";

		$result = mysqli_query($conn, $SQL) ;    
		if ($result) {  
			$data = mysqli_fetch_array($result);
		}

		//echo $data[0] ; die($SQL);

		$conexion->desconectar();

		return $data[0];
	}



	#Crea una tabla en la bd con los atributos que toma del array $atributos como nombres de las columnas.
	#Retorna 1 si la consulta se realizó con exito.
	function create_table($table_name, $atributos){

		$conexion = new Conexion();
		$conn = $conexion->conectar();

		foreach ($atributos as $key => $value) {
			
			@$atributos_sql .= $key." ".$value.",";
		}

		$atributos_sql = substr($atributos_sql,0,-1);//para eliminar la ultima coma

		//die($atributos_sql);

		$SQL = " CREATE TABLE $table_name ( id BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,

				 $atributos_sql
				
				  ) ENGINE = InnoDB; ";

		$result = mysqli_query($conn, $SQL) ;  
		
		$conexion->desconectar();

		return $result;
	}



	#Inserta en la tabla $table_name los valores del array $data, el cual debe tener la estructura de 
	#la tabla: la key el nombre de la columna y los value como los datos. Retorna el id del nuevo dato.
	function insert_data($table_name, $data){

		//die(var_dump($data) );

		$conexion = new Conexion();
		$conn = $conexion->conectar();

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

		$conexion->desconectar();

		return $id;	
	}



	#Recibe una sentencia sql con un select que debe esperar un array como resultado, 
	#equivalente a una busqueda de una unica tupla de la BD
	function select_data($SQL){

		$conexion = new Conexion();
		$conn = $conexion->conectar();

		$result = mysqli_query($conn, $SQL) ;  

		if ($result) {  
			$data = mysqli_fetch_assoc($result);
		}	

		$conexion->desconectar();

		return $data;	
	}



	#Recibe una sentencia sql con un select que debe esperar un array de arrays como resultado, 
	#equivalente a una busqueda de multiples resultados de la BD.
	function select_all($SQL){

		$conexion = new Conexion();
		$conn = $conexion->conectar();

		$result = mysqli_query($conn, $SQL) ;  

		if ($result) {  

			while ( $rows = mysqli_fetch_assoc($result) ){

				$array[$rows['id']] = $rows;
			}
		}	

		$conexion->desconectar();

		return $array;	
	}



	#Modifica una tupla completa de la tabla $table_name, reeplazando sus datos por los del array $data, 
	#el campo id no se modifica. Retorna 1 si la consulta se realizó con exito.
	function update_data($table_name, $data){

		$conexion = new Conexion();
		$conn = $conexion->conectar();

		foreach ($data as $key => $value) {
			
			@$set_sql.=$key."='".$value."',";
		}

		$set_sql = substr($set_sql,0,-1);//para eliminar la ultima coma

		$SQL = " UPDATE $table_name
				 SET$set_sql 
				 WHERE id=".$data['id'];

		$result = mysqli_query($conn, $SQL) ;

		$conexion->desconectar();

		return $result;	
	}



	#Recibe una tabla y u id y elimina la fila correspondiente.
	#Retorna 1 si la consulta se realizó con exito.
	function delete_data($table_name, $id){

		$conexion = new Conexion();
		$conn = $conexion->conectar();

		$SQL = " DELETE FROM $table_name 
				 WHERE id = $id";

		$result = mysqli_query($conn, $SQL) ;	

		$conexion->desconectar();

		return $result;	
	}



	#ejecuta una consulta sql recibida y retorna su resultado
	function executeQuery($SQL){

		$conexion = new Conexion();
		$conn = $conexion->conectar();

		$result = mysqli_query($conn, $SQL) ;	

		$conexion->desconectar();

		return $result;	
	}

