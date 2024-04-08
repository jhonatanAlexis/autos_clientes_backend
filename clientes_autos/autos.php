<?php
include('conn.php');

if(isset($_POST['accion'])){
    $accion = $_POST['accion'];
    if($accion == 'agregar'){
        if(isset($_POST['marca']) && isset( $_POST['modelo']) && isset( $_POST['año']) && isset($_POST['no_serie'])){
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $año = $_POST['año'];
            $no_serie = $_POST['no_serie'];

            $qry = "INSERT INTO Autos (marca, modelo, año, no_serie) values ('$marca','$modelo','$año', '$no_serie')";

            if($db->query($qry) == true){
                $response['status'] = 'Todo bien';
                $response['message'] = 'Se agrego un nuevo auto exitosamenete';
            }else{
                $response['status'] = 'Algo salio mal';
                $response['message'] = 'No se pudo agregar un auto nuevo';
            }
            echo json_encode($response);
        }
    }else if($accion == 'modificar'){
        if(isset($_POST['id']) && isset($_POST['marca']) && isset( $_POST['modelo']) && isset( $_POST['año']) && isset($_POST['no_serie'])){
            $id = $_POST['id'];
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $año = $_POST['año'];
            $no_serie = $_POST['no_serie'];

            $qry = "UPDATE Autos SET marca = '$marca',  modelo = '$modelo', año = '$año' , no_serie = '$no_serie' WHERE id_auto = '$id'";

            if($db->query($qry) == true){
                $response["status"] = "Todo bien";
                $response["message"] = "Se modifico exitosamente el auto";
            }else{
                $response["status"] = "Algo salio mal";
                $response["message"] = "No se pudo modificar el auto";
            }
            echo json_encode($response);
        }
    }else if($accion == 'eliminar'){
        if(isset($_POST['id'])){
            $id = $_POST['id'];

            $qry = "DELETE FROM Autos WHERE id_auto = '$id'";

            if($db->query($qry) == true){
                $response["status"] = "Todo bien";
                $response["message"] = "Se elimino el auto exitosamente";
            }else{
                $response["status"] = "Algo salio mal";
                $response["message"] = "No se pudo eliminar el auto";
            }
            echo json_encode($response);
        }
    }
}

if(isset($_GET['accion'])){
    $accion = $_GET['accion'];

    if($accion == 'obtener'){
        $qry = "SELECT * FROM Autos";

        $result = $db->query($qry);

        if($result->num_rows > 0){
            while($fila = $result->fetch_assoc()){
                $item['id'] = $fila['id_auto'];
                $item['marca'] = $fila['marca'];
                $item['modelo'] = $fila['modelo'];
                $item['año'] = $fila['año'];
                $item['no_serie'] = $fila['no_serie'];
                $resultado[] = $item;
            }
            $response['status'] = 'Todo bien';
            $response['message'] = $resultado;
        }else{
            $response['status'] = 'Algo salio mal';
            $response['message'] = 'No hay autos registrados';
        }
        echo json_encode($response);
    }
}