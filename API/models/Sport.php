<?php
class Sport {
    private $conn;
    private $table_name = "sports";

    public $id;
    public $trainer_id;
    public $sport_type;
    public $routine;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        try {
            $query = "INSERT INTO " . $this->table_name . "
                    (trainer_id, sport_type, routine)
                    VALUES
                    (:trainer_id, :sport_type, :routine)";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":trainer_id", $this->trainer_id);
            $stmt->bindParam(":sport_type", $this->sport_type);
            $stmt->bindParam(":routine", $this->routine);

            return $stmt->execute();
        } catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>