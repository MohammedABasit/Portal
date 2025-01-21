<?php
require_once('./config/database.php');

header('Content-Type: application/json');

class TrainerDetails {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getTrainerDetails($trainer_id) {
        try {
            // Get trainer information
            $trainer = $this->getTrainerInfo($trainer_id);
            
            // Get training history
            $trainer['training_history'] = $this->getTrainingHistory($trainer_id);
            
            // Get attachments
            $trainer['attachments'] = $this->getAttachments($trainer_id);

            echo json_encode([
                "status" => "success",
                "data" => $trainer
            ]);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => $e->getMessage()
            ]);
        }
    }

    private function getTrainerInfo($trainer_id) {
        $query = "SELECT * FROM trainers WHERE id = :trainer_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":trainer_id", $trainer_id);
        $stmt->execute();

        $trainer = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$trainer) {
            throw new Exception('Trainer not found');
        }

        $trainer['profile_image'] = $trainer['profile_image'] ? 
            '../uploads/' . $trainer['profile_image'] : 
            '../assets/img/default-profile.jpg';

        return $trainer;
    }

    private function getTrainingHistory($trainer_id) {
        $query = "SELECT * FROM training_history WHERE trainer_id = :trainer_id ORDER BY start_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":trainer_id", $trainer_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getAttachments($trainer_id) {
        $query = "SELECT * FROM attachments WHERE trainer_id = :trainer_id ORDER BY uploaded_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":trainer_id", $trainer_id);
        $stmt->execute();

        $attachments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($attachments as &$attachment) {
            $attachment['download_url'] = '../uploads/' . $attachment['file_path'];
        }

        return $attachments;
    }
}

if (isset($_GET['id'])) {
    $handler = new TrainerDetails();
    $handler->getTrainerDetails($_GET['id']);
} else {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Trainer ID is required"
    ]);
}
?>