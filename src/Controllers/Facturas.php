<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Facturas {
    public function getAllFacturas ($request, $response, $args){
        $sql = "SELECT * FROM facturas";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $facturas = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($facturas);
        }else {
        echo json_encode("No existen facturas en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
}
    }

    public function getFactura ($request, $response, $args){
        $id_factura = $request->getAttribute('id');
        $sql = "SELECT * FROM facturas WHERE idFactura = $id_factura";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $factura = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($factura);
        }else {
        echo json_encode("No existen factura en la BBDD con este ID.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function createFactura ($request, $response, $args){
        $numFactura = $request->getParam('numFactura');
        $valorFactura = $request->getParam('valorFactura');
        $cantidad = $request->getParam('cantidad');
        
        $sql = "INSERT INTO facturas (numFactura, valorFactura, cantidad)
        VALUES (:numFactura, :valorFactura, :cantidad)";
        try{
          $db = new db();
          $db = $db->conectDB();
          $resultado = $db->prepare($sql);
        
          $resultado->bindParam(':numFactura', $numFactura);
          $resultado->bindParam(':valorFactura', $valorFactura);
          $resultado->bindParam(':cantidad', $cantidad);
        
          $resultado->execute();
          echo json_encode("Nueva factura ha sido guardado con éxito.");  
        
          $resultado = null;
          $db = null;
        }catch(PDOException $e){
          echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function updateFactura ($request, $response, $args){
        $id_factura = $request->getAttribute('id');
        $numFactura = $request->getParam('numFactura');
        $valorFactura = $request->getParam('valorFactura');
        $cantidad = $request->getParam('cantidad');
        
        $sql = "UPDATE facturas SET 
        numFactura = :numFactura, valorFactura = :valorFactura, cantidad = :cantidad
        WHERE idFactura = $id_factura";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        
        $resultado->bindParam(':numFactura', $numFactura);
        $resultado->bindParam(':valorFactura', $valorFactura);
        $resultado->bindParam(':cantidad', $cantidad);
        
        $resultado->execute();
        echo json_encode("Factura actualizada satisfactoriamente.");  
        
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function deleteFactura ($request, $response, $args){
        $id_factura = $request->getAttribute('id');
        $sql = "DELETE FROM facturas WHERE idFactura = $id_factura";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        $resultado->execute();
        
        if ($resultado->rowCount() > 0){
        echo json_encode("Factura eliminada para siempre.");
        } else {
        echo json_encode("No existe factura con este ID.");  
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }
}