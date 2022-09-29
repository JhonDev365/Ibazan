<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Visitas {
    public function getAllVisitas ($request, $response, $args){
        // $sql = "SELECT a.*, b.nombreEstablecimiento AS cliente, c.numFactura AS factura, d.nombreEstado AS estado,
        // e.numEntrega AS entrega, g.nombreGrupoNovedad AS novedad, h.nombreTipoNovedad AS tipoNovedad 
        // FROM visitas a, clientes b, facturas c, estados d, entregas e, grupoTipoNovedades f, grupoNovedades g, tipoNovedades h
        // WHERE a.idCliente = b.idCliente
        // AND a.idFactura = c.idFactura
        // AND a.idEstado = d.idEstado
        // AND a.idEntrega = e.idEntrega
        // AND f.idGrupoNovedad = g.idGrupoNovedad
        // AND f.codTipoNovedad = h.codTipoNovedad
        // ";
        $sql = "SELECT a.idVisita AS id, a.fechaNovedad AS entregado, a.valorRecaudado AS recaudado, a.observaciones, b.nombreEstablecimiento AS cliente,
        b.direccionEstablecimiento AS direccion, c.numFactura AS factura, d.nombreEstado AS estado, e.numEntrega AS entrega,
        g.nombreGrupoNovedad AS grupo, h.nombreTipoNovedad AS tipo
        FROM visitas a, clientes b, facturas c, estados d, entregas e, grupoNovedades g, tipoNovedades h, grupo_tipo i
        WHERE a.idCliente = b.idCliente
        AND a.idFactura = c.idFactura
        AND a.idEstado = d.idEstado
        AND a.idEntrega = e.idEntrega
        AND a.idGrupoNovedad = g.idGrupoNovedad
        AND g.idGrupoNovedad = i.idGrupoNovedad
        AND a.codTipoNovedad = h.codTipoNovedad
        AND h.codTipoNovedad = i.codTipoNovedad
        ";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $visitas = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($visitas);
        }else {
        echo json_encode("No existen visitas en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getAllVisitasEntrega ($request, $response, $args){
        $id = $request->getAttribute('id');
        $sql = "SELECT a.idVisita AS id, b.nombreEstablecimiento AS cliente, b.direccionEstablecimiento AS direccion, c.numFactura AS factura,
        d.nombreEstado AS estado
        FROM visitas a, clientes b, facturas c, estados d
        WHERE idEntrega = $id
        AND a.idCliente = b.idCliente
        AND a.idFactura = c.idFactura
        AND a.idEstado = d.idEstado
        ";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $visitas = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($visitas);
        }else {
        echo json_encode("No existen visitas en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getVisitasTotales ($request, $response, $args){
        $id = $request->getAttribute('id');
        $sql = "SELECT SUM(a.valorRecaudado) AS recaudado
        FROM visitas a
        WHERE a.idEntrega = $id
        ";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $visitas = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($visitas);
        }else {
        echo json_encode("No existen visitas en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getVisitasPendientes ($request, $response, $args){
        $sql = "SELECT a.idVisita AS id, a.valorRecaudado AS recaudado, b.nombreEstablecimiento AS cliente, b.direccionEstablecimiento AS direccion,
        c.numFactura AS factura, d.nombreEstado
        FROM visitas a, clientes b, facturas c, estados d
        WHERE a.idCliente = b.idCliente
        AND a.idFactura = c.idFactura
        AND a.idEstado = d.idEstado
        AND d.nombreEstado = 'Pendiente'
        ";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $visitas = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($visitas);
        }else {
        echo json_encode("No existen visitas en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getVisitasEntregadas ($request, $response, $args){
        $sql = "SELECT a.idVisita AS id, a.valorRecaudado AS recaudado, b.nombreEstablecimiento AS cliente, b.direccionEstablecimiento AS direccion,
        c.numFactura AS factura, d.nombreEstado
        FROM visitas a, clientes b, facturas c, estados d
        WHERE a.idCliente = b.idCliente
        AND a.idFactura = c.idFactura
        AND a.idEstado = d.idEstado
        AND d.nombreEstado = 'Entregado'
        ";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $visitas = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($visitas);
        }else {
        echo json_encode("No existen visitas en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getVisitasNoEntregadas ($request, $response, $args){
        $sql = "SELECT a.idVisita AS id, a.valorRecaudado AS recaudado, b.nombreEstablecimiento AS cliente, b.direccionEstablecimiento AS direccion,
        c.numFactura AS factura, d.nombreEstado
        FROM visitas a, clientes b, facturas c, estados d
        WHERE a.idCliente = b.idCliente
        AND a.idFactura = c.idFactura
        AND a.idEstado = d.idEstado
        AND d.nombreEstado = 'No Entregado'
        ";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $visitas = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($visitas);
        }else {
        echo json_encode("No existen visitas en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getVisitasPrueba ($request, $response, $args){
        // $sql = "SELECT a.idEntrega AS id, b.nombreRuta AS ruta, c.placa, d.idVisita, d.valorRecaudado AS recaudado, e.nombreEstado AS estado
        // -- CONCAT (f.nombre, ' ',  f.apellidoPaterno) AS conductor,
        // -- CONCAT (g.nombre, ' ',  g.apellidoPaterno) AS auxiliar, 
        // FROM entregas a, rutas b, vehiculos c, visitas d, estados e
        // --  datosUsuarios f, datosUsuarios g, usuario_rol h, usuario_rol i
        // WHERE b.idRuta = b.idRuta   
        // AND a.idVehiculo = c.idVehiculo
        // AND d.idEntrega = a.idEntrega
        // -- AND a.idConductor = h.id
        // -- AND h.idDatoUsuario = f.idDatoUsuario
        // -- AND a.idAuxiliar = i.id
        // -- AND i.idDatoUsuario = g.idDatoUsuario
        $sql = "SELECT a.idVisita AS id, a.valorRecaudado AS recaudado, b.nombreEstablecimiento AS cliente, c.nombreRuta AS ruta,
        d.idEntrega, e.placa, f.nombreEstado AS estado
        FROM visitas a, clientes b, rutas c, entregas d, vehiculos e, estados f
        WHERE a.idCliente = b.idCliente
        AND b.idRuta = c.idRuta
        AND a.idEntrega = d.idEntrega
        AND d.idVehiculo = e.idVehiculo
        AND a.idEstado = f.idEstado
        ";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $visitas = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($visitas);
        }else {
        echo json_encode("No existen visitas en la BBDD.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function getVisita ($request, $response, $args){
        $id_visita = $request->getAttribute('id');
        $sql = "SELECT a.fechaNovedad AS entregado, a.valorRecaudado AS recaudado,
        a.observaciones, b.numFactura AS factura, b.valorFactura AS valor, b.cantidad
        FROM visitas a, facturas b
        WHERE idVisita = $id_visita
        AND a.idFactura = b.idFactura
        ";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->query($sql);

        if ($resultado->rowCount() > 0){
        $visita = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($visita);
        }else {
        echo json_encode("No existe visita en la BBDD con este ID.");
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function createVisita ($request, $response, $args){
        $fechaNovedad = $request->getParam('fechaNovedad');
        $valorRecaudado = $request->getParam('valorRecaudado');
        $observaciones = $request->getParam('observaciones');

        $sql = "INSERT INTO visitas (fechaNovedad, valorRecaudado, observaciones)
        VALUES (:fechaNovedad, :valorRecaudado, :observaciones)";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql);

        $resultado->bindParam(':fechaNovedad', $fechaNovedad);
        $resultado->bindParam(':valorRecaudado', $valorRecaudado);
        $resultado->bindParam(':observaciones', $observaciones);

        $resultado->execute();
        echo json_encode("Nueva visita ha sido guardada con éxito.");  

        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function updateVisita ($request, $response, $args){
        $id_visita = $request->getAttribute('id');
        $fechaNovedad = $request->getParam('fechaNovedad');
        $valorRecaudado = $request->getParam('valorRecaudado');
        $observaciones = $request->getParam('observaciones');
        
        $sql = "UPDATE visitas SET 
        fechaNovedad = :fechaNovedad, valorRecaudado = :valorRecaudado, observaciones = :observaciones
        WHERE idVisita = $id_visita";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        
        $resultado->bindParam(':fechaNovedad', $fechaNovedad);
        $resultado->bindParam(':valorRecaudado', $valorRecaudado);
        $resultado->bindParam(':observaciones', $observaciones);
        
        $resultado->execute();
        echo json_encode("Visita actualizada satisfactoriamente.");  
        
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
        echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }

    public function deleteVisita ($request, $response, $args){
        $id_visita = $request->getAttribute('id');
        $sql = "DELETE FROM visitas WHERE idVisita = $id_visita";
        try{
        $db = new db();
        $db = $db->conectDB();
        $resultado = $db->prepare($sql); 
        $resultado->execute();
        
        if ($resultado->rowCount() > 0){
            echo json_encode("Visita eliminada para siempre.");
            } else {
            echo json_encode("No existe visita con este ID.");  
        }
        $resultado = null;
        $db = null;
        }catch(PDOException $e){
            echo '{"error" : {"text":'.$e->getMessage().'}';
        }
    }
}