<?php

namespace Core;
use \PDOException;
use \PDO;


Class Model extends PDO {

    public static $instance;

    public function __construct()
    {
        if (!isset(self::$instance)) {
            parent::__construct(sprintf("mysql:dbname=%s;host=%s" , DATABASE['database'] , DATABASE['hostname']) , DATABASE['username'] , DATABASE['password']);
            try
            {
                parent::setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                parent::setAttribute(PDO::ATTR_ORACLE_NULLS,PDO::NULL_EMPTY_STRING);
            }
            catch (PDOException $e)
            {
                trigger_error(sprintf("Ocorreu algo com conexao de dados: %s" , $e->getMessage()), E_USER_ERROR);
            }
        }
    }
}