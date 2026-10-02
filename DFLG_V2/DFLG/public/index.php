<?php

require_once __DIR__ . '/../app/core/Autoload.php';
require_once __DIR__ . '/../app/config/Config.php';

use app\core\Router;

$router = new Router();

$router->get('/', 'DashboardController@index');
$router->get('/dashboard', 'DashboardController@index');

//Autenticacao
$router->get('/login', 'AutenticacaoController@login');
$router->post('/logar', 'AutenticacaoController@logar');
$router->get('/logout', 'AutenticacaoController@logout');

$router->get('/cadastrar', 'AutenticacaoController@cadastrar');
$router->post('/cadastrar/salvar', 'AutenticacaoController@salvar');

// Meta Routes
$router->get('/metas', 'MetaController@listarTodas');
$router->get('/metas/cadastrar', 'MetaController@criar');
$router->post('/metas/salvar', 'MetaController@salvar');
$router->get('/metas/editar', 'MetaController@editar');
$router->post('/metas/atualizar', 'MetaController@atualizar');
$router->get('/metas/excluir', 'MetaController@excluir');

// Transacao Routes
$router->get('/transacoes', 'TransacaoController@listarTodas');
$router->get('/transacoes/cadastrar', 'TransacaoController@criar');
$router->post('/transacoes/salvar', 'TransacaoController@salvar');
$router->get('/transacoes/editar', 'TransacaoController@editar');
$router->post('/transacoes/atualizar', 'TransacaoController@atualizar');
$router->get('/transacoes/excluir', 'TransacaoController@excluir');

// Parcelamento Routes
$router->get('/parcelamentos', 'ParcelaController@listarTodos');
$router->get('/parcelamentos/cadastrar', 'ParcelaController@criar');
$router->post('/parcelamentos/salvar', 'ParcelaController@salvar');
$router->get('/parcelamentos/editar', 'ParcelaController@editar');
$router->post('/parcelamentos/atualizar', 'ParcelaController@atualizar');
$router->get('/parcelamentos/excluir', 'ParcelaController@excluir');

//rota da calculadora
$router->get('/calculadora', 'CalculadoraController@index');
$router->post('/calculadora/calcular', 'CalculadoraController@calcular');

$router->run();
