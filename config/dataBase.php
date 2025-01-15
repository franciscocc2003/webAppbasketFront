<?php

class dataBase{

    private $host = "practicas.fimaz.uas.edu.mx";
    private $db = "lisi4119_PFinal";
    private $user = "lisi4119";
    private $password = "lisi4119";

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
