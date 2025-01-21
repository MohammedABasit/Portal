<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('../config/database.php');
require_once('../models/Trainer.php');
require_once('../models/Academic.php');
require_once('../models/Experience.php');
require_once('../models/Trainings.php');
require_once('../models/Skill.php');
require_once('../models/Hobby.php');
require_once('../models/Illness.php');
require_once('../models/Sport.php');

try {
    $database = new Database();
    $db = $database->getConnection();
    $db->beginTransaction();

    // Check if national ID already exists
    $checkQuery = "SELECT COUNT(*) FROM trainers WHERE national_id = :national_id";
    $stmt = $db->prepare($checkQuery);
    $stmt->bindParam(':national_id', $_POST['national_id']);
    $stmt->execute();
    
    if ($stmt->fetchColumn() > 0) {
        throw new Exception("رقم الهوية الوطنية مسجل مسبقاً");
    }

    // Create new trainer instance
    $trainer = new Trainer($db);
    
    // Set trainer properties from POST data
    $trainer->full_name = $_POST['full_name'];
    $trainer->gender = $_POST['gender'];
    $trainer->birthdate = $_POST['birthdate'];
    $trainer->national_id = $_POST['national_id'];
    $trainer->origin_place = $_POST['origin_place'];
    $trainer->address = $_POST['address'];
    $trainer->marital_status = $_POST['marital_status'];
    $trainer->wifes_count = $_POST['wifes_count'] ?? 0;
    $trainer->children_count = $_POST['children_count'] ?? 0;
    $trainer->father_name = $_POST['father_name'];
    $trainer->father_alive = isset($_POST['father_alive']) ? 1 : 0;
    $trainer->mother_name = $_POST['mother_name'];
    $trainer->mother_alive = isset($_POST['mother_alive']) ? 1 : 0;
    $trainer->health_status = $_POST['health_status'];
    $trainer->mental_health = $_POST['mental_health'];
    $trainer->previous_illness = $_POST['previous-illness'];
    
    // Handle file attachments
    $trainer->profile_photo = $_POST['attachment0'][0] ?? null;
    $trainer->cv_file = $_POST['attachment1'][0] ?? null;
    $trainer->certificates = implode(',', $_POST['attachment2'] ?? []);
    $trainer->other_attachments = implode(',', $_POST['attachment3'] ?? []);

    // Create trainer record
    $trainer_id = $trainer->create();
    if (!$trainer_id) {
        throw new Exception("فشل في إنشاء سجل المدرب");
    }

    // Handle academic history
    if (isset($_POST['sections']) && is_array($_POST['sections'])) {
        $academic = new Academic($db);
        foreach ($_POST['sections'] as $key => $section) {
            $academic->trainer_id = $trainer_id;
            $academic->section = $section;
            $academic->degree = $_POST['degree'][$key];
            $academic->major = $_POST['major'][$key];
            $academic->institution = $_POST['institution'][$key];
            $academic->graduation_year = $_POST['graduation_year'][$key];
            if (!$academic->create()) {
                throw new Exception("فشل في حفظ المؤهلات الأكاديمية");
            }
        }
    }

    // Handle experience records
    if (isset($_POST['work-institution']) && is_array($_POST['work-institution'])) {
        $experience = new Experience($db);
        foreach ($_POST['work-institution'] as $key => $institution) {
            $experience->trainer_id = $trainer_id;
            $experience->institution = $institution;
            $experience->job = $_POST['job'][$key];
            $experience->duration = $_POST['duration'][$key];
            $experience->date_end = $_POST['dateend'][$key] ?? NULL;
            $experience->working = isset($_POST['working'][$key]) ? 1 : 0;
            if (!$experience->create()) {
                throw new Exception("فشل في حفظ سجلات الخبرة");
            }
        }
    }
    
    // Handle Training records
    if (isset($_POST['training-name']) && is_array($_POST['training-name'])) {
        $trainings = new Training($db);
        foreach ($_POST['training-name'] as $key => $training) {
            $trainings->trainer_id = $trainer_id;
            $trainings->training_name = $training[$key];
            $trainings->training_institute = $_POST['train-inistitute'][$key];
            $trainings->training_duration = $_POST['period'][$key];
            $trainings->training_achievement = $_POST['accomplishment'][$key];
            if (!$experience->create()) {
                throw new Exception("فشل في حفظ السجلات التدريبية");
            }
        }
    }

    // Handle skills
    if (isset($_POST['skill']) && is_array($_POST['skill'])) {
        $skill = new Skill($db);
        foreach ($_POST['skill'] as $key => $skill_name) {
            $skill->trainer_id = $trainer_id;
            $skill->skill_name = $skill_name;
            $skill->skill_level = $_POST['skill_level'][$key];
            if (!$skill->create()) {
                throw new Exception("فشل في حفظ المهارات");
            }
        }
    }

    // Handle hobbies
    if (isset($_POST['hoppie']) && is_array($_POST['hoppie'])) {
        $hobby = new Hobby($db);
        foreach ($_POST['hoppie'] as $key => $hobby_name) {
            $hobby->trainer_id = $trainer_id;
            $hobby->hobby_name = $hobby_name;
            $hobby->proficiency_level = $_POST['hoppie_level'][$key];
            if (!$hobby->create()) {
                throw new Exception("فشل في حفظ الهوايات");
            }
        }
    }

    // Handle illnesses
    if (isset($_POST['illness']) && is_array($_POST['illness'])) {
        $illness = new Illness($db);
        foreach ($_POST['illness'] as $key => $illness_type) {
            $illness->trainer_id = $trainer_id;
            $illness->illness_type = $illness_type;
            $illness->start_date = $_POST['illness-date'][$key];
            if (!$illness->create()) {
                throw new Exception("فشل في حفظ سجلات المرض");
            }
        }
    }

    // Handle sports
    if (isset($_POST['sport']) && is_array($_POST['sport'])) {
        $sport = new Sport($db);
        foreach ($_POST['sport'] as $key => $sport_type) {
            $sport->trainer_id = $trainer_id;
            $sport->sport_type = $sport_type;
            $sport->routine = $_POST['routine'][$key];
            if (!$sport->create()) {
                throw new Exception("فشل في حفظ سجلات الرياضة");
            }
        }
    }

    $db->commit();
    
    http_response_code(201);
    echo json_encode(array(
        "success" => true,
        "message" => "تم تسجيل المدرب بنجاح",
        "trainer_id" => $trainer_id
    ));

} catch (Exception $e) {
    if (isset($db)) {
        $db->rollBack();
    }
    
    http_response_code(400);
    echo json_encode(array(
        "success" => false,
        "message" => $e->getMessage()
    ));
}
?>