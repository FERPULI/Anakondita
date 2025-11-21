<?php
require_once __DIR__ .  '/../models/Usuario.php';
require_once __DIR__ . '/../utils/response.php';

class UsuarioController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        $usuario = new Usuario($this->db);
        $stmt = $usuario->getAll();
        response(200, $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function show($id) {
        $usuario = new Usuario($this->db);
        $usuario->id = $id;
        $stmt = $usuario->getById();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) response(200, $data);
        else response(404, ["message" => "Usuario no encontrado"]);
    }

    public function store($data) {
    $usuario = new Usuario($this->db);
    $usuario->dni = $data['dni'] ?? null;
    $usuario->nombres = $data['nombres'] ?? null;
    $usuario->apellidos = $data['apellidos'] ?? null;
    $usuario->correo = $data['correo'] ?? null;

    if ($usuario->create()) {
        response(201, ["message" => "Usuario creado exitosamente"]);
    } else {
        response(500, ["message" => "Error al crear usuario"]);
    }
}


    public function update($id, $data) {
        $usuario = new Usuario($this->db);
        $usuario->id = $id;
        $usuario->dni = $data['dni'] ?? null;
        $usuario->nombres = $data['nombres'] ?? null;
        $usuario->apellidos = $data['apellidos'] ?? null;
        $usuario->correo = $data['correo'] ?? null;
        
        if ($usuario->update()) response(200, ["message" => "Usuario actualizado"]);
        else response(500, ["message" => "Error al actualizar usuario"]);
    }

    public function destroy($id) {
        $usuario = new Usuario($this->db);
        $usuario->id = $id;

        if ($usuario->delete()) response(200, ["message" => "Usuario eliminado"]);
        else response(500, ["message" => "Error al eliminar usuario"]);
    }
}
