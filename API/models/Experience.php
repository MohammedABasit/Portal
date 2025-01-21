<?php
class Experience {
    private $conn;
    private $table_name = "experience_records";

    public $id;
    public $trainer_id;
    public $institution;
    public $job;
    public $duration;
    public $date_end;
    public $working;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        try {
            $query = "INSERT INTO " . $this->table_name . "
                    (trainer_id, institution, job, duration, date_end, working)
                    VALUES
                    (:trainer_id, :institution, :job, :duration, :date_end, :working)";

            $stmt = $this->conn->prepare($query);

            // Basic fields
            $stmt->bindParam(":trainer_id", $this->trainer_id);
            $stmt->bindParam(":institution", $this->institution);
            $stmt->bindParam(":job", $this->job);
            $stmt->bindParam(":duration", $this->duration);
            
            // Handle working status and date_end
            $isWorking = filter_var($this->working, FILTER_VALIDATE_BOOLEAN);
            
            if ($isWorking) {
                // If working is true, set date_end to null
                $stmt->bindValue(":date_end", null, PDO::PARAM_NULL);
            } else {
                // If not working, use the provided date_end
                if (empty($this->date_end)) {
                    $stmt->bindValue(":date_end", null, PDO::PARAM_NULL);
                } else {
                    $stmt->bindParam(":date_end", $this->date_end);
                }
            }
                $stmt->bindValue(":working", $this->working);

            return $stmt->execute();
        } catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>