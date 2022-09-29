<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Vehiculos {
    public function getAllVehiculos ($request, $response, $args){
        $sql = "SELECT * FROM vehiculos";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $vehiculos = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($vehiculos);
        }else {
        echo json_encode("No existen vehiculos en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getVehiculo ($request, $response, $args){
        $id_vehiculo = $request->getAttribute('id');
        $sql = "SELECT * FROM vehiculos WHERE idVehiculo = $id_vehiculo";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $vehiculo = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($vehiculo);
        }else {
        echo json_encode("No existen vehículo en la BBDD con este ID.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function createVehiculo ($request, $response, $args){
        $marca = $request->getParam('marca');
        $placa = $request->getParam('placa');
        $modelo = $request->getParam('modelo');
        $numChasis = $request->getParam('numChasis');
        $numMotor = $request->getParam('numMotor');
        $pesoBruto = $request->getParam('pesoBruto');

        $sql = "INSERT INTO vehiculos (marca, placa, modelo, numChasis, numMotor, pesoBruto)
        VALUES (:marca, :placa, :modelo, :numChasis, :numMotor, :pesoBruto)";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':marca', $marca);
        $resultado->bindParam(':placa', $placa);
        $resultado->bindParam(':modelo', $modelo);
        $resultado->bindParam(':numChasis', $numChasis);
        $resultado->bindParam(':numMotor', $numMotor);
        $resultado->bindParam(':pesoBruto', $pesoBruto);

        $resultado->execute();
        echo json_encode("Nuevo vehiculo ha sido guardado con éxito.");  

        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function updateVehiculo ($request, $response, $args){
        $id_vehiculo = $request->getAttribute('id');
        $marca = $request->getParam('marca');
        $placa = $request->getParam('placa');
        $modelo = $request->getParam('modelo');
        $numChasis = $request->getParam('numChasis');
        $numMotor = $request->getParam('numMotor');
        $pesoBruto = $request->getParam('pesoBruto');

        $sql = "UPDATE vehiculos SET 
        marca = :marca, placa = :placa, modelo = :modelo, numChasis = :numChasis,
        numMotor = :numMotor, pesoBruto = :pesoBruto
        WHERE idVehiculo = $id_vehiculo";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 

        $resultado->bindParam(':marca', $marca);
        $resultado->bindParam(':placa', $placa);
        $resultado->bindParam(':modelo', $modelo);
        $resultado->bindParam(':numChasis', $numChasis);
        $resultado->bindParam(':numMotor', $numMotor);
        $resultado->bindParam(':pesoBruto', $pesoBruto);

        $resultado->execute();
        echo json_encode("Vehículo actualizado satisfactoriamente.");  

        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function deleteVehiculo ($request, $response, $args){
        $id_vehiculo = $request->getAttribute('id');
        $sql = "DELETE FROM vehiculos WHERE idVehiculo = $id_vehiculo";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        $resultado->execute();
        
        if ($resultado->rowCount() > 0){
            echo json_encode("Vehículo eliminado para siempre.");
            } else {
            echo json_encode("No existe vehículo con este ID.");  
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
            echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }
}