<?php

use Core\Route;

//Roteamento
Route::get("/", "HomeController@index");
Route::get("/usuario/painel", "HomeController@painelUsuario");
Route::get("/usuario/criar-cadastro", "HomeController@telaCadastroUsuario");
Route::post("/usuario/registrar-conta", "HomeController@registrarContaUsuario");
Route::post("/usuario/autenticar", "HomeController@autenticarUsuario");
Route::get('/desconectar' , "HomeController@desconectar");
Route::get('/administrador/painel' , "AdministradorController@index");
Route::get('/administrador/usuario/adicionar-novo-usuario' , "AdministradorController@telaCadastroUsuario");
Route::post('/administrador/usuario/registrar-usuario' , "AdministradorController@registrarUsuario");
Route::post('/administrador/usuario/alterar-dados-usuario' , "AdministradorController@alterarUsuario");
Route::post('/administrador/usuario/excluir-usuario' , "AdministradorController@excluirUsuario");