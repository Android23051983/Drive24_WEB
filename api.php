<?php
session_start();
require "configure/database.php";
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$database = new Database();
$db = $database->getConnection();

$method = $_SERVER['REQUEST_METHOD'];
$request = $_SERVER['REQUEST_URI'];
if($request == '/api'){
switch ($method) {
    case 'GET':
    header("Content-Type: application/json; charset=UTF-8");
        handleGetRequest();
        break;
    case 'POST':
        handlePostRequest();
        break;
    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
} elseif($request == '/') {
    require 'index.php';
}

function handleGetRequest()
{
    global $db;
    $stmt = $db->prepare("SELECT * FROM users");
    $stmt->execute();
    $result = $stmt->fetchAll();
    echo json_encode($result);
}

function handlePostRequest()
{
    global $pdo;
    $input = json_decode(file_get_contents('php://input'), true);
    $username = $input['username'] ?? null;
    $email = $input['email'] ?? null;

    if (!$username || !$email) {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => 'Missing required parameters']);
        return;
    }

    $stmt = $pdo->prepare("INSERT INTO users (username, email) VALUES (:username, :email)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    if ($stmt->execute()) {
        http_response_code(201); // Created
        echo json_encode(['message' => 'User created successfully']);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['message' => 'Failed to create user']);
    }
}
?>
