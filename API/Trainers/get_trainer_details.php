<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once('../config/database.php');

try {
    if (!isset($_GET['id'])) {
        throw new Exception('Trainer ID is required');
    }

    $database = new Database();
    $db = $database->getConnection();
    
    // Get trainer basic info
    $query = "SELECT t.*, 
                     g.gender as gender_name,
                     m.marital_status as marital_status_name
              FROM trainers t
              LEFT JOIN genders g ON t.gender = g.id
              LEFT JOIN marital_status m ON t.marital_status = m.id
              WHERE t.id = :id";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $_GET['id']);
    $stmt->execute();
    $trainer = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$trainer) {
        throw new Exception('Trainer not found');
    }
    
    // Get academic history
    $query = "SELECT academic_history.id, academic_history.trainer_id, academic_history.section, academic_degrees.degree_name ,
    academic_history.major, academic_history.institution, academic_history.graduation_year FROM academic_history 
    JOIN academic_degrees ON academic_degrees.id = academic_history.degree
    WHERE trainer_id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $_GET['id']);
    $stmt->execute();
    $trainer['academic_history'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get experience records
    $query = "SELECT * FROM experience_records WHERE trainer_id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $_GET['id']);
    $stmt->execute();
    $trainer['experience'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get skills
    $query = "SELECT * FROM skills WHERE trainer_id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $_GET['id']);
    $stmt->execute();
    $trainer['skills'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get hobbies
    $query = "SELECT * FROM hobbies WHERE trainer_id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $_GET['id']);
    $stmt->execute();
    $trainer['hobbies'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get sports
    $query = "SELECT * FROM sports WHERE trainer_id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $_GET['id']);
    $stmt->execute();
    $trainer['sports'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get illnesses
    $query = "SELECT * FROM illnesses WHERE trainer_id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $_GET['id']);
    $stmt->execute();
    $trainer['illnesses'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        "success" => true,
        "data" => $trainer
    ]);
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>