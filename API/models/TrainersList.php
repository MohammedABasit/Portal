<?php
class TrainersList {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getTrainers() {
        try {
            $query = "SELECT trainers.id, full_name, profile_photo, national_id, genders.gender, birthdate, address 
                     FROM trainers JOIN genders ON genders.id = trainers.gender
                     ORDER BY id DESC";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            throw new Exception("Error fetching trainers: " . $e->getMessage());
        }
    }
}
?>