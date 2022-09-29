<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Login {
    public function getAllLogin ($request, $response, $args){
        $sql = "SELECT * FROM logins";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);
        
        if ($resultado->rowCount() > 0){
          $logins = $resultado->fetchAll(PDO::FETCH_OBJ);
          echo json_encode($logins);
        }else {
          echo json_encode("No existen logins en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getLogin ($request, $response, $args){
        $id_login = $request->getAttribute('id');
        $sql = "SELECT * FROM logins WHERE idLogin = $id_login";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $login = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($login);
        }else {
        echo json_encode("No existe login en la BBDD con este ID.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function createLogin ($request, $response, $args){
        $user = $request->getParam('user');
        $password = $request->getParam('password');
        $codEstado = $request->getParam('codEstado');

        $sql = "INSERT INTO logins (user, password, codEstado)
        VALUES (:user, :password, :codEstado)";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':user', $user);
        $resultado->bindParam(':password', $password);
        $resultado->bindParam(':codEstado', $codEstado);

        $resultado->execute();
        echo json_encode("Nuevo login ha sido guardada con éxito.");  

        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function updateLogin ($request, $response, $args){
        $id_login = $request->getAttribute('id');
        $user = $request->getParam('user');
        $password = $request->getParam('password');
        $codEstado = $request->getParam('codEstado');

        $sql = "UPDATE logins SET 
        user = :user, password = :password, codEstado = :codEstado
        WHERE idLogin = $id_login";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 

        $resultado->bindParam(':user', $user);
        $resultado->bindParam(':password', $password);
        $resultado->bindParam(':codEstado', $codEstado);

        $resultado->execute();
        echo json_encode("Login actualizado satisfactoriamente.");  

        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function deleteLogin ($request, $response, $args){
        $id_login = $request->getAttribute('id');
        $sql = "DELETE FROM logins WHERE idLogin = $id_login";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        $resultado->execute();
        
        if ($resultado->rowCount() > 0){
            echo json_encode("login eliminada para siempre.");
            } else {
            echo json_encode("No existe login con este ID.");  
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
            echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }
}