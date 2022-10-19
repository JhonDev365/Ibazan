<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

//codigo CORS
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require 'Controllers/Departamentos.php';
require 'Controllers/Ciudades.php';
require 'Controllers/Vehiculos.php';
require 'Controllers/TipoDocumentos.php';
require 'Controllers/DatosUsuarios.php';
require 'Controllers/Entregas.php';
require 'Controllers/Visitas.php';
require 'Controllers/Rutas.php';
require 'Controllers/Clientes.php';
require 'Controllers/Estados.php';
require 'Controllers/Facturas.php';
require 'Controllers/GrupoNovedades.php';
require 'Controllers/TipoNovedades.php';
require 'Controllers/Modulos.php';
require 'Controllers/Login.php';
require 'Controllers/Roles.php';

//CREACION ENDPOINTS CIUDADES
$app->group('/api', function () use ($app) {
    // Versionado de la API
    // $app->group('/v1', function () use ($app) {
    $app->get('/ciudades', Ciudades::class . ':getAllCiudades');
    $app->get('/ciudades/{id}', Ciudades::class . ':getCiudad');
    $app->post('/ciudades/create', Ciudades::class . ':createCiudad');
    $app->put('/ciudades/{id}', Ciudades::class . ':updateCiudad');
    $app->delete('/ciudades/{id}', Ciudades::class . ':deleteCiudad');
    // });
});

// CREACION ENDPOINTS DEPARTAMENTOS
$app->group('/api', function () use ($app) {
    $app->get('/dptos', Departamentos::class . ':getAllDptos');
    $app->get('/dptos/{id}', Departamentos::class . ':getDpto');
    $app->post('/dptos/create', Departamentos::class . ':createDpto');
    $app->put('/dptos/{id}', Departamentos::class . ':updateDpto');
    $app->delete('/dptos/{id}', Departamentos::class . ':deleteDpto');
});

// CREACION ENDPOINTS DCTOS
$app->group('/api', function () use ($app) {
    $app->get('/dctos', TipoDocumentos::class . ':getAllDctos');
});

// CREACION ENDPOINTS USUARIOS
$app->group('/api', function () use ($app) {
    $app->get('/usuarios', DatosUsuarios::class . ':getAllUsuarios');
    $app->get('/usuarios/{id}', DatosUsuarios::class . ':getUsuario');
    $app->post('/usuarios/create', DatosUsuarios::class . ':createUsuario');
    $app->put('/usuarios/{id}', DatosUsuarios::class . ':updateUsuario');
    $app->delete('/usuarios/{id}', DatosUsuarios::class . ':deleteUsuario');
});

// CREACION ENDPOINTS VEHICULOS
$app->group('/api', function () use ($app) {
    $app->get('/vehiculos', Vehiculos::class . ':getAllVehiculos');
    $app->get('/vehiculos/{id}', Vehiculos::class . ':getVehiculo');
    $app->post('/vehiculos/create',  Vehiculos::class . ':createVehiculo');
    $app->put('/vehiculos/{id}',  Vehiculos::class . ':updateVehiculo');
    $app->delete('/vehiculos/{id}',  Vehiculos::class . ':deleteVehiculo');
});

// CREACION ENDPOINTS ENTREGAS
$app->group('/api', function () use ($app) {
    $app->get('/entregas', Entregas::class . ':getAllEntregas');
    $app->get('/entregas/prueba', Entregas::class . ':getPruebaEntregas');
    $app->get('/entregas/{id}', Entregas::class . ':getEntrega');
    $app->post('/entregas/create', Entregas::class . ':createEntrega');
    $app->put('/entregas/{id}', Entregas::class . ':updateEntrega');
    $app->delete('/entregas/{id}', Entregas::class . ':deleteEntrega');
});

// CREACION ENDPOINTS VISITAS
$app->group('/api', function () use ($app) {
    $app->get('/visitas', Visitas::class . ':getAllVisitas');
    $app->get('/visitas/pendientes', Visitas::class . ':getVisitasPendientes');
    $app->get('/visitas/totales/{id}', Visitas::class . ':getVisitasTotales');
    $app->get('/visitas/entregadas', Visitas::class . ':getVisitasEntregadas');
    $app->get('/visitas/no-entregadas', Visitas::class . ':getVisitasNoEntregadas');
    $app->get('/visitas/entrega/{id}', Visitas::class . ':getAllVisitasEntrega');
    $app->get('/visitas/prueba', Visitas::class . ':getVisitasPrueba');
    $app->get('/visitas/{id}', Visitas::class . ':getVisita');
    $app->post('/visitas/create', Visitas::class . ':createVisita');
    $app->put('/visitas/{id}', Visitas::class . ':updateVisita');
    $app->delete('/visitas/{id}', Visitas::class . ':deleteVisita');
});

//CREACION ENDPOINTS RUTAS
$app->group('/api', function () use ($app) {
    $app->get('/rutas', Rutas::class . ':getAllRutas');
    $app->get('/rutas/{id}', Rutas::class . ':getRuta');
    $app->post('/rutas/create', Rutas::class . ':createRuta');
    $app->put('/rutas/{id}', Rutas::class . ':updateRuta');
    $app->delete('/rutas/{id}', Rutas::class . ':deleteRuta');
});

// CREACION ENDPOINTS CLIENTES
$app->group('/api', function () use ($app) {
    $app->get('/clientes', Clientes::class . ':getAllClientes');
    $app->get('/clientes-ruta', Clientes::class . ':getClientesRuta');
    $app->get('/clientesxruta/{id}', Clientes::class . ':getClientesxRuta');
    $app->get('/clientes-ruta/{id}', Clientes::class . ':getClienteRuta');
    $app->get('/clientes/{id}', Clientes::class . ':getCliente');
    $app->post('/clientes/create', Clientes::class . ':createCliente');
    $app->put('/clientes/{id}', Clientes::class . ':updateCliente');
    $app->delete('/clientes/{id}', Clientes::class . ':deleteCliente');
});

//CREACION ENDPOINTS ESTADOS
$app->group('/api', function () use ($app) {
    $app->get('/estados', Estados::class . ':getAllEstados');
    $app->get('/estados/{id}', Estados::class . ':getEstado');
    $app->post('/estados/create', Estados::class . ':createEstado');
    $app->put('/estados/{id}', Estados::class . ':updateEstado');
    $app->delete('/estados/{id}', Estados::class . ':deleteEstado');
});

// CREACION ENDPOINTS FACTURAS
$app->group('/api', function () use ($app) {
    $app->get('/facturas', Facturas::class . ':getAllFacturas');
    $app->get('/facturas/{id}', Facturas::class . ':getFactura');
    $app->post('/facturas/create', Facturas::class . ':createFactura');
    $app->put('/facturas/{id}', Facturas::class . ':updateFactura');
    $app->delete('/facturas/{id}', Facturas::class . ':deleteFactura');
});

//CREACION ENDPOINTS GRUPOSNOVEDADES
$app->group('/api', function () use ($app) {
    $app->get('/grupos', GrupoNovedades::class . ':getAllGrupos');
    $app->get('/grupos/{id}', GrupoNovedades::class . ':getGrupo');
    $app->post('/grupos/create', GrupoNovedades::class . ':createGrupo');
    $app->put('/grupos/{id}', GrupoNovedades::class . ':updateGrupo');
    $app->delete('/grupos/{id}', GrupoNovedades::class . ':deleteGrupo');
});

//CREACION ENDPOINTS TIPOSNOVEDADES
$app->group('/api', function () use ($app) {
    $app->get('/tipos', TipoNovedades::class . ':getAllTipos');
    $app->get('/tipos/{id}', TipoNovedades::class . ':getTipo');
    $app->post('/tipos/create', TipoNovedades::class . ':createTipo');
    $app->put('/tipos/{id}', TipoNovedades::class . ':updateTipo');
    $app->delete('/tipos/{id}', TipoNovedades::class . ':deleteTipo');
});

// CREACION ENDPOINTS LOGIN
$app->group('/api', function () use ($app) {
    $app->get('/login', Login::class . ':getAllLogin');
    $app->get('/login/{id}', Login::class . ':getLogin');
    $app->post('/login/create', Login::class . ':createLogin');
    $app->post('/loginApp', Login::class . ':validateLogin');
    $app->put('/login/{id}', Login::class . ':updateLogin');
    $app->delete('/login/{id}', Login::class . ':deleteLogin');
});

// CREACION ENDPOINTS ROLES
$app->group('/api', function () use ($app) {
  $app->get('/roles', Roles::class . ':getAllRoles');
  $app->get('/roles/{id}', Roles::class . ':getRol');
  $app->post('/roles/create', Roles::class . ':createRol');
  $app->put('/roles/{id}', Roles::class . ':updateRol');
  $app->delete('/roles/{id}', Roles::class . ':deleteRol');
});

// CREACION ENDPOINTS MODULOS
$app->group('/api', function () use ($app) {
  $app->get('/modulos', Modulos::class . ':getAllModulos');
  $app->get('/modulos/{id}', Modulos::class . ':getModulo');
  $app->post('/modulos/create', Modulos::class . ':createModulo');
  $app->put('/modulos/{id}', Modulos::class . ':updateModulo');
  $app->delete('/modulos/{id}', Modulos::class . ':deleteModulo');
});

// CREACION ENDPOINT USERSROL
$app->group('/api', function () use ($app) {
  $app->get('/usuarios-rol/{id}', 'getUsuariosRol');
});
// GET UsuarioRol  por ID 
function getUsuariosRol(Request $request, Response $response)
{
  $id = $request->getAttribute('id');
  $sql = "SELECT a.*, c.nombreRol AS cargo 
  FROM usuario_rol b, datosUsuarios a, roles c
  WHERE b.idRol = c.idRol
  AND a.idDatoUsuario = b.idDatoUsuario
  AND b.idRol = $id
  ";
  try{
  $db = new db();
  $db = $db->conectDB();
  $resultado = $db->query($sql);

  if ($resultado->rowCount() > 0){
    $modulo = $resultado->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($modulo);
  }else {
    echo json_encode("No existen usuarios-rol en la BBDD con este ID.");
  }
  $resultado = null;
  $db = null;
  }catch(PDOException $e){
  echo '{"error" : {"text":'.$e->getMessage().'}';
  }
}

// CREACION ENDPOINT GRUPOTIPO
$app->group('/api', function () use ($app) {
    $app->get('/grupo-tipo/{id}', 'getGrupoTipo');
  });
  // GET UsuarioRol  por ID 
  function getGrupoTipo(Request $request, Response $response)
  {
    $id = $request->getAttribute('id');
    $sql = "SELECT a.*, c.nombreGrupoNovedad AS grupo 
    FROM grupo_tipo b, tipoNovedades a, grupoNovedades c
    WHERE b.idGrupoNovedad = c.idGrupoNovedad
    AND a.codTipoNovedad = b.codTipoNovedad
    AND b.idGrupoNovedad = $id
    ";
    try{
    $db = new db();
    $db = $db->conectDB();
    $resultado = $db->query($sql);
  
    if ($resultado->rowCount() > 0){
      $modulo = $resultado->fetchAll(PDO::FETCH_OBJ);
      echo json_encode($modulo);
    }else {
      echo json_encode("No existen usuarios-rol en la BBDD con este ID.");
    }
    $resultado = null;
    $db = null;
    }catch(PDOException $e){
    echo '{"error" : {"text":'.$e->getMessage().'}';
    }
  }