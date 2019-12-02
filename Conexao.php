<?php

class Conexao{
    public $servername = "localhost";
    public $username = "root";
    public $password = "";
    public $db = "trab3";
    public $conn;

    public function Open(){
        $this->conn = new mysqli($this->servername, $this->username, $this->password,$this->db);

        if ($this->conn->connect_error) {
            echo "falhou";
            die("Connection failed: " . $this->conn->connect_error);
        }

    }

    public function Close(){
        $this->conn->close();
    }

}