<?php
namespace Core;
use \Core\Viewer;
use Exception;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use RegexIterator;

class Controller
{
    protected $viewer;
    public function __construct() {

        // instanciando Viewer
        $this->viewer = new Viewer();
        $arquivos = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('../Library'));
        $arquivosPHP = new RegexIterator($arquivos, '/\.(?:php)$/');
        foreach ($arquivosPHP as $phpFile) {

            /**
             * Conteudo do arquivo
             *
             * @var string $content
             */
            $content = file_get_contents($phpFile->getRealPath());

            /**
             * Posicao das linhas do conteudo em token
             *
             * @var array $tokens
             */
            $tokens = token_get_all($content);

            /**
             * Retorna parte namespace do conteudo do arquivo
             *
             * @var string $namespace
             */
            $namespace = "";

            // iterando com posicao index do conteudo
            for ($index = 0; isset($tokens[$index]); $index++) {

                // verificando se arquivo possui conteudo
                if (!isset($tokens[$index][0])) {
                    continue;
                }

                // verificando se na posicao 0 e exatamente o namespace em questao
                if (T_NAMESPACE === $tokens[$index][0]) {

                    // Salta palavra com espaco em branco
                    $index += 2;

                    while (isset($tokens[$index]) && (is_array($tokens[$index]))) {
                        $namespace .= $tokens[$index++][1];
                    }
                }
                // Verificando se na posicao token possui espaco em branco ou a string tem salto de 2 index
                if (T_CLASS === $tokens[$index][0] && T_WHITESPACE === $tokens[$index + 1][0] && T_STRING === $tokens[$index + 2][0]) {
                    $index += 2;

                    /**
                     * Concatendo string de namespace
                     *
                     * @var string $n
                     */
                    $n = $namespace.'\\'.$tokens[$index][1];

                    // atribuindo instanciamento namespace da classe
                    class_alias ($n , $tokens[$index][1] );

                }
            }
        }
    }
    public function __call (string $metodo , array $args) {
        if (method_exists($this->viewer , $metodo)) {
            return call_user_func_array([$this->viewer , $metodo], $args);
        }
    }
}