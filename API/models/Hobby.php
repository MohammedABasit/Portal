<?php
class Hobby {
    private $conn;
    private $table_name = "hobbies";

    public $id;
    public $trainer_id;
    public $hobby_name;
    public $proficiency_level;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        try {
            $query = "INSERT INTO " . $this->table_name . "
                    (trainer_id, hobby_name, proficiency_level)
                    VALUES
                    (:trainer_id, :hobby_name, :proficiency_level)";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":trainer_id", $this->trainer_id);
            $stmt->bindParam(":hobby_name", $this->hobby_name);
            $stmt->bindParam(":proficiency_level", $this->proficiency_level);

            return $stmt->execute();
        } catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>