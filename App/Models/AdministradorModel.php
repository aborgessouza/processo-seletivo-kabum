<?php

namespace App\Models;
use Core\Model;
use Library\Encryption;
use \PDOException;
use \PDO;

Class AdministradorModel extends Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Retorna usuario por email
     *
     * @param string $email
     * @return false|PDOStatement
     */
    public function getUsuarioByEmail (string $email) {
        try {
            $sql = "SELECT * FROM usuarios where (email = :email);";
            $r = parent::prepare($sql);
            $r->bindParam(':email' ,$email , PDO::PARAM_STR );
            $r->execute();
            return $r;
        }
        catch (PDOException $e) {
            trigger_error(sprintf("Houve problema com banco de dados: %s" , $e->getMessage()),E_USER_ERROR);
            exit;
        }
    }

    /**
     * Cadastro novo usuario
     *
     * @param array $data
     * @return bool|PDOStatement
     */
    public function adicionarNovoUsuario(array $data)  {
        try {
            $sql = "INSERT INTO usuarios (nome_completo,email,senha,id_categoria)VALUES(:nome_completo, :email, :senha, :id_categoria);";
            $r = parent::prepare($sql);
            $r->execute($data);
            return ( parent::lastInsertId()  > 0  )? true : false;
        }
        catch (PDOException $e) {
            trigger_error(sprintf("Houve problema com banco de dados: %s" , $e->getMessage()),E_USER_ERROR);
            exit;
        }
    }

    /**
     * Lista usuarios
     *
     * @return array
     */
    public function listarUsuarios() {
        try {
            $sql = "SELECT * from usuarios where id_categoria != 1";
            $r = parent::prepare($sql);
            $r->execute();
            return $r->fetchAll(self::FETCH_ASSOC);
        }catch (PDOException $e) {
            trigger_error(sprintf("Houve problema com banco de dados: %s" , $e->getMessage()),E_USER_ERROR);
            exit;
        }
    }

    /**
     * Atualiza informacoes do usuario
     *
     * @param array $data
     * @return bool
     */
    public function alterarDadosUsuario(array $data = []) :bool {

        try {
            $sql = "UPDATE usuarios SET nome_completo=:nome_completo WHERE id=:id";
            $r = parent::prepare($sql);
            $r->execute($data);
            return $r->rowCount() > 0 ? true:false;
        }catch (PDOException $e) {
            trigger_error(sprintf("Houve problema com banco de dados: %s" , $e->getMessage()),E_USER_ERROR);
            exit;
        }
    }

    /**
     * Exclui conta do usuario
     *
     * @param array $data
     * @return bool
     */
    public function excluirUsuario(array $data = []) :bool {
        try {
            $sql = "DELETE FROM usuarios WHERE id=:id AND id_categoria=:id_categoria";
            $r = parent::prepare($sql);
            $r->execute($data);
            return $r->rowCount() > 0 ? true:false;
        }catch (PDOException $e) {
            trigger_error(sprintf("Houve problema com banco de dados: %s" , $e->getMessage()),E_USER_ERROR);
            exit;
        }
    }


}