<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once('../config/database.php');
require_once('../models/TrainersList.php');

try {
    $database = new Database();
    $db = $database->getConnection();
    
    $trainersList = new TrainersList($db);
    $trainers = $trainersList->getTrainers();
    
    echo json_encode([
        "success" => true,
        "data" => $trainers
    ]);
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>