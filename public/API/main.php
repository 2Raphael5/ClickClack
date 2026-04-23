<?php
define("PATH_TO_ROOT", ".");
require_once PATH_TO_ROOT . "/fonction.php";

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;

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