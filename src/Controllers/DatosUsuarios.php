<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class DatosUsuarios {
    public function getAllUsuarios ($request, $response, $args){
        $sql = "SELECT a.*, d.nombreDocumento AS documento, b.nombreCiudad AS ciudad, c.nombreDepartamento AS departamento
        FROM datosUsuarios a, ciudades b, departamentos c, tiposDocumentos d
        WHERE a.idCiudad = b.idCiudad
        AND a.idDepartamento = c.idDepartamento
        AND a.idTipoDocumento = d.idTipoDocumento
        ";
        try{
            $db = new db();
            $db = $db->conectDB();
            $resultado = $db->query($sql);

            if ($resultado->rowCount() > 0){
            $users = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($users);
            }else {
            echo json_encode("No existen usuarios en la BBDD.");
            }
            $resultado = null;
            $db = null;
        }catch(PDOException $e){
            echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getUsuario ($request, $response, $args){
        $id_users = $request->getAttribute('id');
        $sql = "SELECT * FROM datosUsuarios WHERE idDatoUsuario = $id_users";
        try{
            $db = new db();
            $db = $db->conectDB();
            $resultado = $db->query($sql);

            if ($resultado->rowCount() > 0){
            $user = $resultado->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($user);
            }else {
            echo json_encode("No existen usuario en la BBDD con este ID.");
            }
            $resultado = null;
            $db = null;
        }catch(PDOException $e){
            echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function createUsuario ($request, $response, $args){
        $nombre = $request->getParam('nombre');
        $apellidoPaterno = $request->getParam('apellidoPaterno');
        $apellidoMaterno = $request->getParam('apellidoMaterno');
        $fechaNacimiento = $request->getParam('fechaNacimiento');
        $numDocumento = $request->getParam('numDocumento');
        $telefono1 = $request->getParam('telefono1');
        $telefono2 = $request->getParam('telefono2');
        $email = $request->getParam('email');
        $direccion = $request->getParam('direccion');
        
        $sql = "INSERT INTO datosUsuarios (nombre, apellidoPaterno, apellidoMaterno, fechaNacimiento, numDocumento, telefono1, telefono2, email, direccion)
        VALUES (:nombre, :apellidoPaterno, :apellidoMaterno, :fechaNacimiento, :numDocumento, :telefono1, :telefono2, :email, :direccion)";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql);
    
        $resultado->bindParam(':nombre', $nombre);
        $resultado->bindParam(':apellidoPaterno', $apellidoPaterno);
        $resultado->bindParam(':apellidoMaterno', $apellidoMaterno);
        $resultado->bindParam(':fechaNacimiento', $fechaNacimiento);
        $resultado->bindParam(':numDocumento', $numDocumento);
        $resultado->bindParam(':telefono1', $telefono1);
        $resultado->bindParam(':telefono2', $telefono2);
        $resultado->bindParam(':email', $email);
        $resultado->bindParam(':direccion', $direccion);
    
        $resultado->execute();
        echo json_encode("Nuevo usuario ha sido guardado con éxito.");  
    
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function updateUsuario ($request, $response, $args){
        $id_usuario = $request->getAttribute('id');
        $nombre = $request->getParam('nombre');
        $apellidoPaterno = $request->getParam('apellidoPaterno');
        $apellidoMaterno = $request->getParam('apellidoMaterno');
        $fechaNacimiento = $request->getParam('fechaNacimiento');
        $numDocumento = $request->getParam('numDocumento');
        $telefono1 = $request->getParam('telefono1');
        $telefono2 = $request->getParam('telefono2');
        $email = $request->getParam('email');
        $direccion = $request->getParam('direccion');
    
        $sql = "UPDATE datosUsuarios SET 
        nombre = :nombre, apellidoPaterno = :apellidoPaterno, apellidoMaterno = :apellidoMaterno, fechaNacimiento = :fechaNacimiento,
        numDocumento = :numDocumento, telefono1 = :telefono1, telefono2 = :telefono2, email = :email, direccion = :direccion
        WHERE idDatoUsuario = $id_usuario";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 

        $resultado->bindParam(':nombre', $nombre);
        $resultado->bindParam(':apellidoPaterno', $apellidoPaterno);
        $resultado->bindParam(':apellidoMaterno', $apellidoMaterno);
        $resultado->bindParam(':fechaNacimiento', $fechaNacimiento);
        $resultado->bindParam(':numDocumento', $numDocumento);
        $resultado->bindParam(':telefono1', $telefono1);
        $resultado->bindParam(':telefono2', $telefono2);
        $resultado->bindParam(':email', $email);
        $resultado->bindParam(':direccion', $direccion);
    
        $resultado->execute();
        echo json_encode("Usuario actualizado satisfactoriamente.");  
    
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function deleteUsuario ($request, $response, $args){
        $id_usuario = $request->getAttribute('id');
        $sql = "DELETE FROM datosUsuarios WHERE idDatoUsuario = $id_usuario";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        $resultado->execute();
        
        if ($resultado->rowCount() > 0){
            echo json_encode("Usuario eliminado para siempre.");
            } else {
            echo json_encode("No existe usuario con este ID.");  
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
            echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getAuxiliares ($request, $response, $args){
        $id = $request->getAttribute('id');
        $sql = "SELECT CONCAT (c.nombre, ' ',  c.apellidoPaterno) AS auxiliar,  
        FROM datosUsuarios c
        WHERE idRol = $id
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
}