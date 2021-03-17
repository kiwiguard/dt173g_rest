<?php

class Database {
    /****** Database settings local ******/
    // private $dsn = 'mysql:host=localhost;dbname=suni_portfolio';
    // private $user = '******';
    // private $pwd = '******';

    /****** Database settings deployed ******/
    private $dsn = 'mysql:host=localhost;dbname=susanneni_portfolio';
    private $user = '******';
    private $pwd = '******';

    /****** Database connection******/
    public function connect() {
        try {
            $pdo = new PDO($this->dsn, $this->user, $this->pwd, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;

            //connection error
        } catch(PDOException $e) {
            throw $e;
            throw new PDOException('Could not connect to database');
        }
        return $this->conn;
    }

    public function close() {
        $this->conn = null;
    }

}