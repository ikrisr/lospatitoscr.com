<?php

use App\Core\Router;

$router = new Router();

/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN (Kristel)
|--------------------------------------------------------------------------
*/

$router->get('/login', 'AuthController@loginForm');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

// Dashboard según rol
//$router->get('/dashboard', 'AuthController@dashboard');
$router->get('/dashboard', 'DashboardController@index');

/*
|--------------------------------------------------------------------------
| SUPER ADMINISTRADOR – CRUD de Usuarios (Kriiz)
|--------------------------------------------------------------------------
| Protección de roles se hará dentro del controlador con Auth::role()
*/

$router->get('/admin/usuarios', 'UserController@index');
$router->get('/admin/usuarios/crear', 'UserController@crear');
$router->post('/admin/usuarios/guardar', 'UserController@guardar');

$router->get('/admin/usuarios/editar/{id}', 'UserController@editar');
$router->post('/admin/usuarios/actualizar/{id}', 'UserController@actualizar');

$router->get('/admin/usuarios/desactivar/{id}', 'UserController@desactivar');

/*
|--------------------------------------------------------------------------
| USUARIO – Crear y ver sus Tickets
|--------------------------------------------------------------------------
*/

$router->get('/tickets/crear', 'TicketController@crear');
$router->post('/tickets/guardar', 'TicketController@guardar');

$router->get('/tickets/mis-tickets', 'TicketController@misTickets');
$router->get('/tickets/detalle/{id}', 'TicketController@detalle');

/*
|--------------------------------------------------------------------------
| OPERADORES – Gestión de tickets
|--------------------------------------------------------------------------
*/

$router->get('/operador/no-asignados', 'TicketController@noAsignados');
$router->get('/operador/asignar/{id}', 'TicketController@asignar');

$router->get('/operador/mis-tickets', 'TicketController@misAsignados');

$router->post('/operador/cambiar-estado/{id}', 'TicketController@cambiarEstado');

/*
|--------------------------------------------------------------------------
| ENTRADAS / BITÁCORA
|--------------------------------------------------------------------------
*/

$router->post('/tickets/{id}/entrada', 'EntradaController@crearEntrada');
$router->post('/tickets/{id}/entrada/imagen', 'EntradaController@subirImagen');

/*
|--------------------------------------------------------------------------
| USUARIO: Aceptar o rechazar solución
|--------------------------------------------------------------------------
*/

$router->post('/tickets/{id}/aceptar', 'TicketController@aceptarSolucion');
$router->post('/tickets/{id}/rechazar', 'TicketController@rechazarSolucion');

/*
|--------------------------------------------------------------------------
| RETORNAR ROUTER
|--------------------------------------------------------------------------
*/

return $router;
