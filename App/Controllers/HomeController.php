<?php
use \Core\Controller;
use \Library\Request;
use \Library\Input;
use \Library\Encryption;
use \Library\Session;
use \Library\Url;

Class HomeController extends Controller {

    /**
     * URI para direcionamento do painel do usuario
     * @const  string PAINEL_USUARIO
     */
    private const PAINEL_USUARIO = 'usuario/painel';

    /**
     * URI para direcionamento do painel do administrador
     * @const  string PAINEL_ADMINISTRADOR
     */
    private const PAINEL_ADMINISTRADOR = 'administrador/painel';

    /**
     * URI para direcionamento ao index
     * @const  string INDEX
     */
    private const INDEX = '';

    /**
     * Model da Home
     * @var object $homeModel
     */
    private $homeModel;

    public function __construct(){
        parent::__construct();
        Session::init();
        $this->homeModel = new \App\Models\HomeModel();
    }

    /**
     * Tela inicial
     */
    public function index() : void {
        $session =(Session::get('USER_AUTH'));
        if (!isset($session)) {
            $this->view('Home/login_viewer.php');
        }
    }

    /**
     * Painel do usuario
     */
    public function painelUsuario():void {
        $this->cabecalhoSistema();
        $this->rodapeSistema();
    }

    /**
     * Tela de cadastro do usuario
     */
    public function telaCadastroUsuario():void {
        $session =(Session::get('USER_AUTH'));

        if (isset($session)) {
            Url::redirect(self::INDEX);
        }

        $this->view('Home/tela_cadastro_usuario.php');
    }

    /**
     * Autentica usuario
     *
     * @return JSON
     */
    public function autenticarUsuario() {
        $success = false;
        $retorno = '';
        $redirect = '';

        if (!Input::isAjax()) {
            $retorno = 'Método inválido';
        }
        else {
            $loginAcesso = Input::post('login_acesso') ?? null;
            $senhaAcesso = Input::post('senha_acesso') ?? null;
            $resultado = $this->homeModel->validarUsuario($loginAcesso,$senhaAcesso);
            $retorno = ((isset($resultado)) && (is_array($resultado))) ? 'Login confirmado!' : 'Dados não conferem. Por favor revisar';
            if (is_array($resultado)) {
                $s = [
                    'USER_AUTH'  => true
                    ,'USER_NAME' => $resultado['nome_completo']
                    ,'USER_ID'   => $resultado['id']
                ];
                $redirect = Url::baseUrl($resultado['id'] === 1 ?self::PAINEL_USUARIO : self::PAINEL_ADMINISTRADOR );
                $success = true;
                Session::set($s);
            }
        }
        /**
         * Serializacao array para JSON
         *
         * @var array $data'
         */
        $data = [
            'success' => $success
            , 'message' => $retorno
            , 'url' => $redirect
        ];
        return Request::json($data);
    }

    /**
     * Desconecta
     */
    public function desconectar() : void {
        Session::destroy();
        Url::redirect('/');
    }

    /**
     * Cadastro de usuario
     *
     * @return JSON'
     */
    public function registrarContaUsuario() {
        $success = false;
        $retorno = '';
        $redirect = '';

        if (!Input::isAjax()) {
            $retorno = 'Método inválido';
        }
        else {
            $loginAcesso = Input::post('login_acesso') ?? null;
            $senhaAcesso = Input::post('senha_acesso') ?? null;
            $nomeCompleto = Input::post('nome_completo') ?? null;

            if (filter_var($loginAcesso,FILTER_VALIDATE_EMAIL)) {
                $r = $this->homeModel->getUsuarioByEmail($loginAcesso) ?? null;
                if ((isset($r)) && (is_object($r)) && ($r->rowCount() === 0)) {
                    $resultadoCadasto = (int) $this->homeModel->adicionarNovoUsuario(
                        [
                            'nome_completo' => $nomeCompleto
                            , 'email' => strtolower($loginAcesso)
                            , 'senha' => Encryption::encrypt($senhaAcesso)
                            , 'id_categoria' => 2
                        ]
                    );
                    if ((isset($resultadoCadasto)) && (is_int($resultadoCadasto)) && ($resultadoCadasto > 0))
                    {
                        $success = true;
                        $retorno = 'Sua conta foi criada!';

                        $s = [
                            'USER_AUTH'  => true
                            ,'USER_NAME' => $nomeCompleto
                            ,'USER_ID'   => $resultadoCadasto
                        ];
                        Session::set($s);
                        $redirect = Url::baseUrl(self::PAINEL_USUARIO);

                    }
                }
                else {
                    $retorno= 'E-mail já registrado';
                }
            }
            else {
                $retorno= 'E-mail informado inválido';
            }
        }

        /**
         * Serializacao array para JSON
         *
         * @var array $data'
         */
        $data = [
            'success' => $success
            , 'message' => $retorno
            , 'redirect' => $redirect
            ,'teste' => $loginAcesso
        ];
        return Request::json($data);
    }

    /**
     * Cabecalho geral do sistema(painel)
     */
    private function cabecalhoSistema() {

        /**
         * Envia parametros front-end
         *
         * @var array $data
         */
        $data = [
            'nomeUsuario' => Session::get('USER_NAME')
        ];

        $this->view('include/cabecalho_view.php' , $data);
    }

    /**
     * Rodape geral do sistema(painel)
     */
    private function rodapeSistema() {
        $this->view('include/rodape_view.php');
    }
}