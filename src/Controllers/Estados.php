<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Estados {
    public function getAllEstados ($request, $response, $args){
        $sql = "SELECT * FROM estados";
        try{
            $db = new db();
            $db = $db->conectDB(); 
            $resultado = $db->query($sql);

            if ($resultado->rowCount() > 0){
            $estados = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($estados);
            } else {
            echo json_encode("No existen estados en la BBDD.");
            }
            $resultado = null;
            $db = null;
        }catch(PDOException $e){
            echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getEstado ($request, $response, $args){
        $id_estado = $request->getAttribute('id');
        $sql = "SELECT * FROM estados WHERE idEstado = $id_estado";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
            $estado = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($estado);
        }else {
            echo json_encode("No existe estado en la BBDD con este ID.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function createEstado ($request, $response, $args){
        $nombre = $request->getParam('nombreEstado');

        $sql = "INSERT INTO estados (nombreEstado) VALUES (:nombreEstado)";
        $sql2 = "SELECT nombreEstado FROM estados WHERE nombreEstado = '$nombre'";
        try{
          $db = new db();
          $db = $db->conectDB();
          $resultado = $db->prepare($sql); 
          $consulta = $db->query($sql2); 
         
          if ($consulta->rowCount() > 0){
            echo json_encode("Ya existe la ciudad en la BBDD.");
           } else {
           $resultado->bindParam(':nombreEstado', $nombre);
           $resultado->execute();
           echo json_encode("Nuevo estado guardado.");  
         }
          $resultado = null;
          $db = null;
        }catch(PDOException $e){
          echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function updateEstado ($request, $response, $args){
        $id_estado = $request->getAttribute('id');
        $nombre = $request->getParam('nombreEstado');
        
        $sql = "UPDATE estados SET nombreEstado = :nombreEstado WHERE idCiudad = $id_estado";
        $sql2 = "SELECT nombreEstado FROM estados WHERE nombreEstado = '$nombre'";
        try{
         $db = new db();
         $db = $db->conectDB();
         $resultado = $db->prepare($sql); 
         $consulta = $db->query($sql2); 
        
         if ($consulta->rowCount() > 0){
           echo json_encode("Ya existe el estado en la BBDD.");
          } else {
          $resultado->bindParam(':nombreEstado', $nombre);
          $resultado->execute();
          echo json_encode("Estado actualizado.");  
        }
         $resultado = null;
         $db = null;
        }catch(PDOException $e){
         echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function deleteEstado ($request, $response, $args){
        $id_estado = $request->getAttribute('id');

        $sql = "DELETE FROM estados WHERE idEstado = $id_estado";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        $resultado->execute();

        if ($resultado->rowCount() > 0){
        echo json_encode("Estado eliminado para siempre.");
        } else {
        echo json_encode("No existe estado con este ID.");  
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }
}