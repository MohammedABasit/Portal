<?php
class Skill {
    private $conn;
    private $table_name = "skills";

    public $id;
    public $trainer_id;
    public $skill_name;
    public $skill_level;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        try {
            $query = "INSERT INTO " . $this->table_name . "
                    (trainer_id, skill_name, skill_level)
                    VALUES
                    (:trainer_id, :skill_name, :skill_level)";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":trainer_id", $this->trainer_id);
            $stmt->bindParam(":skill_name", $this->skill_name);
            $stmt->bindParam(":skill_level", $this->skill_level);

            return $stmt->execute();
        } catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>