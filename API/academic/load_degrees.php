<?php
require_once('../config/database.php');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Accept');

class Degrees {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getDegrees($sectionId) {
        try {
            if (!$sectionId) {
                throw new Exception("Section ID is required");
            }
            $query = "SELECT id, degree_name, SectionID FROM academic_degrees WHERE SectionID = ? ORDER BY id";

            $stmt = $this->conn->prepare($query);
            $stmt->execute([$sectionId]);
            
            $degrees = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $degrees[] = $row;
            }

            echo json_encode([
                "status" => "success",
                "data" => $degrees
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

$handler = new Degrees();
$sectionId = isset($_GET['section_id']) ? $_GET['section_id'] : null;
$handler->getDegrees($sectionId);
?>