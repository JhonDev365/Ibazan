<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Modulos {
    public function getAllModulos ($request, $response, $args){
        $sql = "SELECT * FROM modulos";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);
        
        if ($resultado->rowCount() > 0){
          $modulos = $resultado->fetchAll(PDO::FETCH_OBJ);
          echo json_encode($modulos);
        }else {
          echo json_encode("No existen modulos en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getModulo ($request, $response, $args){
        $id_modulo = $request->getAttribute('id');
        $sql = "SELECT * FROM modulos WHERE idModulo = $id_modulo";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $modulo = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($modulo);
        }else {
        echo json_encode("No existen modulos en la BBDD con este ID.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function createModulo ($request, $response, $args){
        $nombreModulo = $request->getParam('nombreModulo');
        $descripcionModulo = $request->getParam('descripcionModulo');
        $url = $request->getParam('url');
        $codEstado = $request->getParam('codEstado');
        
        $sql = "INSERT INTO modulos (nombreModulo, descripcionModulo, url, codEstado)
        VALUES (:nombreModulo, :descripcionModulo, :url, :codEstado)";
        try{
          $db = new db();
          $db = $db->conectDB();
          $resultado = $db->prepare($sql);
        
          $resultado->bindParam(':nombreModulo', $nombreModulo);
          $resultado->bindParam(':descripcionModulo', $descripcionModulo);
          $resultado->bindParam(':url', $url);
          $resultado->bindParam(':codEstado', $codEstado);
        
          $resultado->execute();
          echo json_encode("Nuevo modulo ha sido guardado con éxito.");  
        
          $resultado = null;
          $db = null;
        }catch(PDOException $e){
          echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function updateModulo ($request, $response, $args){
        $id_modulo = $request->getAttribute('id');
        $nombreModulo = $request->getParam('nombreModulo');
        $descripcionModulo = $request->getParam('descripcionModulo');
        $url = $request->getParam('url');
        $codEstado = $request->getParam('codEstado');

        $sql = "UPDATE modulos SET 
        nombreModulo = :nombreModulo, descripcionModulo = :descripcionModulo, url = :url, codEstado = :codEstado
        WHERE idModulo = $id_modulo";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 

        $resultado->bindParam(':nombreModulo', $nombreModulo);
        $resultado->bindParam(':descripcionModulo', $descripcionModulo);
        $resultado->bindParam(':url', $url);
        $resultado->bindParam(':codEstado', $codEstado);

        $resultado->execute();
        echo json_encode("Modulo actualizado satisfactoriamente.");  

        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function deleteModulo ($request, $response, $args){
        $id_modulo = $request->getAttribute('id');
        $sql = "DELETE FROM modulos WHERE idModulo = $id_modulo";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        $resultado->execute();
        
        if ($resultado->rowCount() > 0){
            echo json_encode("Modulo eliminada para siempre.");
            } else {
            echo json_encode("No existe modulo con este ID.");  
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
            echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }
}