<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
// Rota padrão → login
$routes->get('/', 'AuthController::index');

// Auth
$routes->get('/login',  'AuthController::index');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

// Dashboard do profissional (protegido)
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth:profissional']);

$routes->get('/dashboard/paciente/(:num)', 'PacienteController::detalhes/$1', ['filter' => 'auth:profissional']);

// Painel do paciente (protegido)
$routes->get('/painel', 'PainelController::index', ['filter' => 'auth:paciente']);

// Humor
$routes->get( '/humor',         'HumorController::index',  ['filter' => 'auth:paciente']);
$routes->post('/humor/salvar',  'HumorController::salvar', ['filter' => 'auth:paciente']);

// Alimentação
$routes->get( '/alimentacao',        'AlimentacaoController::index',  ['filter' => 'auth:paciente']);
$routes->post('/alimentacao/salvar', 'AlimentacaoController::salvar', ['filter' => 'auth:paciente']);

// Diário
$routes->get( '/diario',        'DiarioController::index',  ['filter' => 'auth:paciente']);
$routes->post('/diario/salvar', 'DiarioController::salvar', ['filter' => 'auth:paciente']);

// Pânico
$routes->get( '/panico',        'AlertaController::index',       ['filter' => 'auth:paciente']);
$routes->post('/panico/salvar', 'AlertaController::salvar',      ['filter' => 'auth:paciente']);
$routes->get( '/panico/ok',     'AlertaController::confirmacao', ['filter' => 'auth:paciente']);

// Marcar alerta como visto (profissional)
$routes->get('/alertas/ver/(:num)', 'AlertaController::marcarVisto/$1', ['filter' => 'auth:profissional']);
