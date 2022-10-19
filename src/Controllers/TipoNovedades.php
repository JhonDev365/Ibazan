<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class TipoNovedades {
    public function getAllTipos ($request, $response, $args){
        $sql = "SELECT codTipoNovedad AS cod, nombreTipoNovedad AS tipo 
        FROM tipoNovedades";
        try{
        $db = new db();
        $db = $db->conectDB(); 
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $tipos = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($tipos);
        } else {
        echo json_encode("No existen tipos de novedades en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
            echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getTipo ($request, $response, $args){
        $id_tipo = $request->getAttribute('id');
        $sql = "SELECT * FROM tipoNovedades WHERE idTipoNovedad = $id_tipo";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
            $tipo = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($tipo);
        }else {
            echo json_encode("No existe tipo en la BBDD con este ID.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function createTipo ($request, $response, $args){
        $nombre = $request->getParam('nombreTipoNovedad');

        $sql = "INSERT INTO tipoNovedades (nombreTipoNovedad) VALUES (:nombreTipoNovedad)";
        $sql2 = "SELECT nombreTipoNovedad FROM tipoNovedades WHERE nombreTipoNovedad = '$nombre'";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        $consulta = $db->query($sql2); 
        
        if ($consulta->rowCount() > 0){
            echo json_encode("Ya existe el tipo en la BBDD.");
        } else {
        $resultado->bindParam(':nombreTipoNovedad', $nombre);
        $resultado->execute();
        echo json_encode("Nuevo tipo guardado.");  
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function updateTipo ($request, $response, $args){
        $id_tipo = $request->getAttribute('id');
        $nombre = $request->getParam('nombreTipoNovedad');

        $sql = "UPDATE tipoNovedades SET nombreTipoNovedad = :nombreTipoNovedad WHERE idTipoNovedad = $id_tipo";
        $sql2 = "SELECT nombreTipoNovedad FROM tipoNovedades WHERE nombreTipoNovedad = '$nombre'";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        $consulta = $db->query($sql2); 

        if ($consulta->rowCount() > 0){
        echo json_encode("Ya existe el tipo en la BBDD.");
        } else {
        $resultado->bindParam(':nombreTipoNovedad', $nombre);
        $resultado->execute();
        echo json_encode("Tipo actualizado.");  
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function deleteTipo ($request, $response, $args){
        $id_grupo = $request->getAttribute('id');

        $sql = "DELETE FROM tipoNovedades WHERE idTipoNovedad = $id_grupo";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        $resultado->execute();

        if ($resultado->rowCount() > 0){
        echo json_encode("Tipo eliminado para siempre.");
        } else {
        echo json_encode("No existe tipo con este ID.");  
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }
}