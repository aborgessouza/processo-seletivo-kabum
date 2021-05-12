<?php
namespace Core;
use \Core\Route;
class App extends Route
{
    /**
     * Controller class
     */
    protected $controller;

    /**
     * Metodo padrao ao instanciar a rota
     *
     * @var string
     */
    protected $method = 'index';

    /**
     * Base default dos arquivos publicos
     *
     * @var string
     */
    protected $baseDir = '/public_html';
    public function __construct()
    {
        // executando rota
        Route::executar($this->baseDir);
    }
}