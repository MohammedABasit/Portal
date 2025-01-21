<?php
class FileHelper {
    private $upload_base_dir = '../uploads/';

    public function __construct() {
        if (!file_exists($this->upload_base_dir)) {
            mkdir($this->upload_base_dir, 0777, true);
        }
    }

    public function uploadFile($file, $subdirectory, $allowed_types) {
        $upload_dir = $this->upload_base_dir . $subdirectory . '/';
        
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Validate file type
        if (!in_array($file['type'], $allowed_types)) {
            throw new Exception('Invalid file type');
        }

        // Generate unique filename
        $filename = uniqid() . '_' . basename($file['name']);
        $file_path = $upload_dir . $filename;

        if (!move_uploaded_file($file['tmp_name'], $file_path)) {
            throw new Exception('Failed to upload file');
        }

        return [
            'filename' => $filename,
            'original_filename' => $file['name'],
            'file_path' => $subdirectory . '/' . $filename
        ];
    }
}
?>