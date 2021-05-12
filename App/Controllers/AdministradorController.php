<?php
use \Core\Controller;
use \Library\Request;
use \Library\Input;
use \Library\Encryption;
use \Library\Session;
use \Library\Url;

Class AdministradorController extends Controller {

    private const PAINEL_ADMINISTRADOR = 'administrador/painel';
    private const PAINEL_USUARIO = 'usuario/painel';
    private $homeModel;
    public function __construct(){
        parent::__construct();
        Session::init();
        $this->AdministradorModel = new \App\Models\AdministradorModel();
    }
    public function index() {

        $session =(Session::get('USER_AUTH'));
        if (!isset($session)) {
            $this->view('Home/login_viewer.php');
        }
        elseif ((int) Session::get('USER_ID')!==1) {
            Url::redirect(SELF::PAINEL_USUARIO);
        }
        else {
            $this->cabecalhoSistema();
            $this->conteudoInicial();
            $this->rodapeSistema();
        }

    }


    private function conteudoInicial() {

        $listaUsuarios = $this->AdministradorModel->listarUsuarios();
        $this->view('Administrador/conteudo_inicial_view.php' , ['listaUsuarios' => $listaUsuarios]);
    }

    /**
     * Tela registro de usuario
     * @return void
     */
    public function telaCadastroUsuario():void {
        $session =(Session::get('USER_AUTH'));
        if (!isset($session)) {
            $this->view('Home/login_viewer.php');
        }
        elseif ((int) Session::get('USER_ID')!==1) {
            Url::redirect(SELF::PAINEL_USUARIO);
        }
        else {
            $this->cabecalhoSistema();
            $this->view('Administrador/usuario/formulario_cadastro_usuario_viewer.php');
            $this->rodapeSistema();
        }
    }

    /**
     * Registra Usuario
     *
     * @return json
     */
    public function registrarUsuario() {
        $success = false;
        $retorno = '';

        if (!Input::isAjax()) {
            $retorno = 'Método inválido';
        }
        else {
            $session =(Session::get('USER_AUTH'));
            if (!isset($session)) {
                $retorno = 'Usuário não autenticado';
            }
            elseif ((int) Session::get('USER_ID')!==1) {
                $retorno = 'Usuário não permitido';
            }
            else {
                $loginAcesso = Input::post('emailUsuario') ?? null;
                $senhaAcesso = Input::post('senhaUsuario') ?? null;
                $nomeCompleto = Input::post('nomeCompletoUsuario') ?? null;
                if ((!isset($loginAcesso)) || (!isset($senhaAcesso)) || (!isset($nomeCompleto)) || (empty($loginAcesso)) || (empty($senhaAcesso)) || (empty($nomeCompleto))){
                    $retorno = 'Falta informações para criar conta';
                }
                else {
                    if (filter_var($loginAcesso, FILTER_VALIDATE_EMAIL)) {
                        $r = $this->AdministradorModel->getUsuarioByEmail($loginAcesso) ?? null;
                        if ((isset($r)) && (is_object($r)) && ($r->rowCount() === 0)) {
                            $resultadoCadasto = $this->AdministradorModel->adicionarNovoUsuario(
                                [
                                    'nome_completo' => $nomeCompleto
                                    , 'email' => strtolower($loginAcesso)
                                    , 'senha' => Encryption::encrypt($senhaAcesso)
                                    , 'id_categoria' => 2
                                ]
                            );
                            if ((isset($resultadoCadasto)) && (is_bool($resultadoCadasto)) && ($resultadoCadasto === true)) {
                                $retorno = 'Conta criada!';
                                $success = true;
                            }
                        } else {
                            $retorno = 'E-mail já registrado';
                        }
                    } else {
                        $retorno = 'E-mail informado inválido';
                    }
                }
            }
        }
        $data = [
            'success' => $success
            , 'message' => $retorno
        ];
        return Request::json($data);
    }

    /**
     * Alterac dados usuario
     *
     * @return JSON
     */
    public function alterarUsuario() {
        $success = false;
        $retorno = '';

        if (!Input::isAjax()) {
            $retorno = 'Método inválido';
        }
        else {
            $session =(Session::get('USER_AUTH'));
            if (!isset($session)) {
                $retorno = 'Usuário não autenticado';
            }
            elseif ((int) Session::get('USER_ID')!==1) {
                $retorno = 'Usuário não permitido';
            }
            else {
                $idUsuario = (int) Input::post('idUsuario') ?? null;
                $nomeCompleto = Input::post('nomeCompletoUsuario') ?? null;
                if ((!isset($idUsuario)) || (!is_int($idUsuario)) || (!isset($nomeCompleto)) || (empty($nomeCompleto))){
                    $retorno = 'Falta informações para alterar conta';
                }
                else {
                    $data = [ 'nome_completo' => $nomeCompleto , 'id' => $idUsuario ];
                    $resultado = $this->AdministradorModel->alterarDadosUsuario($data) ?? false ;
                    $retorno = ($resultado === true) ? "Conta do usuário alterada com sucesso" : "Não houve necessidade de alterar a conta";
                    $success = $resultado;
                }
            }
        }
        $data = [
            'success' => $success
            , 'message' => $retorno
        ];
        return Request::json($data);
    }

    /**
     * Exclui conta usuario
     *
     * @return JSON
     */
    public function excluirUsuario() {
        $success = false;
        $retorno = '';

        if (!Input::isAjax()) {
            $retorno = 'Método inválido';
        }
        else {
            $session =(Session::get('USER_AUTH'));
            if (!isset($session)) {
                $retorno = 'Usuário não autenticado';
            }
            elseif ((int) Session::get('USER_ID')!==1) {
                $retorno = 'Usuário não permitido';
            }
            else {
                $idUsuario = (int) Input::post('idUsuario') ?? null;
                if ((!isset($idUsuario)) || (!is_int($idUsuario))){
                    $retorno = 'Falta informações para alterar conta';
                }
                else {
                    $data = [ 'id' => $idUsuario , 'id_categoria' => 2 ];
                    $resultado = $this->AdministradorModel->excluirUsuario($data) ?? false ;
                    $retorno = ($resultado === true) ? "Conta do usuário excluída com sucesso" : "Houve problema ao excluir";
                    $success = $resultado;
                }
            }
        }
        $data = [
            'success' => $success
            , 'message' => $retorno
        ];
        return Request::json($data);
    }


    private function cabecalhoSistema() {
        $data = [
            'nomeUsuario' => Session::get('USER_NAME')
        ];
        $this->view('include/cabecalho_view.php' , $data);
    }

    private function rodapeSistema() {
        $this->view('include/rodape_view.php');
    }
}