<?php
class TrainingHistory {
    private $conn;
    private $table = 'training_history';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($trainer_id, $institutions) {
        $query = "INSERT INTO " . $this->table . " 
                 (trainer_id, institution_name, course, start_date, end_date) 
                 VALUES (:trainer_id, :institution_name, :course, :start_date, :end_date)";
        
        $stmt = $this->conn->prepare($query);

        foreach ($institutions as $institution) {
            $stmt->bindParam(':trainer_id', $trainer_id);
            $stmt->bindParam(':institution_name', $institution['name']);
            $stmt->bindParam(':course', $institution['course']);
            $stmt->bindParam(':start_date', $institution['start_date']);
            $stmt->bindParam(':end_date', $institution['end_date']);
            
            if(!$stmt->execute()) {
                throw new Exception("Failed to save training history");
            }
        }
        return true;
    }
}
?>