<?php

namespace App\Models;
use Core\Model;
use Library\Encryption;
use \PDOException;
use \PDO;

Class HomeModel extends Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function validarUsuario(string $email , string $senha) {
        try {
            $sql = "SELECT * FROM usuarios where (email = :email);";
            $r = parent::prepare($sql);
            $r->bindParam(':email' ,$email , PDO::PARAM_STR );
            $r->execute();
            if ($r->rowCount()>0) {

                foreach ($r->fetchAll(self::FETCH_ASSOC) as $r) {
                    return ((Encryption::decrypt($r['senha'])) === $senha) ? $r : false;
                }
            }
            return false;
        }
        catch (PDOException $e) {
            trigger_error(sprintf("Houve problema com banco de dados: %s" , $e->getMessage()),E_USER_ERROR);
            exit;
        }
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
            #parent::beginTransaction();
            $sql = "INSERT INTO usuarios (nome_completo,email,senha,id_categoria)VALUES(:nome_completo, :email, :senha, :id_categoria);";
            $r = parent::prepare($sql);
            $r->execute($data);

            return parent::lastInsertId();
        }
        catch (PDOException $e) {
            trigger_error(sprintf("Houve problema com banco de dados: %s" , $e->getMessage()),E_USER_ERROR);
            exit;
        }
    }
}