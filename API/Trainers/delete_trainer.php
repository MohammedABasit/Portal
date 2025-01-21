<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

require_once('../config/database.php');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->id)) {
        throw new Exception('Trainer ID is required');
    }

    $database = new Database();
    $db = $database->getConnection();
    
    // Start transaction
    $db->beginTransaction();
    
    try {
        // Delete trainer and related records (cascade delete will handle related tables)
        $query = "DELETE FROM trainers WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":id", $data->id);
        
        if (!$stmt->execute()) {
            throw new Exception("Error deleting trainer");
        }
        
        $db->commit();
        
        echo json_encode([
            "success" => true,
            "message" => "تم حذف المدرب بنجاح"
        ]);
    } catch (Exception $e) {
        $db->rollBack();
        throw $e;
    }
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage()
    ]);
}
?>