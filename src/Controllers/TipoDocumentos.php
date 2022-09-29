<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class TipoDocumentos {
    public function getAllDctos ($request, $response, $args){
        $sql = "SELECT * FROM tiposDocumentos";
        try{
        $db = new db();
        $db = $db->conectDB(); 
        $resultado = $db->query($sql);
    
        if ($resultado->rowCount() > 0){
            $dctos = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($dctos);
        } else {
            echo json_encode("No existen documentos en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    // public function getCiudad ($request, $response, $args){
    //     $id_ciudad = $request->getAttribute('id');
    //     $sql = "SELECT * FROM ciudades WHERE idCiudad = $id_ciudad";
    //     try{
    //         $db = new db();
    //         $db = $db->conectDB();
    //         $resultado = $db->query($sql);

    //         if ($resultado->rowCount() > 0){
    //         $ciudad = $resultado->fetchAll(PDO::FETCH_OBJ);
    //         echo json_encode($ciudad);
    //         }else {
    //         echo json_encode("No existe ciudad en la BBDD con este ID.");
    //         }
    //         $resultado = null;
    //         $db = null;
    //     }catch(PDOException $e){
    //         echo '{"error" : {"text":'.$e->getMessage().'}';
    //     }
    // }

    // public function createCiudad ($request, $response, $args){
    //     $nombre = $request->getParam('nombreCiudad');
 
    //     $sql = "INSERT INTO ciudades (nombreCiudad) VALUES (:nombreCiudad)";
    //     $sql2 = "SELECT nombreCiudad FROM ciudades WHERE nombreCiudad = '$nombre'";
    //     try{
    //       $db = new db();
    //       $db = $db->conectDB();
    //       $resultado = $db->prepare($sql); 
    //       $consulta = $db->query($sql2); 
         
    //       if ($consulta->rowCount() > 0){
    //         echo json_encode("Ya existe la ciudad en la BBDD.");
    //        } else {
    //        $resultado->bindParam(':nombreCiudad', $nombre);
    //        $resultado->execute();
    //        echo json_encode("Nueva ciudad guardada.");  
    //      }
    //       $resultado = null;
    //       $db = null;
    //     }catch(PDOException $e){
    //       echo '{"error" : {"text":'.$e->getMessage().'}';
    //     }
    // }

    // public function updateCiudad ($request, $response, $args){
    //     $id_ciudad = $request->getAttribute('id');
    //     $nombre = $request->getParam('nombreCiudad');
       
    //     $sql = "UPDATE ciudades SET nombreCiudad = :nombreCiudad WHERE idCiudad = $id_ciudad";
    //     $sql2 = "SELECT nombreCiudad FROM ciudades WHERE nombreCiudad = '$nombre'";
    //     try{
    //       $db = new db();
    //       $db = $db->conectDB();
    //       $resultado = $db->prepare($sql); 
    //       $consulta = $db->query($sql2); 
          
    //       if ($consulta->rowCount() > 0){
    //         echo json_encode("Ya existe la ciudad en la BBDD.");
    //         } else {
    //         $resultado->bindParam(':nombreCiudad', $nombre);
    //         $resultado->execute();
    //         echo json_encode("Ciudad actualizada.");  
    //       }
    //       $resultado = null;
    //       $db = null;
    //     }catch(PDOException $e){
    //       echo '{"error" : {"text":'.$e->getMessage().'}';
    //     }
    // }

    // public function deleteCiudad ($request, $response, $args){
    //     $id_ciudad = $request->getAttribute('id');
 
    //     $sql = "DELETE FROM ciudades WHERE idCiudad = $id_ciudad";
    //     try{
    //       $db = new db();
    //       $db = $db->conectDB();
    //       $resultado = $db->prepare($sql); 
    //       $resultado->execute();
         
    //       if ($resultado->rowCount() > 0){
    //         echo json_encode("Ciudad eliminada para siempre.");
    //        } else {
    //        echo json_encode("No existe ciudad con este ID.");  
    //      }
    //       $resultado = null;
    //       $db = null;
    //     }catch(PDOException $e){
    //       echo '{"error" : {"text":'.$e->getMessage().'}';
    //     }
    // }
}