<?php
require_once('./config/database.php');

class AttachmentDownload {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function downloadAttachment($attachment_id) {
        try {
            $query = "SELECT * FROM attachments WHERE id = :attachment_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":attachment_id", $attachment_id);
            $stmt->execute();

            $attachment = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$attachment) {
                throw new Exception('Attachment not found');
            }

            $file_path = '../uploads/' . $attachment['file_path'];
            if (!file_exists($file_path)) {
                throw new Exception('File not found');
            }

            // Set headers for download
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $attachment['original_filename'] . '"');
            header('Content-Length: ' . filesize($file_path));

            // Output file
            readfile($file_path);
            exit;

        } catch (Exception $e) {
            http_response_code(500);
            echo $e->getMessage();
        }
    }
}

if (isset($_GET['id'])) {
    $handler = new AttachmentDownload();
    $handler->downloadAttachment($_GET['id']);
} else {
    http_response_code(400);
    echo 'Attachment ID is required';
}
?>