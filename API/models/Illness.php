<?php
class Illness {
    private $conn;
    private $table_name = "illnesses";

    public $id;
    public $trainer_id;
    public $illness_type;
    public $start_date;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        try {
            $query = "INSERT INTO " . $this->table_name . "
                    (trainer_id, illness_type, start_date)
                    VALUES
                    (:trainer_id, :illness_type, :start_date)";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":trainer_id", $this->trainer_id);
            $stmt->bindParam(":illness_type", $this->illness_type);
            $stmt->bindParam(":start_date", $this->start_date);

            return $stmt->execute();
        } catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>