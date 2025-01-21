<?php
require_once('../config/database.php');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Accept');

class Sections {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getSections() {
        try {
            $query = "SELECT id, section_name FROM academic_sections ORDER BY id";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $sections = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $sections[] = $row;
            }

            echo json_encode([
                "status" => "success",
                "data" => $sections
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

$handler = new Sections();
$handler->getSections();
?>