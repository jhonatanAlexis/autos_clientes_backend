<?php
include('conn.php');

//isset se usa para saber si una variable esta definida y no es nula
if(isset($_POST['accion'])){ 
//$_POST es una variable superglobal que se usa para recoger datos enviados desde un formulario html usando el metodo POST. Cuando un formulario html se envía con el método POST, los datos del formulario se almacenan en el array $_POST
//se verifica que se haya enviado un valor para el parametro 'accion' en el formulario html usando el metodo POST
//$_POST['accion'] es una forma de acceder al valor del campo 'accion' enviado a través del formulario html, esto quiere decir que se espera que el formulario tenga un campo llamado accion (no necesita estar inicializado, es con el isset que se verifica que ya se haya inicilizado)

    $accion = $_POST['accion']; //si esta definido se le otorga ese valor del campo a la variable $accion

    if($accion == 'agregar'){
        if(isset($_POST['nombre']) && isset($_POST['email'])){ //lo mismio que if(isset($_POST['accion'])), se verifica que a traves de un formulario enviado con el metodo post haya un campo inicializado para 'nombre' e 'email'
            $nombre = $_POST['nombre'];
            $email = $_POST['email']; //lo mismo, se le agregan esos campos a estas variables

            $qry = "INSERT INTO Clientes (nombre, email) values ('$nombre', '$email')"; //$qry es donde se almacena la consulta
            if($db->query($qry) == true){ //se ejecuta la consulta sql en la base de datos con el metodo query (este envia la consulta a la base de datos) y accede a esta la varibale de la conexion de la base de datps $db
                $response['status'] = 'Todo bien'; //arreglos asociativos (en lugar de indice tiene un texto) asocia pares clave-valor
                $response['message'] = 'Se agreglo exitosamenete el cliente'; //se usa un arreglo en lugar de mandar un simple mensaje con echo para que este mas organizado, mandar informacion adicional y por apis y devolver en formato json
            } else{
                $response['status'] = 'Algo salio mal';
                $response['message'] = 'No se pudo agregar al cliente por un error';
            }
            echo json_encode($response); // se imprimen los mensajes en formato json con json_encode
        }
    }else if($accion == 'eliminar'){
        if(isset($_POST['id'])){
            $id = $_POST['id'];
            $qry = "DELETE FROM Clientes WHERE id_cliente = '$id'";
            if($db->query($qry) == true){
                $response["status"] = 'Todo bien';
                $response["message"] = 'Se elimino exitosamente el cliente';
            }else{
                $response["status"] = 'Algo salio mal';
                $response["message"] = 'No se pudo eliminar al cliente';
            }
            echo json_encode($response);   
        }
    }else if($accion == 'modificar'){
        if(isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['email'])){
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $qry = "UPDATE Clientes SET nombre = '$nombre', email = '$email' WHERE id_cliente = '$id'";
            if($db->query($qry) == true){
                $response["status"] = "Todo bien";
                $response["message"] = "Se modifico con exito el cliente";
            }else{
                $response["status"] = "Algo salio mal";
                $response["message"] = "No se pudo modificar el cliente";
            }
            echo json_encode($response);
        }
    }
}

//para get se envia por medio de la url
if(isset($_GET['accion'])){
    $accion = $_GET['accion'];
    if($accion == 'obtener'){
        $qry = "SELECT * FROM Clientes";
        $result = $db->query($qry); //se le asigna a la variable result la ejecucion de la sentencia sql
        if($result->num_rows > 0){ //num_rows es propiedad de mysqli y esta asociada con consultas select, este contiene el numero de filas que la consulta ha devuelto, si el numero de filas es mayor que cero significa que se encontraron resultados de la consulta
            while($fila = $result->fetch_assoc()){ //fetch_assoc es un metodo de mysqli y se usa para obtener la siguiente fila de resultados de una consulta select en forma de arreglo asociativo, esto se almacena en la variable $fila
                //mientras haya una fila que se devuelva se continua con el bucle (si ya no hay mas filas fetch_assoc devolvera null)

                //arreglos asociativos
                $item['id'] = $fila['id_cliente'];
                $item['nombre'] = $fila['nombre']; //ya que $fila es un arreglo asociativo, se acceden a los valores por medio de sus claves ($fila['nombre']) y se almacenan esos valores en los nuevos arreglos asociativos $item
                $item['email'] = $fila['email'];
                $resultado[] = $item; //se almacenan los datos en el nuevo arreglo $result
            }
            $response['status'] = 'Todo bien';
            $response['message'] = $resultado;
        }else{
            $response['status'] = 'Algo salio mal';
            $response['message']  = 'No hay clientes';
        }
        echo json_encode($response);
    }
}