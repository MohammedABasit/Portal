<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'trainers');
define('DB_USER', 'root');
define('DB_PASS', '');

// File upload configuration
define('UPLOAD_BASE_DIR', '../uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

// Allowed file types
define('ALLOWED_TYPES', [
    'profile_picture' => ['image/jpeg', 'image/png'],
    'cv' => ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
    'certificates' => ['application/pdf', 'image/jpeg', 'image/png']
]);
?>