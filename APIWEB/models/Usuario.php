<?php
class Usuario {
    private $conn;
    private $table = "usuarios";

    public $id;
    public $dni;
    public $nombres;
    public $apellidos;
    public $correo;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT id, dni, nombres, apellidos, correo FROM $this->table");
        $stmt->execute();
        return $stmt;
    }

    public function getById() {
        $stmt = $this->conn->prepare("SELECT id, dni, nombres, apellidos, correo FROM $this->table WHERE id = :id");
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $stmt = $this->conn->prepare("INSERT INTO $this->table (dni, nombres, apellidos, correo) VALUES (:dni, :nombres, :apellidos, :correo)");
        $stmt->bindParam(":dni", $this->dni);
        $stmt->bindParam(":nombres", $this->nombres);
        $stmt->bindParam(":apellidos", $this->apellidos);
        $stmt->bindParam(":correo", $this->correo);
        return $stmt->execute();
    }

    public function update() {
        $stmt = $this->conn->prepare("UPDATE $this->table SET dni = :dni, nombres = :nombres, apellidos = :apellidos, correo = :correo WHERE id = :id");
        $stmt->bindParam(":dni", $this->dni);
        $stmt->bindParam(":nombres", $this->nombres);
        $stmt->bindParam(":apellidos", $this->apellidos);
        $stmt->bindParam(":correo", $this->correo);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }

    public function delete() {
        $stmt = $this->conn->prepare("DELETE FROM $this->table WHERE id = :id");
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
}
