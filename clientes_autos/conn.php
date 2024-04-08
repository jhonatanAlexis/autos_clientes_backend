<?php
//la diferencia entre comillas simples y dobles es que las simples interpretara lo que esta en la cadena de texto de forma literal ejemplo si pongo hola $juan se interpretara lieral asi, en cambio con las dobles no, si una variblae %nombre = juan y luego en las comillas dobles pongo hola $nombre se pondra hola, juan
$db_host = 'localhost';
$db_user = 'jhonatan';
$db_password = 'Undertaker_01';
$db_database = 'venta_autos';

$db = new mysqli($db_host, $db_user, $db_password, $db_database);
mysqli_query($db, "SET NAMES 'utf8'"); // utf9 = asegurarse de que se manejen correctamente los caracteres especiales

//-> es obligatoria cuando se accede a propiedades o métodos de un objeto
if($db->connect_errno > 0){ //se verifica si hay un error con la conexion a la base de datos con connect_errno (propiedad de mysqli), si la conexion es exitosa connect_erno sera 0, por eso se pone > 0 porque si no es 0 es que hubo error (depende del numero que arroje ya que pueden ser muchos se vera por que es el error)
    die('No es posible conectase a la base de datos ['. $db->connect_error .']'); //die toma un argumento OPCIONAL que es el mensaje que saldrá y se usa para terminar la ejecutacion abruptamente si el error es tan critico que no se peude continuar puesto que detiene todo
    //el codigo muestra el tipo de error, el punto es de concatenacion
    //igual podria ser: die("No es posible conectase a la base de datos [$db->connect_error]");
}