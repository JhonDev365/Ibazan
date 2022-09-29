<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Departamentos {
    public function getAllDptos ($request, $response, $args){
        // return $response->write("Todas las ciudades");
        $sql = "SELECT * FROM departamentos";
            try{
              $db = new db();
              $db = $db->conectDB(); 
              $resultado = $db->query($sql);
          
              if ($resultado->rowCount() > 0){
                $dptos = $resultado->fetchAll(PDO::FETCH_OBJ);
                echo json_encode($dptos);
              } else {
                echo json_encode("No existen ciudades en la BBDD.");
              }
              $resultado = null;
              $db = null;
            }catch(PDOException $e){
              echo '{"error" : {"text":'.$e->getMessage().'}';
            }
    }

    public function getDpto ($request, $response, $args){
      $id_dpto = $request->getAttribute('id');
      $sql = "SELECT * FROM departamentos WHERE idDepartamento = $id_dpto";
      try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
          $dpto = $resultado->fetchAll(PDO::FETCH_OBJ);
          echo json_encode($dpto);
        }else {
          echo json_encode("No existe ciudad en la BBDD con este ID.");
        }
        $resultado = null;
        $db = null;
      }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
      }
    }

    public function createDpto ($request, $response, $args){
        $nombre = $request->getParam('nombreDepartamento');
 
        $sql = "INSERT INTO departamentos (nombreDepartamento) VALUES (:nombreDepartamento)";
        $sql2 = "SELECT nombreDepartamento FROM departamentos WHERE nombreDepartamento = '$nombre'";
        try{
          $db = new db();
          $db = $db->conectDB();
          $resultado = $db->prepare($sql); 
          $consulta = $db->query($sql2); 
         
          if ($consulta->rowCount() > 0){
            echo json_encode("Ya existe el departamento en la BBDD.");
           } else {
           $resultado->bindParam(':nombreDepartamento', $nombre);
           $resultado->execute();
           echo json_encode("Nuevo departamento guardado.");  
         }
          $resultado = null;
          $db = null;
        }catch(PDOException $e){
          echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function updateDpto ($request, $response, $args){
        $id_dpto = $request->getAttribute('id');
        $nombre = $request->getParam('nombreDepartamento');
       
       $sql = "UPDATE departamentos SET nombreDepartamento = :nombreDepartamento WHERE idDepartamento = $id_dpto";
       $sql2 = "SELECT nombreDepartamento FROM departamentos WHERE nombreDepartamento = '$nombre'";
       try{
         $db = new db();
         $db = $db->conectDB();
         $resultado = $db->prepare($sql); 
         $consulta = $db->query($sql2); 
        
         if ($consulta->rowCount() > 0){
           echo json_encode("Ya existe el departamento en la BBDD.");
          } else {
          $resultado->bindParam(':nombreDepartamento', $nombre);
          $resultado->execute();
          echo json_encode("Departamento actualizado.");  
        }
         $resultado = null;
         $db = null;
       }catch(PDOException $e){
         echo '{"error" : {"text":'.$e->getMessage().'}';
       }
       
    }

    public function deleteDpto ($request, $response, $args){
        $id_dpto = $request->getAttribute('id');
 
        $sql = "DELETE FROM departamentos WHERE idDepartamento = $id_dpto";
        try{
          $db = new db();
          $db = $db->conectDB();
          $resultado = $db->prepare($sql); 
          $resultado->execute();
  
          if ($resultado->rowCount() > 0){
            echo json_encode("Departamento eliminado para siempre.");
           } else {
           echo json_encode("No existe departamento con este ID.");  
         }
          $resultado = null;
          $db = null;
        }catch(PDOException $e){
          echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }
}