<?php
include('conn.php');

if(isset($_POST['accion'])){
    $accion = $_POST['accion'];
    if($accion == 'agregar'){
        if(isset($_POST['id_auto']) && isset($_POST['id_cliente'])){
            $id_auto = $_POST['id_auto'];
            $id_cliente = $_POST['id_cliente'];
            $qry = "INSERT INTO Propiedades (propiedad_id_auto, propiedad_id_cliente) values ('$id_auto','$id_cliente')";
            if($db->query($qry) == true){
                $response['status'] = 'Todo bien';
                $response['message'] = 'Se agrego con exito';
            }else{
                $response['status'] = 'Algo salio mal';
                $response['message'] = 'No se pudo agregar';
            }
            echo json_encode($response);
        }
    }else if($accion == 'eliminar'){
        if(isset($_POST['id'])){
            $id = $_POST['id'];
            $qry = "DELETE FROM Propiedades WHERE id = '$id'";
            if($db->query($qry) == true){
                $response['status'] = 'Todo bien';
                $response['message'] = 'Se elimino con exito';
            }else{
                $response['status'] = 'Algo salio mal';
                $response['message'] = 'No se pudo eliminar';
            }
            echo json_encode($response);
        }
    }else if($accion == 'modificar'){
        if(isset($_POST['id']) && isset($_POST['id_cliente']) && isset($_POST['id_auto'])){
            $id = $_POST['id'];
            $id_auto = $_POST['id_auto'];
            $id_cliente = $_POST['id_cliente'];
            $qry = "UPDATE Propiedades SET propiedad_id_cliente = '$id_cliente', propiedad_id_auto = '$id_auto' WHERE id = '$id'";
            if($db->query($qry) == true){
                $response["status"] = "Todo bien";
                $response["message"] = "Se modifico con exito";
            }else{
                $response["status"] = "Algo salio mal";
                $response["message"] = "No se pudo modificar";
            }
            echo json_encode($response);
        }
    }
}

if(isset($_GET['accion'])){
    $accion = $_GET['accion'];
    if($accion == 'obtener'){
        $sql = "SELECT Propiedades.id, Clientes.nombre, Clientes.email, Autos.marca, Autos.modelo, Autos.año, Autos.no_serie 
                FROM Propiedades 
                JOIN Clientes ON (Propiedades.propiedad_id_cliente = Clientes.id_cliente)
                JOIN Autos ON (Propiedades.propiedad_id_auto = Autos.id_auto)
                WHERE 1";
        $result = $db->query($sql);

        if($result->num_rows > 0){
            while($fila = $result->fetch_assoc()){
                $item['id'] = $fila['id'];
                $item['nombre'] = $fila['nombre'];
                $item['email'] = $fila['email'];
                $item['marca'] = $fila['marca'];
                $item['modelo'] = $fila['modelo'];
                $item['año'] = $fila['año'];
                $item['no_serie'] = $fila['no_serie'];
                $resultado[] = $item;
            }
            $response['status'] = 'Todo bien';
            $response['message'] = $resultado;
        }else{
            $response['status'] = 'Error';
            $response['message'] = 'No hay registro';
        }
        echo json_encode($response);
    }
}