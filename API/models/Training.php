<?php
class Training {
    private $conn;
    private $table_name = "trainings_exp";

    public $id;
    public $trainer_id;
    public $training_name;
    public $training_institute;
    public $training_duration;
    public $training_achievement;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        try {
            $query = "INSERT INTO " . $this->table_name . "
                    (trainer_id, training_name, training_institute, training_duration, training_achievement)
                    VALUES
                    (:trainer_id, :training_name, :training_institute, :training_duration, :training_achievement)";

            $stmt = $this->conn->prepare($query);

            // Basic fields
            $stmt->bindParam(":trainer_id", $this->trainer_id);
            $stmt->bindParam(":training_name", $this->training_name);
            $stmt->bindParam(":training_institute", $this->training_institute);
            $stmt->bindParam(":training_duration", $this->training_duration);
            $stmt->bindParam(":training_achievement", $this->training_achievement);

            return $stmt->execute();
        } catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>