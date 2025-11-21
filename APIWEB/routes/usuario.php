<?php
require_once __DIR__ . '/../controllers/UsuarioController.php';
require_once __DIR__ . '/../utils/response.php';

$controller = new UsuarioController($db);

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['id'])) {
            $controller->show($_GET['id']);
        } else {
            $controller->index();
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $controller->store($data);
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $data);
        $id = $_GET['id'] ?? null;
        $controller->update($id, $data);
        break;
    break;
    case 'DELETE':
        $id = $_GET['id'] ?? null;
        $controller->destroy($id);
        break;

    default:
        response(405, ["message" => "Método no permitido"]);
        break;
}
