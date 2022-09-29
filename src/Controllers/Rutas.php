<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Rutas {
    public function getAllRutas ($request, $response, $args){
        $sql = "SELECT a.*, b.numEntrega
        FROM rutas a, entregas b
        WHERE a.idEntrega = b.idEntrega
        ";
        try{
          $db = new db();
          $db = $db->conectDB(); 
          $resultado = $db->query($sql);
      
          if ($resultado->rowCount() > 0){
            $rutas = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($rutas);
          } else {
            echo json_encode("No existen rutas en la BBDD.");
          }
          $resultado = null;
          $db = null;
        }catch(PDOException $e){
          echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getRuta ($request, $response, $args){
        $id_ruta = $request->getAttribute('id');
        $sql = "SELECT * FROM rutas WHERE idRuta = $id_ruta";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
            $ruta = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($ruta);
        }else {
            echo json_encode("No existe ruta en la BBDD con este ID.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function createRuta ($request, $response, $args){
        $nombre = $request->getParam('nombreRuta');

        $sql = "INSERT INTO rutas (nombreRuta) VALUES (:nombreRuta)";
        $sql2 = "SELECT nombreRuta FROM rutas WHERE nombreRuta = '$nombre'";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        $consulta = $db->query($sql2); 
        
        if ($consulta->rowCount() > 0){
            echo json_encode("Ya existe ruta en la BBDD.");
        } else {
        $resultado->bindParam(':nombreRuta', $nombre);
        $resultado->execute();
        echo json_encode("Nueva ruta guardada.");  
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function updateRuta ($request, $response, $args){
        $id_ruta = $request->getAttribute('id');
        $nombre = $request->getParam('nombreCiudad');

        $sql = "UPDATE rutas SET nombreRuta = :nombreRuta WHERE idRuta = $id_ruta";
        $sql2 = "SELECT nombreRuta FROM rutas WHERE nombreRuta = '$nombre'";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        $consulta = $db->query($sql2); 

        if ($consulta->rowCount() > 0){
        echo json_encode("Ya existe la ruta en la BBDD.");
        } else {
        $resultado->bindParam(':nombreRuta', $nombre);
        $resultado->execute();
        echo json_encode("ruta actualizada.");  
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function deleteRuta ($request, $response, $args){
        $id_ruta = $request->getAttribute('id');

        $sql = "DELETE FROM rutas WHERE idRuta = $id_ruta";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        $resultado->execute();

        if ($resultado->rowCount() > 0){
        echo json_encode("Ruta eliminada para siempre.");
        } else {
        echo json_encode("No existe ruta con este ID.");  
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }
}