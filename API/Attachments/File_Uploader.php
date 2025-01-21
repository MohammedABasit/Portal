<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed"));
    exit();
}

// Define upload directories for different file types
$uploadDirs = [
    'profile' => __DIR__ . '/../../uploads/profile_images/',
    'cv' => __DIR__ . '/../../uploads/cvs/',
    'certificates' => __DIR__ . '/../../uploads/certificates/',
    'other' => __DIR__ . '/../../uploads/other_attachments/'
];

// Create directories if they don't exist
foreach ($uploadDirs as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
}

try {
    if (!isset($_FILES['file'])) {
        throw new Exception('No file uploaded');
    }

    $file = $_FILES['file'];
    $fileName = uniqid() . '_' . basename($file['name']);
    
    // Get the upload type from the request
    $uploadType = isset($_POST['uploadType']) ? $_POST['uploadType'] : 'other';
    
    // Determine upload directory based on the source dropzone
    switch ($uploadType) {
        case 'profile':
            if (strpos($file['type'], 'image') !== false) {
                $uploadDir = $uploadDirs['profile'];
            } else {
                throw new Exception('Only image files are allowed for profile photos');
            }
            break;
            
        case 'cv':
            if ($file['type'] === 'application/pdf' || 
                $file['type'] === 'application/msword' || 
                $file['type'] === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                $uploadDir = $uploadDirs['cv'];
            } else {
                throw new Exception('Only PDF and Word documents are allowed for CVs');
            }
            break;
            
        case 'certificates':
            if ($file['type'] === 'application/pdf' || 
                strpos($file['type'], 'image') !== false || 
                $file['type'] === 'application/msword' || 
                $file['type'] === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                $uploadDir = $uploadDirs['certificates'];
            } else {
                throw new Exception('Invalid file type for certificates');
            }
            break;
            
        default:
            $uploadDir = $uploadDirs['other'];
    }

    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        // Return relative path from uploads directory
        $relativePath = str_replace(__DIR__ . '/../../uploads/', '', $targetPath);
        echo json_encode(array(
            "success" => true,
            "file" => $relativePath,
            "message" => "File uploaded successfully"
        ));
    } else {
        throw new Exception('Failed to move uploaded file');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(array(
        "success" => false,
        "message" => $e->getMessage()
    ));
}
?>