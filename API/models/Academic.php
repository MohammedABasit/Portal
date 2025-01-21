<?php
class Academic {
    private $conn;
    private $table_name = "academic_history";

    public $id;
    public $trainer_id;
    public $section;
    public $degree;
    public $major;
    public $institution;
    public $graduation_year;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        try {
            $query = "INSERT INTO " . $this->table_name . "
                    (trainer_id, section, degree, major, institution, graduation_year)
                    VALUES
                    (:trainer_id, :section, :degree, :major, :institution, :graduation_year)";

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":trainer_id", $this->trainer_id);
            $stmt->bindParam(":section", $this->section);
            $stmt->bindParam(":degree", $this->degree);
            $stmt->bindParam(":major", $this->major);
            $stmt->bindParam(":institution", $this->institution);
            $stmt->bindParam(":graduation_year", $this->graduation_year);

            return $stmt->execute();
        } catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>