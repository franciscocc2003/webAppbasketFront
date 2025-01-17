<?php

class dataBase{

    private $host = "practicas.fimaz.uas.edu.mx";
    private $db_name = "lisi4117_final";
    private $username = "lisi4117";
    private $password = "lisi4117";

    public function __construct() {
        
    }
    public function connect() {
        try {
            $PDO = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db, $this->user, $this->password);
            return $PDO;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}
