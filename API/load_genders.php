<?php
require_once('./config/database.php');

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Accept');

class Genders {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getGenders() {
        try {
            $query = "SELECT id, gender FROM genders ORDER BY id";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            $genders = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $genders[] = $row;
            }

            echo json_encode([
                "status" => "success",
                "data" => $genders
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

$handler = new Genders();
$handler->getGenders();
?>