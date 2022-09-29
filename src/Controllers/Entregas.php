<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Entregas {
    public function getAllEntregas ($request, $response, $args){

        //funcional
        // $sql = "SELECT a.idEntrega AS id, a.horaInicio AS inicio, a.horaFin AS fin, a.numManifiesto AS manifiesto,
        // g.nombreRuta AS ruta, b.placa,
        // CONCAT (e.nombre, ' ',  e.apellidoPaterno) AS conductor,
        // CONCAT (f.nombre, ' ',  f.apellidoPaterno) AS auxiliar 
        // FROM entregas a, vehiculos b, usuario_rol c, usuario_rol d, datosUsuarios e, datosUsuarios f, rutas g
        // WHERE a.idVehiculo = b.idVehiculo
        // AND a.idRuta = g.idRuta
        // AND a.idConductor = c.id
        // AND c.idDatoUsuario = e.idDatoUsuario
        // AND a.idAuxiliar = d.id
        // AND d.idDatoUsuario = f.idDatoUsuario

        $sql = "SELECT a.idEntrega AS id, a.horaInicio AS inicio, a.horaFin AS fin, a.numManifiesto AS manifiesto,
        g.nombreRuta AS ruta, b.placa,
        CONCAT (e.nombre, ' ',  e.apellidoPaterno) AS conductor,
        CONCAT (f.nombre, ' ',  f.apellidoPaterno) AS auxiliar,
        (SELECT SUM(valorRecaudado) AS recaudado FROM visitas WHERE idEntrega = a.idEntrega) AS vrRecaudado,
        (SELECT  COUNT(idEntrega) AS cantVisitas FROM visitas WHERE idEntrega = a.idEntrega) AS cantVisitas,
        (SELECT  COUNT(idEntrega) AS cantVisitas FROM visitas WHERE idEntrega = a.idEntrega AND idEstado = '2') AS cantEntregados,
        ROUND ((SELECT COUNT(idEntrega) AS cantVisitas FROM visitas WHERE idEntrega = a.idEntrega AND idEstado = '2')/
        (SELECT COUNT(idEntrega) AS cantVisitas FROM visitas WHERE idEntrega = a.idEntrega)*100) AS progreso,
        -- IF (ROUND ((SELECT COUNT(idEntrega) AS cantVisitas FROM visitas WHERE idEntrega = a.idEntrega AND idEstado = '2')/
        -- (SELECT COUNT(idEntrega) AS cantVisitas FROM visitas WHERE idEntrega = a.idEntrega)*100) <= 30, 'danger', 'warning') AS class
        IF (ROUND ((SELECT COUNT(idEntrega) AS cantVisitas FROM visitas WHERE idEntrega = a.idEntrega AND idEstado = '2')/
        (SELECT COUNT(idEntrega) AS cantVisitas FROM visitas WHERE idEntrega = a.idEntrega)*100) <= 80, 'success', ELSE IF(ROUND ((SELECT COUNT(idEntrega) AS cantVisitas FROM visitas WHERE idEntrega = a.idEntrega AND idEstado = '2')/
        (SELECT COUNT(idEntrega) AS cantVisitas FROM visitas WHERE idEntrega = a.idEntrega)*100)) <= 30, 'warning') AS class
       
        FROM entregas a, vehiculos b, usuario_rol c, usuario_rol d, datosUsuarios e, datosUsuarios f, rutas g
        WHERE a.idVehiculo = b.idVehiculo
        AND a.idRuta = g.idRuta
        AND a.idConductor = c.id
        AND c.idDatoUsuario = e.idDatoUsuario
        AND a.idAuxiliar = d.id
        AND d.idDatoUsuario = f.idDatoUsuario
        ";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $entregas = $resultado->fetchAll(PDO::FETCH_OBJ);
        // foreach ($entregas as $entrega) {
        //     // $resultado[]=$valor
        //     // $resultado[]=$valor
        //     $entrega['progress']['class']="danger";
        //     $entrega['progress']['count']="80";
        //     $array[]=$entrega;
        // };
        // $entregas['progress']['class']="danger";
        // $entregas['progress']['count']="80";



        // for( $i = 0; $i < sizeof( $entregas ); $i++ )
        // {
        // $entregas[$i]["progress"]["class"] = "danger";
        // $entregas[$i]["progress"]["count"] = "60";
        // }

        // $result = array( 
        // "status" => true,
        // "message" => "Listado de categorías",
        // "entregas" => $entregas 
        // );
        // echo ($result);
        echo json_encode($entregas);
        }else {
        echo json_encode("No existen entregas en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getPruebaEntregas ($request, $response, $args){
        // DATE(b.horaInicio) AS fechaInicio , TIME(b.horaInicio) AS horaInicio,
        $sql = "SELECT a.idVisita AS id, DATE(b.horaInicio) AS fechaInicio, DATE_FORMAT(b.horaInicio, '%H:%i') AS horaInicio,
        DATE(b.horaFin) AS fechaFin, DATE_FORMAT(b.horaFin, '%H:%i') AS horaFin
        FROM visitas a, entregas b
        WHERE a.idEntrega = b.idEntrega
        ";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $entregas = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($entregas);
        }else {
        echo json_encode("No existen entregas en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getEntrega ($request, $response, $args){
        $id_entrega = $request->getAttribute('id');
        $sql = "SELECT * FROM entregas WHERE idEntrega = $id_entrega";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $entrega = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($entrega);
        }else {
        echo json_encode("No existen entrega en la BBDD con este ID.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function createEntrega ($request, $response, $args){
        $numEntrega = $request->getParam('numEntrega');
        $horaInicio = $request->getParam('horaInicio');
        $horaFin = $request->getParam('horaFin');
        $numManifiesto = $request->getParam('numManifiesto');

        $sql = "INSERT INTO entregas (numEntrega, horaInicio, horaFin, numManifiesto)
        VALUES (:numEntrega, :horaInicio, :horaFin, :numManifiesto)";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':numEntrega', $numEntrega);
        $resultado->bindParam(':horaInicio', $horaInicio);
        $resultado->bindParam(':horaFin', $horaFin);
        $resultado->bindParam(':numManifiesto', $numManifiesto);

        $resultado->execute();
        echo json_encode("Nuevo vehiculo ha sido guardado con éxito.");  

        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function updateEntrega ($request, $response, $args){
        $id_entrega = $request->getAttribute('id');
        $numEntrega = $request->getParam('numEntrega');
        $horaInicio = $request->getParam('horaInicio');
        $horaFin = $request->getParam('horaFin');
        $numManifiesto = $request->getParam('numManifiesto');

        $sql = "UPDATE entregas SET 
        numEntrega = :numEntrega, horaInicio = :horaInicio, horaFin = :horaFin, numManifiesto = :numManifiesto
        WHERE idEntrega = $id_entrega";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 

        $resultado->bindParam(':numEntrega', $numEntrega);
        $resultado->bindParam(':horaInicio', $horaInicio);
        $resultado->bindParam(':horaFin', $horaFin);
        $resultado->bindParam(':numManifiesto', $numManifiesto);

        $resultado->execute();
        echo json_encode("Entrega actualizada satisfactoriamente.");  

        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function deleteEntrega ($request, $response, $args){
        $id_entrega = $request->getAttribute('id');
        $sql = "DELETE FROM entregas WHERE idEntrega = $id_entrega";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        $resultado->execute();
        
        if ($resultado->rowCount() > 0){
            echo json_encode("Entrega eliminada para siempre.");
            } else {
            echo json_encode("No existe entrega con este ID.");  
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
            echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }
}