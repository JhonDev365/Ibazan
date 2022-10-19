<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class GrupoNovedades {
    public function getAllGrupos ($request, $response, $args){
        $sql = "SELECT idGrupoNovedad AS id, nombreGrupoNovedad AS grupo
        FROM grupoNovedades";
        try{
        $db = new db();
        $db = $db->conectDB(); 
        $resultado = $db->query($sql);
    
        if ($resultado->rowCount() > 0){
        $grupos = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($grupos);
        } else {
        echo json_encode("No existen grupos de novedades en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
          echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getGrupo ($request, $response, $args){
        $id_grupo = $request->getAttribute('id');
        $sql = "SELECT * FROM grupoNovedades WHERE idGrupoNovedad = $id_grupo";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
            $grupo = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($grupo);
        }else {
            echo json_encode("No existe grupo en la BBDD con este ID.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function createGrupo ($request, $response, $args){
        $nombre = $request->getParam('nombreGrupoNovedad');

        $sql = "INSERT INTO grupoNovedades (nombreGrupoNovedad) VALUES (:nombreGrupoNovedad)";
        $sql2 = "SELECT nombreGrupoNovedad FROM grupoNovedades WHERE nombreGrupoNovedad = '$nombre'";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        $consulta = $db->query($sql2); 
        
        if ($consulta->rowCount() > 0){
            echo json_encode("Ya existe el grupo en la BBDD.");
        } else {
        $resultado->bindParam(':nombreGrupoNovedad', $nombre);
        $resultado->execute();
        echo json_encode("Nuevo grupo guardado.");  
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function updateGrupo ($request, $response, $args){
        $id_grupo = $request->getAttribute('id');
        $nombre = $request->getParam('nombreGrupoNovedad');

        $sql = "UPDATE grupoNovedades SET nombreGrupoNovedad = :nombreGrupoNovedad WHERE idGrupoNovedad = $id_grupo";
        $sql2 = "SELECT nombreGrupoNovedad FROM grupoNovedades WHERE nombreGrupoNovedad = '$nombre'";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        $consulta = $db->query($sql2); 

        if ($consulta->rowCount() > 0){
        echo json_encode("Ya existe el grupo en la BBDD.");
        } else {
        $resultado->bindParam(':nombreGrupoNovedad', $nombre);
        $resultado->execute();
        echo json_encode("Grupo actualizada.");  
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function deleteGrupo ($request, $response, $args){
        $id_grupo = $request->getAttribute('id');

        $sql = "DELETE FROM grupoNovedades WHERE idGrupoNovedad = $id_grupo";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        $resultado->execute();

        if ($resultado->rowCount() > 0){
        echo json_encode("Grupo eliminado para siempre.");
        } else {
        echo json_encode("No existe grupo con este ID.");  
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }
}