<?php
/**
 * @file:
 *
 * Classe de roteamento (Router)
 *
 * @author: Alexandre Borges Souza <alexandre@alexandresouza.dev>
 * @License: GPL
 * @since: 2021-05-08
 *
 */
namespace Core;

/**
 * Class Route
 * @package Core
 */
class Route {
    private static $caminhoNaoEncontrado = null;
    private static $paginaNaoEncontrado = null;
    private static $routes = [];
    private static $metodoNaoPermitido = null;
    private const CONTROLLER_PATH = 'App/Controllers/';

    /**
     * Adiciona roteamento para metodo Get
     *
     * @param string $expressaoUrl
     * @param $funcao
     * @return void
     */
    public static function get(string $expressaoUrl = '/', $funcao = null):void{
        self::__adicionar($expressaoUrl , $funcao , 'get');
    }

    /**
     * Adiciona roteamento para metodo post
     *
     * @param string $expressao
     * @param $funcao
     * @return void
     */
    public static function post(string $expressao = '/' , $funcao = null){
        self::__adicionar($expressao , $funcao , 'post');
    }

    private static function __adicionar(string $expressao , $funcao , string $metodo ) {
        array_push(self::$routes,[
            'expressaoUrl' => $expressao,
            'function' => $funcao,
            'method' => $metodo
        ]);
    }

    /**
     * Executa Roteamento
     *
     * @param string $caminhoBase
     * @return void
     */
    public static function executar(string $caminhoBase = '/public_html'):void{

        /**
         * Verificacao de URL do servidor
         *
         * @var array $urlAnalisada
         */
        $urlAnalisada = parse_url($_SERVER['REQUEST_URI']);//Parse Uri

        /**
         * Definindo caminho atual
         *
         * @var string $caminho
         */
        $caminho = (isset($urlAnalisada['path'])) ? $urlAnalisada['path'] : '/';

        /**
         * Requisicao de metodo
         *
         * @var string $metodo
         */
        $metodo = $_SERVER['REQUEST_METHOD'];


        /**
         * Possui caminho ou nao
         *
         * @var bool $semCaminho
         */
        $semCaminho = false;

        /**
         * Possui roteamento ou nao
         *
         * @var bool $semRotemaneto
         */
        $semRotemaneto = false;
        if ((isset(self::$routes)) && (is_array(self::$routes)) && (count(self::$routes)>0)){
            foreach(self::$routes as $route){
                // Adiciona caminho para testar strings
                if($caminhoBase !== '' && $caminhoBase !== '/'){
                    $route['expressaoUrl'] = $caminhoBase.$route['expressaoUrl'];
                }
                // Adiciona metas-carateres de strings automaticamente (usado para expressao regular)
                $route['expressaoUrl'] = '.*'.$route['expressaoUrl'];

                // Adiciona uma metacarateres de fim de string automaticamente (usado para expressao regular)
                $route['expressaoUrl'] = $route['expressaoUrl'].'$';
                
                // Verifica casamento com a expressaoUrl com caminho
                if(preg_match('#'.$route['expressaoUrl'].'#',$caminho,$matches)){
                    $semCaminho = true;

                    // Verificando metodos se sao iguais
                    if(strtolower($metodo) === strtolower($route['method'])){

                        // removendo primeiro elemento
                        array_shift($matches);

                        // verificando se a basepath sao nulos e diferente da inicial
                        if($caminhoBase !=='' && $caminhoBase !=='/'){

                            // Remove caminho
                            array_shift($matches);
                        }

                        // verificando se a requisicao e uma funcao
                        if (is_callable($route['function'])) {
                            call_user_func_array($route['function'], $matches);
                        }

                        // verificando se classe contendo metodo
                        elseif (is_string($route['function'])
                            && substr_count($route['function'] , '@') === 1
                            && file_exists('..' . DIRECTORY_SEPARATOR . self::CONTROLLER_PATH . '/' . explode('@', $route['function'])[0] . '.php')) {
                            $cal = explode('@', $route['function']);
                            require_once '..' . DIRECTORY_SEPARATOR . self::CONTROLLER_PATH . DIRECTORY_SEPARATOR . $cal[0] . '.php';
                            $objetoChamado = new $cal[0];
                            call_user_func_array([$objetoChamado , $cal[1]] , []);
                        }
                        $semRotemaneto = true;
                        // Forçando a nao verificar novas rotas
                        break;
                    }
                }
            }

            // Caso nao houver roteamento
            if(!$semRotemaneto){
                // Entratanto ha um caminho existindo
                if($semCaminho){

                    header("HTTP/1.0 405 Metodo não permitido");
                    if(self::$metodoNaoPermitido){
                        call_user_func_array(self::$metodoNaoPermitido, [$caminho,$metodo]);
                    }
                }else{
                    header("HTTP/1.0 404 / Pagina nao encontrada");
                    if(self::$caminhoNaoEncontrado){
                        call_user_func_array(self::$paginaNaoEncontrado, [$caminho]);
                    }
                }
            }
        }
    }
}