<?php
class Attachment {
    private $conn;
    private $table = 'attachments';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($trainer_id, $type, $file_info) {
        $query = "INSERT INTO " . $this->table . " 
                 (trainer_id, type, filename, original_filename, file_path) 
                 VALUES (:trainer_id, :type, :filename, :original_filename, :file_path)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':trainer_id', $trainer_id);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':filename', $file_info['filename']);
        $stmt->bindParam(':original_filename', $file_info['original_filename']);
        $stmt->bindParam(':file_path', $file_info['file_path']);

        if(!$stmt->execute()) {
            throw new Exception("Failed to save attachment reference");
        }
        return true;
    }
}
?>