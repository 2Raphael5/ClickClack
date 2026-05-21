<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
define("PATH_TO_ROOT", ".");
require_once PATH_TO_ROOT . "/fonction.php";

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

switch ($method) {
    case 'GET':
        $result = get($id); 
        break;

    case 'POST':
        #code...
        break;

    case 'PUT':
        #code...
        break;

    case 'DELETE':
        #code...
        break;

    default:
        $result = ["error" => "Méthode non supportée"];
        break;
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result);
die();