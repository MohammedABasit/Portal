<?php
class Trainer {
    private $conn;
    private $table_name = "trainers";

    // Trainer properties
    public $id;
    public $full_name;
    public $gender;
    public $birthdate;
    public $national_id;
    public $origin_place;
    public $address;
    public $marital_status;
    public $wifes_count;
    public $children_count;
    public $father_name;
    public $father_alive;
    public $mother_name;
    public $mother_alive;
    public $health_status;
    public $mental_health;
    public $previous_illness;
    public $profile_photo;
    public $cv_file;
    public $certificates;
    public $other_attachments;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        try {
            $query = "INSERT INTO " . $this->table_name . "
                    (full_name, gender, birthdate, national_id, origin_place, 
                     address, marital_status, wifes_count, children_count,
                     father_name, father_alive, mother_name, mother_alive,
                     health_status, mental_health, previous_illness,
                     profile_photo, cv_file, certificates, other_attachments)
                    VALUES
                    (:full_name, :gender, :birthdate, :national_id, :origin_place,
                     :address, :marital_status, :wifes_count, :children_count,
                     :father_name, :father_alive, :mother_name, :mother_alive,
                     :health_status, :mental_health, :previous_illness,
                     :profile_photo, :cv_file, :certificates, :other_attachments)";

            $stmt = $this->conn->prepare($query);

            // Sanitize and bind values
            $stmt->bindParam(":full_name", $this->full_name);
            $stmt->bindParam(":gender", $this->gender);
            $stmt->bindParam(":birthdate", $this->birthdate);
            $stmt->bindParam(":national_id", $this->national_id);
            $stmt->bindParam(":origin_place", $this->origin_place);
            $stmt->bindParam(":address", $this->address);
            $stmt->bindParam(":marital_status", $this->marital_status);
            $stmt->bindParam(":wifes_count", $this->wifes_count);
            $stmt->bindParam(":children_count", $this->children_count);
            $stmt->bindParam(":father_name", $this->father_name);
            $stmt->bindParam(":father_alive", $this->father_alive);
            $stmt->bindParam(":mother_name", $this->mother_name);
            $stmt->bindParam(":mother_alive", $this->mother_alive);
            $stmt->bindParam(":health_status", $this->health_status);
            $stmt->bindParam(":mental_health", $this->mental_health);
            $stmt->bindParam(":previous_illness", $this->previous_illness);
            $stmt->bindParam(":profile_photo", $this->profile_photo);
            $stmt->bindParam(":cv_file", $this->cv_file);
            $stmt->bindParam(":certificates", $this->certificates);
            $stmt->bindParam(":other_attachments", $this->other_attachments);

            if($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
            return false;
        } catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>