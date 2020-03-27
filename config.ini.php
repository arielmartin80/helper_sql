<?php
/* 
 * Configuración general: conexión a la base de datos y otro parámetros
 */

 /************** Config Deploy **************

define('HOST',"localhost");
define('USER',"");
define('PASS',"");
define('DBNAME',"");

/********************************************/ 
 
/************** Config Desarrollo ***************/
  
define('HOST','localhost'); //servidor de la base de datos
define('USER','root'); //usuario de la base de datos
define('PASS',''); //la clave para conectar
define('DBNAME','test'); // indica el nombre de la base de datos que contiene la tabla de los usuarios

/********************************************/ 

//método utilizado para almacenar la contraseña encriptada. Opciones: sha1, md5, o texto
define('METODO_ENCRIPTACION_CLAVE','texto');

/************** define la URL del sitio ***************/

define('URL','');

/********************************************/ 

?>
