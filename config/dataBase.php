<?php
class Database {
    private $host = "practicas.fimaz.uas.edu.mx";
    private $db_name = "lisi4117_final";
    private $username = "lisi4117";
    private $password = "lisi4117";
    // Hola comentario
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}
