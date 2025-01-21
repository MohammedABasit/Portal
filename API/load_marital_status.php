<?php
require_once('./config/database.php');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Accept');

class MaritalStatuses {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getMaritalStatuses() {
        try {
            $query = "SELECT id, marital_status, hasHusband_Wifes, hasSiblings FROM marital_status ORDER BY id";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $marital_statuses = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $marital_statuses[] = $row;
            }

            echo json_encode([
                "status" => "success",
                "data" => $marital_statuses
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

$handler = new MaritalStatuses();
$handler->getMaritalStatuses();
?>