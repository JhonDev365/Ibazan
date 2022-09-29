<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//CREACION API CIUDADES
$app->group('/api', function () use ($app) {
    // Versionado de la API
    // $app->group('/v1', function () use ($app) {
        $app->get('/ciudades', 'getAllCiudades');
        $app->get('/ciudades/{id}', 'getCiudad');
        $app->post('/ciudades/create', 'createCiudad');
        $app->put('/ciudades/{id}', 'updateCiudad');
        $app->delete('/ciudades/{id}', 'deleteCiudad');
    // });
});

function getAllCiudades(Request $request, Response $response)
{
    $sql = "SELECT * FROM ciudades";
    try{
      $db = new db();
      $db = $db->conectDB(); 
      $resultado = $db->query($sql);
  
      if ($resultado->rowCount() > 0){
        $ciudades = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($ciudades);
      } else {
        echo json_encode("No existen ciudades en la BBDD.");
      }
      $resultado = null;
      $db = null;
    }catch(PDOException $e){
      echo '{"error" : {"text":'.$e->getMessage().'}';
    }
}

function getCiudad(Request $request, Response $response)
{
  $id_ciudad = $request->getAttribute('id');
  $sql = "SELECT * FROM ciudades WHERE idCiudad = $id_ciudad";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $ciudad = $resultado->fetchAll(PDO::FETCH_OBJ);
      echo json_encode($ciudad);
    }else {
      echo json_encode("No existe ciudad en la BBDD con este ID.");
    }
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}

function createCiudad(Request $request, Response $response)
{
  $nombre = $request->getParam('nombreCiudad');
 
  $sql = "INSERT INTO ciudades (nombreCiudad) VALUES (:nombreCiudad)";
  $sql2 = "SELECT nombreCiudad FROM ciudades WHERE nombreCiudad = '$nombre'";
  try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->prepare($sql); 
    $consulta = $db->query($sql2); 
   
    if ($consulta->rowCount() > 0){
      echo json_encode("Ya existe la ciudad en la BBDD.");
     } else {
     $resultado->bindParam(':nombreCiudad', $nombre);
     $resultado->execute();
     echo json_encode("Nueva ciudad guardada.");  
   }
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }

}

function updateCiudad(Request $request, Response $response)
{
  $id_ciudad = $request->getAttribute('id');
  $nombre = $request->getParam('nombreCiudad');
 
 $sql = "UPDATE ciudades SET nombreCiudad = :nombreCiudad WHERE idCiudad = $id_ciudad";
 $sql2 = "SELECT nombreCiudad FROM ciudades WHERE nombreCiudad = '$nombre'";
 try{
   $db = new db();
   $db = $db->conectDB();
   $resultado = $db->prepare($sql); 
   $consulta = $db->query($sql2); 
  
   if ($consulta->rowCount() > 0){
     echo json_encode("Ya existe la ciudad en la BBDD.");
    } else {
    $resultado->bindParam(':nombreCiudad', $nombre);
    $resultado->execute();
    echo json_encode("Ciudad actualizada.");  
  }
   $resultado = null;
   $db = null;
 }catch(PDOException $e){
   echo '{"error" : {"text":'.$e->getMessage().'}';
 }

}

function deleteCiudad(Request $request, Response $response)
{
  $id_ciudad = $request->getAttribute('id');
 
 $sql = "DELETE FROM ciudades WHERE idCiudad = $id_ciudad";
 try{
   $db = new db();
   $db = $db->conectDB();
   $resultado = $db->prepare($sql); 
   $resultado->execute();
  
   if ($resultado->rowCount() > 0){
     echo json_encode("Ciudad eliminada para siempre.");
    } else {
    echo json_encode("No existe ciudad con este ID.");  
  }
   $resultado = null;
   $db = null;
 }catch(PDOException $e){
   echo '{"error" : {"text":'.$e->getMessage().'}';
 }

}


// CREACION API DEPARTAMENTOS
$app->group('/api', function () use ($app) {
        $app->get('/dptos', 'getAllDptos');
        $app->get('/dptos/{id}', 'getDpto');
        // $app->post('/usuarios/create', 'crearUsuario');
        // $app->put('/usuarios/{id}', 'actualizarUsuario');
        // $app->delete('/usuarios/{id}', 'eliminarUsuario');
});

function getAllDptos(Request $request, Response $response)
{
    $sql = "SELECT * FROM departamentos";
    try{
      $db = new db();
      $db = $db->conectDB(); 
      $resultado = $db->query($sql);
  
      if ($resultado->rowCount() > 0){
        $dptos = $resultado->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($dptos);
      } else {
        echo json_encode("No existen departamentos en la BBDD.");
      }
      $resultado = null;
      $db = null;
    }catch(PDOException $e){
      echo '{"error" : {"text":'.$e->getMessage().'}';
    }

}

function getDpto(Request $request, Response $response)
{
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


// CREACION API DCTOS
$app->group('/api', function () use ($app) {
      $app->get('/dctos', 'getAllDctos');
});

function getAllDctos(Request $request, Response $response)
{
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

// CREACION API USUARIOS
$app->group('/api', function () use ($app) {
      $app->get('/usuarios', 'getAllUsuarios');
      $app->get('/usuarios/{id}', 'getUsuario');
      $app->post('/usuarios/create', 'createUsuario');
      $app->put('/usuarios/{id}', 'updateUsuario');
      $app->delete('/usuarios/{id}', 'deleteUsuario');
});

function getAllUsuarios(Request $request, Response $response)
{
  $sql = "SELECT * FROM datosUsuarios";
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

// GET Recueperar usuarios por ID 
function getUsuario(Request $request, Response $response)
{
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
}; 

// POST Crear nuevo usuariocliente 
function createUsuario(Request $request, Response $response)
{
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
//PUT Actualizar un usuario
function updateUsuario(Request $request, Response $response)
{
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
// DELETE borrar usuario 
function deleteUsuario(Request $request, Response $response)
{
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

// CREACION API VEHICULOS
$app->group('/api', function () use ($app) {
  $app->get('/vehiculos', 'getAllVehiculos');
  $app->get('/vehiculos/{id}', 'getVehiculo');
  $app->post('/vehiculos/create', 'createVehiculo');
  $app->put('/vehiculos/{id}', 'updateVehiculo');
  $app->delete('/vehiculos/{id}', 'deleteVehiculo');
});

function getAllVehiculos(Request $request, Response $response)
{
$sql = "SELECT * FROM vehiculos";
try{
$db = new db();
$db = $db->conectDB();
$resultado = $db->query($sql);

if ($resultado->rowCount() > 0){
  $vehiculos = $resultado->fetchAll(PDO::FETCH_OBJ);
  echo json_encode($vehiculos);
}else {
  echo json_encode("No existen vehiculos en la BBDD.");
}
$resultado = null;
$db = null;
}catch(PDOException $e){
echo '{"error" : {"text":'.$e->getMessage().'}';
}

}

// GET Recueperar usuarios por ID 
function getVehiculo(Request $request, Response $response)
{
$id_vehiculo = $request->getAttribute('id');
$sql = "SELECT * FROM vehiculos WHERE idVehiculo = $id_vehiculo";
try{
$db = new db();
$db = $db->conectDB();
$resultado = $db->query($sql);

if ($resultado->rowCount() > 0){
  $vehiculo = $resultado->fetchAll(PDO::FETCH_OBJ);
  echo json_encode($vehiculo);
}else {
  echo json_encode("No existen vehículo en la BBDD con este ID.");
}
$resultado = null;
$db = null;
}catch(PDOException $e){
echo '{"error" : {"text":'.$e->getMessage().'}';
}
}; 

// POST Crear nuevo usuariocliente 
function createVehiculo(Request $request, Response $response)
{
$marca = $request->getParam('marca');
$placa = $request->getParam('placa');
$modelo = $request->getParam('modelo');
$numChasis = $request->getParam('numChasis');
$numMotor = $request->getParam('numMotor');
$pesoBruto = $request->getParam('pesoBruto');

$sql = "INSERT INTO vehiculos (marca, placa, modelo, numChasis, numMotor, pesoBruto)
VALUES (:marca, :placa, :modelo, :numChasis, :numMotor, :pesoBruto)";
try{
  $db = new db();
  $db = $db->conectDB();
  $resultado = $db->prepare($sql);

  $resultado->bindParam(':marca', $marca);
  $resultado->bindParam(':placa', $placa);
  $resultado->bindParam(':modelo', $modelo);
  $resultado->bindParam(':numChasis', $numChasis);
  $resultado->bindParam(':numMotor', $numMotor);
  $resultado->bindParam(':pesoBruto', $pesoBruto);

  $resultado->execute();
  echo json_encode("Nuevo vehiculo ha sido guardado con éxito.");  

  $resultado = null;
  $db = null;
}catch(PDOException $e){
  echo '{"error" : {"text":'.$e->getMessage().'}';
}
}
//PUT Actualizar un usuario
function updateVehiculo(Request $request, Response $response)
{
$id_vehiculo = $request->getAttribute('id');
$marca = $request->getParam('marca');
$placa = $request->getParam('placa');
$modelo = $request->getParam('modelo');
$numChasis = $request->getParam('numChasis');
$numMotor = $request->getParam('numMotor');
$pesoBruto = $request->getParam('pesoBruto');

$sql = "UPDATE vehiculos SET 
marca = :marca, placa = :placa, modelo = :modelo, numChasis = :numChasis,
numMotor = :numMotor, pesoBruto = :pesoBruto
WHERE idVehiculo = $id_vehiculo";
try{
$db = new db();
$db = $db->conectDB();
$resultado = $db->prepare($sql); 

$resultado->bindParam(':marca', $marca);
$resultado->bindParam(':placa', $placa);
$resultado->bindParam(':modelo', $modelo);
$resultado->bindParam(':numChasis', $numChasis);
$resultado->bindParam(':numMotor', $numMotor);
$resultado->bindParam(':pesoBruto', $pesoBruto);

$resultado->execute();
echo json_encode("Vehículo actualizado satisfactoriamente.");  

$resultado = null;
$db = null;
}catch(PDOException $e){
echo '{"error" : {"text":'.$e->getMessage().'}';
}

}
// DELETE borrar usuario 
function deleteVehiculo(Request $request, Response $response)
{
$id_vehiculo = $request->getAttribute('id');
$sql = "DELETE FROM vehiculos WHERE idVehiculo = $id_vehiculo";
try{
  $db = new db();
  $db = $db->conectDB();
  $resultado = $db->prepare($sql); 
  $resultado->execute();
  
  if ($resultado->rowCount() > 0){
    echo json_encode("Vehículo eliminado para siempre.");
    } else {
    echo json_encode("No existe vehículo con este ID.");  
  }
  $resultado = null;
  $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}

// CREACION API ENTREGAS
$app->group('/api', function () use ($app) {
  $app->get('/entregas', 'getAllEntregas');
  $app->get('/entregas/{id}', 'getEntrega');
  $app->post('/entregas/create', 'createEntrega');
  $app->put('/entregas/{id}', 'updateEntrega');
  $app->delete('/entregas/{id}', 'deleteEntrega');
});

//Entregas
function getAllEntregas(Request $request, Response $response)
{
$sql = "SELECT * FROM entregas";
try{
$db = new db();
$db = $db->conectDB();
$resultado = $db->query($sql);

if ($resultado->rowCount() > 0){
  $vehiculos = $resultado->fetchAll(PDO::FETCH_OBJ);
  echo json_encode($vehiculos);
}else {
  echo json_encode("No existen entregas en la BBDD.");
}
$resultado = null;
$db = null;
}catch(PDOException $e){
echo '{"error" : {"text":'.$e->getMessage().'}';
}

}

// GET Recuperar Entrega por ID 
function getEntrega(Request $request, Response $response)
{
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
}; 

// POST Crear nueva Entrega 
function createEntrega(Request $request, Response $response)
{
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
//PUT Actualizar Entrega
function updateEntrega(Request $request, Response $response)
{
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
// DELETE Entrega 
function deleteEntrega(Request $request, Response $response)
{
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

// CREACION API VISITAS
$app->group('/api', function () use ($app) {
  $app->get('/visitas', 'getAllVisitas');
  $app->get('/visitas/{id}', 'getVisita');
  $app->post('/visitas/create', 'createVisita');
  $app->put('/visitas/{id}', 'updateVisita');
  $app->delete('/visitas/{id}', 'deleteVisita');
});

//Entregas
function getAllVisitas(Request $request, Response $response)
{
$sql = "SELECT * FROM visitas";
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

// GET Recuperar Entrega por ID 
function getVisita(Request $request, Response $response)
{
$id_visita = $request->getAttribute('id');
$sql = "SELECT * FROM visitas WHERE idVisita = $id_visita";
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
}; 

// POST Crear nueva Entrega 
function createVisita(Request $request, Response $response)
{
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
//PUT Actualizar Entrega
function updateVisita(Request $request, Response $response)
{
$id_visita = $request->getAttribute('id');
$fechaNovedad = $request->getParam('fechaNovedad');
$valorRecaudado = $request->getParam('valorRecaudado');
$observaciones = $request->getParam('observaciones');

$sql = "UPDATE entregas SET 
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
// DELETE Entrega 
function deleteVisita(Request $request, Response $response)
{
$id_visita = $request->getAttribute('id');
$sql = "DELETE FROM visitas WHERE idVisita = $id_visita";
try{
  $db = new db();
  $db = $db->conectDB();
  $resultado = $db->prepare($sql); 
  $resultado->execute();
  
  if ($resultado->rowCount() > 0){
    echo json_encode("visita eliminada para siempre.");
    } else {
    echo json_encode("No existe visita con este ID.");  
  }
  $resultado = null;
  $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}

//CREACION API RUTAS
$app->group('/api', function () use ($app) {
  // Versionado de la API
  // $app->group('/v1', function () use ($app) {
      $app->get('/rutas', 'getAllRutas');
      $app->get('/rutas/{id}', 'getRuta');
      $app->post('/rutas/create', 'createRuta');
      $app->put('/rutas/{id}', 'updateRuta');
      $app->delete('/rutas/{id}', 'deleteRuta');
  // });
});

function getAllRutas(Request $request, Response $response)
{
  $sql = "SELECT * FROM rutas";
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

function getRuta(Request $request, Response $response)
{
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

function createRuta(Request $request, Response $response)
{
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

function updateRuta(Request $request, Response $response)
{
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

function deleteRuta(Request $request, Response $response)
{
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

// CREACION API CLIENTES
$app->group('/api', function () use ($app) {
  $app->get('/clientes', 'getAllClientes');
  $app->get('/clientes/{id}', 'getCliente');
  $app->post('/clientes/create', 'createCliente');
  $app->put('/clientes/{id}', 'updateCliente');
  $app->delete('/clientes/{id}', 'deleteCliente');
});

function getAllClientes(Request $request, Response $response)
{
$sql = "SELECT * FROM clientes";
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

// GET Recueperar usuarios por ID 
function getCliente(Request $request, Response $response)
{
$id_cliente = $request->getAttribute('id');
$sql = "SELECT * FROM clientes WHERE idCliente = $id_cliente";
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
}; 

// POST Crear nuevo usuariocliente 
function createCliente(Request $request, Response $response)
{
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
  echo json_encode("Nuevo vehiculo ha sido guardado con éxito.");  

  $resultado = null;
  $db = null;
}catch(PDOException $e){
  echo '{"error" : {"text":'.$e->getMessage().'}';
}
}
//PUT Actualizar un usuario
function updateCliente(Request $request, Response $response)
{
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
// DELETE borrar usuario 
function deleteCliente(Request $request, Response $response)
{
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

//CREACION API ESTADOS
$app->group('/api', function () use ($app) {
  // Versionado de la API
  // $app->group('/v1', function () use ($app) {
      $app->get('/estados', 'getAllEstados');
      $app->get('/estados/{id}', 'getEstado');
      $app->post('/estados/create', 'createEstado');
      $app->put('/estados/{id}', 'updateEstado');
      $app->delete('/estados/{id}', 'deleteEstado');
  // });
});

function getAllEstados(Request $request, Response $response)
{
  $sql = "SELECT * FROM estados";
  try{
    $db = new db();
    $db = $db->conectDB(); 
    $resultado = $db->query($sql);

    if ($resultado->rowCount() > 0){
      $estados = $resultado->fetchAll(PDO::FETCH_OBJ);
      echo json_encode($estados);
    } else {
      echo json_encode("No existen estados en la BBDD.");
    }
    $resultado = null;
    $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}

function getEstado(Request $request, Response $response)
{
$id_estado = $request->getAttribute('id');
$sql = "SELECT * FROM estados WHERE idEstado = $id_estado";
try{
  $db = new db();
  $db = $db->conectDB();
  $resultado = $db->query($sql);

  if ($resultado->rowCount() > 0){
    $estado = $resultado->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($estado);
  }else {
    echo json_encode("No existe estado en la BBDD con este ID.");
  }
  $resultado = null;
  $db = null;
}catch(PDOException $e){
  echo '{"error" : {"text":'.$e->getMessage().'}';
}
}

function createEstado(Request $request, Response $response)
{
$nombre = $request->getParam('nombreEstado');

$sql = "INSERT INTO estados (nombreEstado) VALUES (:nombreEstado)";
$sql2 = "SELECT nombreEstado FROM estados WHERE nombreEstado = '$nombre'";
try{
  $db = new db();
  $db = $db->conectDB();
  $resultado = $db->prepare($sql); 
  $consulta = $db->query($sql2); 
 
  if ($consulta->rowCount() > 0){
    echo json_encode("Ya existe la ciudad en la BBDD.");
   } else {
   $resultado->bindParam(':nombreEstado', $nombre);
   $resultado->execute();
   echo json_encode("Nuevo estado guardado.");  
 }
  $resultado = null;
  $db = null;
}catch(PDOException $e){
  echo '{"error" : {"text":'.$e->getMessage().'}';
}

}  

function updateEstado(Request $request, Response $response)
{
$id_estado = $request->getAttribute('id');
$nombre = $request->getParam('nombreEstado');

$sql = "UPDATE estados SET nombreEstado = :nombreEstado WHERE idCiudad = $id_estado";
$sql2 = "SELECT nombreEstado FROM estados WHERE nombreEstado = '$nombre'";
try{
 $db = new db();
 $db = $db->conectDB();
 $resultado = $db->prepare($sql); 
 $consulta = $db->query($sql2); 

 if ($consulta->rowCount() > 0){
   echo json_encode("Ya existe el estado en la BBDD.");
  } else {
  $resultado->bindParam(':nombreEstado', $nombre);
  $resultado->execute();
  echo json_encode("Estado actualizado.");  
}
 $resultado = null;
 $db = null;
}catch(PDOException $e){
 echo '{"error" : {"text":'.$e->getMessage().'}';
}

}

function deleteEstado(Request $request, Response $response)
{
$id_estado = $request->getAttribute('id');

$sql = "DELETE FROM estados WHERE idEstado = $id_estado";
try{
 $db = new db();
 $db = $db->conectDB();
 $resultado = $db->prepare($sql); 
 $resultado->execute();

 if ($resultado->rowCount() > 0){
   echo json_encode("Estado eliminado para siempre.");
  } else {
  echo json_encode("No existe estado con este ID.");  
}
 $resultado = null;
 $db = null;
}catch(PDOException $e){
 echo '{"error" : {"text":'.$e->getMessage().'}';
}

}

// CREACION API FACTURAS
$app->group('/api', function () use ($app) {
  $app->get('/facturas', 'getAllFacturas');
  $app->get('/facturas/{id}', 'getFactura');
  $app->post('/facturas/create', 'createFactura');
  $app->put('/facturas/{id}', 'updateFactura');
  $app->delete('/facturas/{id}', 'deleteFactura');
});

//Entregas
function getAllFacturas(Request $request, Response $response)
{
$sql = "SELECT * FROM facturas";
try{
$db = new db();
$db = $db->conectDB();
$resultado = $db->query($sql);

if ($resultado->rowCount() > 0){
  $facturas = $resultado->fetchAll(PDO::FETCH_OBJ);
  echo json_encode($facturas);
}else {
  echo json_encode("No existen facturas en la BBDD.");
}
$resultado = null;
$db = null;
}catch(PDOException $e){
echo '{"error" : {"text":'.$e->getMessage().'}';
}

}

// GET Recuperar Entrega por ID 
function getFactura(Request $request, Response $response)
{
$id_factura = $request->getAttribute('id');
$sql = "SELECT * FROM facturas WHERE idFactura = $id_factura";
try{
$db = new db();
$db = $db->conectDB();
$resultado = $db->query($sql);

if ($resultado->rowCount() > 0){
  $factura = $resultado->fetchAll(PDO::FETCH_OBJ);
  echo json_encode($factura);
}else {
  echo json_encode("No existen factura en la BBDD con este ID.");
}
$resultado = null;
$db = null;
}catch(PDOException $e){
echo '{"error" : {"text":'.$e->getMessage().'}';
}
}; 

// POST Crear nueva Entrega 
function createFactura(Request $request, Response $response)
{
$numFactura = $request->getParam('numFactura');
$valorFactura = $request->getParam('valorFactura');
$cantidad = $request->getParam('cantidad');

$sql = "INSERT INTO facturas (numFactura, valorFactura, cantidad)
VALUES (:numFactura, :valorFactura, :cantidad)";
try{
  $db = new db();
  $db = $db->conectDB();
  $resultado = $db->prepare($sql);

  $resultado->bindParam(':numFactura', $numFactura);
  $resultado->bindParam(':valorFactura', $valorFactura);
  $resultado->bindParam(':cantidad', $cantidad);

  $resultado->execute();
  echo json_encode("Nueva factura ha sido guardado con éxito.");  

  $resultado = null;
  $db = null;
}catch(PDOException $e){
  echo '{"error" : {"text":'.$e->getMessage().'}';
}
}
//PUT Actualizar Entrega
function updateFactura(Request $request, Response $response)
{
$id_factura = $request->getAttribute('id');
$numFactura = $request->getParam('numFactura');
$valorFactura = $request->getParam('valorFactura');
$cantidad = $request->getParam('cantidad');

$sql = "UPDATE facturas SET 
numFactura = :numFactura, valorFactura = :valorFactura, cantidad = :cantidad
WHERE idFactura = $id_factura";
try{
$db = new db();
$db = $db->conectDB();
$resultado = $db->prepare($sql); 

$resultado->bindParam(':numFactura', $numFactura);
$resultado->bindParam(':valorFactura', $valorFactura);
$resultado->bindParam(':cantidad', $cantidad);

$resultado->execute();
echo json_encode("Factura actualizada satisfactoriamente.");  

$resultado = null;
$db = null;
}catch(PDOException $e){
echo '{"error" : {"text":'.$e->getMessage().'}';
}

}
// DELETE Entrega 
function deleteFactura(Request $request, Response $response)
{
$id_factura = $request->getAttribute('id');
$sql = "DELETE FROM facturas WHERE idFactura = $id_factura";
try{
  $db = new db();
  $db = $db->conectDB();
  $resultado = $db->prepare($sql); 
  $resultado->execute();
  
  if ($resultado->rowCount() > 0){
    echo json_encode("Factura eliminada para siempre.");
    } else {
    echo json_encode("No existe factura con este ID.");  
  }
  $resultado = null;
  $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}

//CREACION API GRUPOSNOVEDADES
$app->group('/api', function () use ($app) {
  // Versionado de la API
  // $app->group('/v1', function () use ($app) {
      $app->get('/grupos', 'getAllGrupos');
      $app->get('/grupos/{id}', 'getGrupo');
      $app->post('/grupos/create', 'createGrupo');
      $app->put('/grupos/{id}', 'updateGrupo');
      $app->delete('/grupos/{id}', 'deleteGrupo');
  // });
});

function getAllGrupos(Request $request, Response $response)
{
  $sql = "SELECT * FROM grupoNovedades";
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

function getGrupo(Request $request, Response $response)
{
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

function createGrupo(Request $request, Response $response)
{
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

function updateGrupo(Request $request, Response $response)
{
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

function deleteGrupo(Request $request, Response $response)
{
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

//CREACION API TIPOSNOVEDADES
$app->group('/api', function () use ($app) {
  // Versionado de la API
  // $app->group('/v1', function () use ($app) {
      $app->get('/tipos', 'getAllTipos');
      $app->get('/tipos/{id}', 'getTipo');
      $app->post('/tipos/create', 'createTipo');
      $app->put('/tipos/{id}', 'updateTipo');
      $app->delete('/tipos/{id}', 'deleteTipo');
  // });
});

function getAllTipos(Request $request, Response $response)
{
  $sql = "SELECT * FROM tipoNovedades";
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

function getTipo(Request $request, Response $response)
{
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

function createTipo(Request $request, Response $response)
{
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

function updateTipo(Request $request, Response $response)
{
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

function deleteTipo(Request $request, Response $response)
{
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

// CREACION API LOGIN
$app->group('/api', function () use ($app) {
  $app->get('/login', 'getAllLogin');
  $app->get('/login/{id}', 'getLogin');
  $app->post('/login/create', 'createLogin');
  $app->put('/login/{id}', 'updateLogin');
  $app->delete('/login/{id}', 'deleteLogin');
});

//Logins
function getAllLogin(Request $request, Response $response)
{
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

// GET Recuperar Login por ID 
function getLogin(Request $request, Response $response)
{
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
}; 

// POST Crear nueva Login 
function createLogin(Request $request, Response $response)
{
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
//PUT Actualizar Login
function updateLogin(Request $request, Response $response)
{
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
// DELETE Login 
function deleteLogin(Request $request, Response $response)
{
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

// CREACION API ROLES
$app->group('/api', function () use ($app) {
  $app->get('/roles', 'getAllRoles');
  $app->get('/roles/{id}', 'getRol');
  $app->post('/roles/create', 'createRol');
  $app->put('/roles/{id}', 'updateRol');
  $app->delete('/roles/{id}', 'deleteRol');
});

//Roles
function getAllRoles(Request $request, Response $response)
{
$sql = "SELECT * FROM roles";
try{
$db = new db();
$db = $db->conectDB();
$resultado = $db->query($sql);

if ($resultado->rowCount() > 0){
  $roles = $resultado->fetchAll(PDO::FETCH_OBJ);
  echo json_encode($roles);
}else {
  echo json_encode("No existen roles en la BBDD.");
}
$resultado = null;
$db = null;
}catch(PDOException $e){
echo '{"error" : {"text":'.$e->getMessage().'}';
}

}

// GET Recuperar Rol por ID 
function getRol(Request $request, Response $response)
{
$id_rol = $request->getAttribute('id');
$sql = "SELECT * FROM roles WHERE idRol = $id_rol";
try{
$db = new db();
$db = $db->conectDB();
$resultado = $db->query($sql);

if ($resultado->rowCount() > 0){
  $rol = $resultado->fetchAll(PDO::FETCH_OBJ);
  echo json_encode($rol);
}else {
  echo json_encode("No existe rol en la BBDD con este ID.");
}
$resultado = null;
$db = null;
}catch(PDOException $e){
echo '{"error" : {"text":'.$e->getMessage().'}';
}
}; 

// POST Crear nueva Rol 
function createRol(Request $request, Response $response)
{
$nombreRol = $request->getParam('nombreRol');
$descripcionRol = $request->getParam('descripcionRol');
$codEstado = $request->getParam('codEstado');

$sql = "INSERT INTO roles (nombreRol, descripcionRol, codEstado)
VALUES (:nombreRol, :descripcionRol, :codEstado)";
try{
  $db = new db();
  $db = $db->conectDB();
  $resultado = $db->prepare($sql);

  $resultado->bindParam(':nombreRol', $nombreRol);
  $resultado->bindParam(':descripcionRol', $descripcionRol);
  $resultado->bindParam(':codEstado', $codEstado);

  $resultado->execute();
  echo json_encode("Nuevo rol ha sido guardada con éxito.");  

  $resultado = null;
  $db = null;
}catch(PDOException $e){
  echo '{"error" : {"text":'.$e->getMessage().'}';
}
}
//PUT Actualizar Rol
function updateRol(Request $request, Response $response)
{
$id_rol = $request->getAttribute('id');
$nombreRol = $request->getParam('nombreRol');
$descripcionRol = $request->getParam('descripcionRol');
$codEstado = $request->getParam('codEstado');

$sql = "UPDATE roles SET 
nombreRol = :nombreRol, descripcionRol = :descripcionRol, codEstado = :codEstado
WHERE idRol = $id_rol";
try{
$db = new db();
$db = $db->conectDB();
$resultado = $db->prepare($sql); 

$resultado->bindParam(':nombreRol', $nombreRol);
$resultado->bindParam(':descripcionRol', $descripcionRol);
$resultado->bindParam(':codEstado', $codEstado);

$resultado->execute();
echo json_encode("Rol actualizado satisfactoriamente.");  

$resultado = null;
$db = null;
}catch(PDOException $e){
echo '{"error" : {"text":'.$e->getMessage().'}';
}

}
// DELETE Rol 
function deleteRol(Request $request, Response $response)
{
$id_rol = $request->getAttribute('id');
$sql = "DELETE FROM roles WHERE idRol = $id_rol";
try{
  $db = new db();
  $db = $db->conectDB();
  $resultado = $db->prepare($sql); 
  $resultado->execute();
  
  if ($resultado->rowCount() > 0){
    echo json_encode("Rol eliminada para siempre.");
    } else {
    echo json_encode("No existe rol con este ID.");  
  }
  $resultado = null;
  $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}

// CREACION API MODULOS
$app->group('/api', function () use ($app) {
  $app->get('/modulos', 'getAllModulos');
  $app->get('/modulos/{id}', 'getModulo');
  $app->post('/modulos/create', 'createModulo');
  $app->put('/modulos/{id}', 'updateModulo');
  $app->delete('/modulos/{id}', 'deleteModulo');
});

//Modulos 
function getAllModulos(Request $request, Response $response)
{
$sql = "SELECT * FROM modulos";
try{
$db = new db();
$db = $db->conectDB();
$resultado = $db->query($sql);

if ($resultado->rowCount() > 0){
  $modulos = $resultado->fetchAll(PDO::FETCH_OBJ);
  echo json_encode($modulos);
}else {
  echo json_encode("No existen modulos en la BBDD.");
}
$resultado = null;
$db = null;
}catch(PDOException $e){
echo '{"error" : {"text":'.$e->getMessage().'}';
}

}

// GET Recuperar Modulo  por ID 
function getModulo(Request $request, Response $response)
{
$id_modulo = $request->getAttribute('id');
$sql = "SELECT * FROM modulos WHERE idModulo = $id_modulo";
try{
$db = new db();
$db = $db->conectDB();
$resultado = $db->query($sql);

if ($resultado->rowCount() > 0){
  $modulo = $resultado->fetchAll(PDO::FETCH_OBJ);
  echo json_encode($modulo);
}else {
  echo json_encode("No existen modulos en la BBDD con este ID.");
}
$resultado = null;
$db = null;
}catch(PDOException $e){
echo '{"error" : {"text":'.$e->getMessage().'}';
}
}; 

// POST Crear nueva Modulo  
function createModulo(Request $request, Response $response)
{
$nombreModulo = $request->getParam('nombreModulo');
$descripcionModulo = $request->getParam('descripcionModulo');
$url = $request->getParam('url');
$codEstado = $request->getParam('codEstado');

$sql = "INSERT INTO modulos (nombreModulo, descripcionModulo, url, codEstado)
VALUES (:nombreModulo, :descripcionModulo, :url, :codEstado)";
try{
  $db = new db();
  $db = $db->conectDB();
  $resultado = $db->prepare($sql);

  $resultado->bindParam(':nombreModulo', $nombreModulo);
  $resultado->bindParam(':descripcionModulo', $descripcionModulo);
  $resultado->bindParam(':url', $url);
  $resultado->bindParam(':codEstado', $codEstado);

  $resultado->execute();
  echo json_encode("Nuevo modulo ha sido guardado con éxito.");  

  $resultado = null;
  $db = null;
}catch(PDOException $e){
  echo '{"error" : {"text":'.$e->getMessage().'}';
}
}
//PUT Actualizar Modulo 
function updateModulo(Request $request, Response $response)
{
$id_modulo = $request->getAttribute('id');
$nombreModulo = $request->getParam('nombreModulo');
$descripcionModulo = $request->getParam('descripcionModulo');
$url = $request->getParam('url');
$codEstado = $request->getParam('codEstado');

$sql = "UPDATE modulos SET 
nombreModulo = :nombreModulo, descripcionModulo = :descripcionModulo, url = :url, codEstado = :codEstado
WHERE idModulo = $id_modulo";
try{
$db = new db();
$db = $db->conectDB();
$resultado = $db->prepare($sql); 

$resultado->bindParam(':nombreModulo', $nombreModulo);
$resultado->bindParam(':descripcionModulo', $descripcionModulo);
$resultado->bindParam(':url', $url);
$resultado->bindParam(':codEstado', $codEstado);

$resultado->execute();
echo json_encode("Modulo actualizado satisfactoriamente.");  

$resultado = null;
$db = null;
}catch(PDOException $e){
echo '{"error" : {"text":'.$e->getMessage().'}';
}

}
// DELETE Modulo 
function deleteModulo(Request $request, Response $response)
{
$id_modulo = $request->getAttribute('id');
$sql = "DELETE FROM modulos WHERE idModulo = $id_modulo";
try{
  $db = new db();
  $db = $db->conectDB();
  $resultado = $db->prepare($sql); 
  $resultado->execute();
  
  if ($resultado->rowCount() > 0){
    echo json_encode("Modulo eliminada para siempre.");
    } else {
    echo json_encode("No existe modulo con este ID.");  
  }
  $resultado = null;
  $db = null;
  }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}