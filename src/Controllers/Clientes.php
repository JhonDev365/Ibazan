<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Clientes {
    public function getAllClientes ($request, $response, $args){
        $sql = "SELECT a.idCliente AS id, a.nombreEstablecimiento AS cliente, a.direccionEstablecimiento AS direccion,
        b.nombreCiudad AS ciudad, c.nombreRuta AS ruta, d.nombreDocumento AS documento,
        e.nombreDepartamento AS departamento 
        FROM clientes a, ciudades b, rutas c, tiposDocumentos d, departamentos e
        WHERE a.idCiudad = b.idCiudad
        AND a.idDepartamento = e.idDepartamento
        AND a.idRuta = c.idRuta
        AND a.idTipoDocumento = d.idTipoDocumento
        ";
        try{
        $db = new db();
        $db = $db->conectDB(); 
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($clientes);
        }else {
        echo json_encode("No existen clientes en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    // public function getClientesRuta ($request, $response, $args){
    //     $sql = "SELECT a.nombreEstablecimiento, b.nombreRuta 
    //     FROM clientes a, rutas b
    //     WHERE a.idRuta = b.idRuta
    //     ";
    //     try{
    //     $db = new db();
    //     $db = $db->conectDB(); 
    //     $resultado = $db->query($sql);

    //     if ($resultado->rowCount() > 0){
    //     $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
    //     echo json_encode($clientes);
    //     }else {
    //     echo json_encode("No existen clientes en la BBDD.");
    //     }
    //     $resultado = null;
    //     $db = null;
    //     }catch(PDOException $e){
    //     echo '{"error" : {"text":'.$e->getMessage().'}';
    //     }
    // }

    public function getClientesxRuta ($request, $response, $args){
        $id = $request->getAttribute('id');
        $sql = "SELECT nombreEstablecimiento, direccionEstablecimiento 
        FROM clientes
        WHERE idRuta = $id
        ";
        try{
        $db = new db();
        $db = $db->conectDB(); 
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $clientes = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($clientes);
        }else {
        echo json_encode("No existen clientes en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    // public function getClienteRuta ($request, $response, $args){
    //     $id = $request->getAttribute('id');
    //     $sql = "SELECT a.nombreEstablecimiento, b.nombreRuta AS ruta 
    //     FROM clientes a, rutas b
    //     WHERE a.idRuta = b.idRuta
    //     -- AND a.idDatoUsuario = b.idDatoUsuario
    //     AND b.idRuta = $id
    //     ";
    //     try{
    //     $db = new db();
    //     $db = $db->conectDB();
    //     $resultado = $db->query($sql);

    //     if ($resultado->rowCount() > 0){
    //         $modulo = $resultado->fetchAll(PDO::FETCH_OBJ);
    //         echo json_encode($modulo);
    //     }else {
    //         echo json_encode("No existen usuarios-rol en la BBDD con este ID.");
    //     }
    //     $resultado = null;
    //     $db = null;
    //     }catch(PDOException $e){
    //     echo '{"error" : {"text":'.$e->getMessage().'}';
    //     }
    // }

    public function getCliente ($request, $response, $args){
        $id_cliente = $request->getAttribute('id');
        $sql = "SELECT a.idCliente AS id, a.nombreEstablecimiento AS cliente, a.direccionEstablecimiento AS direccion,
        a.telefono, numDocumento AS documento 
        FROM  clientes a
        WHERE idCliente = $id_cliente";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $cliente = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($cliente);
        }else {
        echo json_encode("No existe cliente en la BBDD con este ID.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function createCliente ($request, $response, $args){

        // $idCiudad = $request->getParam('idCiudad');
        // $sql = "INSERT INTO ciudades (idCiudad)
        // VALUES (:idCiudad)";

        // $idRuta = $request->getParam('idRuta');
        // $sql = "INSERT INTO rutas (idRuta)
        // VALUES (:idRuta)";

        // $idTipoDocumento = $request->getParam('idTipoDocumento');
        // $sql = "INSERT INTO tiposDocumentos (idTipoDocumento)
        // VALUES (:idTipoDocumento)";

        $codCliente = $request->getParam('codCliente');
        $numDocumento = $request->getParam('numDocumento');
        $nombreEstablecimiento = $request->getParam('nombreEstablecimiento');
        $direccionEstablecimiento = $request->getParam('direccionEstablecimiento');
        $telefono = $request->getParam('telefono');

        $sql = "INSERT INTO clientes (codCliente, numDocumento, nombreEstablecimiento, direccionEstablecimiento, telefono)
        VALUES (:codCliente, :numDocumento, :nombreEstablecimiento, :direccionEstablecimiento, :telefono)";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':codCliente', $codCliente);
        $resultado->bindParam(':numDocumento', $numDocumento);
        $resultado->bindParam(':nombreEstablecimiento', $nombreEstablecimiento);
        $resultado->bindParam(':direccionEstablecimiento', $direccionEstablecimiento);
        $resultado->bindParam(':telefono', $telefono);

        $resultado->execute();
        echo json_encode("Nuevo cliente ha sido guardado con éxito.");  

        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function updateCliente ($request, $response, $args){
        $id_cliente = $request->getAttribute('id');
        $codCliente = $request->getParam('codCliente');
        $numDocumento = $request->getParam('numDocumento');
        $nombreEstablecimiento = $request->getParam('nombreEstablecimiento');
        $direccionEstablecimiento = $request->getParam('direccionEstablecimiento');
        $telefono = $request->getParam('telefono');

        $sql = "UPDATE clientes SET 
        codCliente = :codCliente, numDocumento = :numDocumento, nombreEstablecimiento = :nombreEstablecimiento, direccionEstablecimiento = :direccionEstablecimiento,
        telefono = :telefono
        WHERE idCliente = $id_cliente";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 

        $resultado->bindParam(':codCliente', $codCliente);
        $resultado->bindParam(':numDocumento', $numDocumento);
        $resultado->bindParam(':nombreEstablecimiento', $nombreEstablecimiento);
        $resultado->bindParam(':direccionEstablecimiento', $direccionEstablecimiento);
        $resultado->bindParam(':telefono', $telefono);

        $resultado->execute();
        echo json_encode("Cliente actualizado satisfactoriamente.");  

        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }

    }

    public function deleteCliente ($request, $response, $args){
        $id_cliente = $request->getAttribute('id');
        $sql = "DELETE FROM clientes WHERE idCliente = $id_cliente";
        try{
          $db = new db();
          $db = $db->conectDB();
          $resultado = $db->prepare($sql); 
          $resultado->execute();
          
          if ($resultado->rowCount() > 0){
            echo json_encode("Cliente eliminado para siempre.");
            } else {
            echo json_encode("No existe Cliente con este ID.");  
          }
          $resultado = null;
          $db = null;
          }catch(PDOException $e){
            echo '{"error" : {"text":'.$e->getMessage().'}';
          }
    }
}