<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Roles {
    public function getAllRoles ($request, $response, $args){
        $sql = "SELECT * FROM roles";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);
        
        if ($resultado->rowCount() > 0){
          $roles = $resultado->fetchAll(PDO::FETCH_OBJ);
          echo json_encode($roles);
        }else {
          echo json_encode("No existen roles en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getRol ($request, $response, $args){
        $id_rol = $request->getAttribute('id');
        $sql = "SELECT * FROM roles WHERE idRol = $id_rol";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);
        
        if ($resultado->rowCount() > 0){
          $rol = $resultado->fetchAll(PDO::FETCH_OBJ);
          echo json_encode($rol);
        }else {
          echo json_encode("No existe rol en la BBDD con este ID.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function createRol ($request, $response, $args){
        $nombreRol = $request->getParam('nombreRol');
        $descripcionRol = $request->getParam('descripcionRol');
        $codEstado = $request->getParam('codEstado');

        $sql = "INSERT INTO roles (nombreRol, descripcionRol, codEstado)
        VALUES (:nombreRol, :descripcionRol, :codEstado)";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':nombreRol', $nombreRol);
        $resultado->bindParam(':descripcionRol', $descripcionRol);
        $resultado->bindParam(':codEstado', $codEstado);

        $resultado->execute();
        echo json_encode("Nuevo rol ha sido guardada con éxito.");  

        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function updateRol ($request, $response, $args){
        $id_rol = $request->getAttribute('id');
        $nombreRol = $request->getParam('nombreRol');
        $descripcionRol = $request->getParam('descripcionRol');
        $codEstado = $request->getParam('codEstado');

        $sql = "UPDATE roles SET 
        nombreRol = :nombreRol, descripcionRol = :descripcionRol, codEstado = :codEstado
        WHERE idRol = $id_rol";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 

        $resultado->bindParam(':nombreRol', $nombreRol);
        $resultado->bindParam(':descripcionRol', $descripcionRol);
        $resultado->bindParam(':codEstado', $codEstado);

        $resultado->execute();
        echo json_encode("Rol actualizado satisfactoriamente.");  

        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function deleteRol ($request, $response, $args){
        $id_rol = $request->getAttribute('id');
        $sql = "DELETE FROM roles WHERE idRol = $id_rol";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        $resultado->execute();
        
        if ($resultado->rowCount() > 0){
            echo json_encode("Rol eliminada para siempre.");
            } else {
            echo json_encode("No existe rol con este ID.");  
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
            echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }
}