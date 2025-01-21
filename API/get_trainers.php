<?php
require_once('./config/database.php');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

class TrainersList {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getTrainers() {
        try {
            $query = "SELECT id, full_name, email, phone, specialization, profile_image 
                     FROM trainers 
                     ORDER BY created_at DESC";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $trainers = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Fix the profile image path
                $row['profile_image'] = $row['profile_image'] ? 
                    './uploads/' . $row['profile_image'] : 
                    './assets/img/default-profile.png';
                $trainers[] = $row;
            }

            echo json_encode([
                "status" => "success",
                "data" => $trainers
            ]);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Database error: " . $e->getMessage()
            ]);
        }
    }
}

$handler = new TrainersList();
$handler->getTrainers();
?>