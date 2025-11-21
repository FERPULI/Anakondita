<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Añade estas cabeceras al inicio de tu script de API
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Fecha en el pasado

// CORS headers
header("Access-Control-Allow-Origin: http://localhost:8088/apiweb/public/index.php?resource=usuario");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Si es una solicitud OPTIONS (preflight), responde con 200 y termina
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/database.php';

$db = (new Database())->connect();
$request = $_GET['resource'] ?? '';

switch ($request) {
    case 'usuario':
        require_once __DIR__ .'/../routes/usuario.php';
        break;
    default:
        http_response_code(404);
        echo json_encode(["message" => "Ruta no encontrada"]);
        break;
}
