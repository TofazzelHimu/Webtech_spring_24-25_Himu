<?php
require_once '../config/database.php';
require_once '../models/Resume.php';

class ResumeController {
    private $db;
    private $resume;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->resume = new Resume($this->db);
    }

    public function upload($user_id) {
        if ($_FILES['resume']['name']) {
            $file_path = 'uploads/' . basename($_FILES['resume']['name']);
            move_uploaded_file($_FILES['resume']['tmp_name'], $file_path);
            $this->resume->uploadResume($user_id, $file_path);
        }
        include '../views/layouts/main.php';
        include '../views/resume/upload.php';
    }

    public function builder($user_id) {
        if ($_POST['content']) {
            $this->resume->createResume($user_id, $_POST['content']);
        }
        include '../views/layouts/main.php';
        include '../views/resume/builder.php';
    }

    public function profile($user_id) {
        $resume = $this->resume->getResume($user_id);
        include '../views/layouts/main.php';
        include '../views/resume/profile.php';
    }
}
?>