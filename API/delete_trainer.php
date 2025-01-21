<?php
require_once('./config/database.php');

header('Content-Type: application/json');

class TrainerDelete {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function deleteTrainer($trainer_id) {
        try {
            $this->conn->beginTransaction();

            // Delete trainer's files
            $this->deleteTrainerFiles($trainer_id);

            // Delete trainer record (cascades to training_history and attachments)
            $query = "DELETE FROM trainers WHERE id = :trainer_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":trainer_id", $trainer_id);
            $stmt->execute();

            $this->conn->commit();

            echo json_encode([
                "status" => "success",
                "message" => "Trainer deleted successfully"
            ]);

        } catch (Exception $e) {
            $this->conn->rollBack();
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    private function deleteTrainerFiles($trainer_id) {
        // Get all file paths
        $query = "SELECT file_path FROM attachments WHERE trainer_id = :trainer_id
                 UNION
                 SELECT profile_image FROM trainers WHERE id = :trainer_id AND profile_image IS NOT NULL";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":trainer_id", $trainer_id);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $file_path = '../uploads/' . $row['file_path'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
    }
}

if (isset($_POST['trainer_id'])) {
    $handler = new TrainerDelete();
    $handler->deleteTrainer($_POST['trainer_id']);
} else {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Trainer ID is required"
    ]);
}
?>