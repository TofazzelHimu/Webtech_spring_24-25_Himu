<?php
require_once '../config/database.php';
require_once '../models/Application.php';

class ApplicationController {
    private $db;
    private $application;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->application = new Application($this->db);
    }

    public function status($user_id) {
        $applications = $this->application->getApplications($user_id);
        $applications = $applications ?: [];
        include '../views/layouts/main.php';
        include '../views/application/status.php';
    }

    public function employerLog($user_id) {
        $applications = $this->application->getApplications($user_id);
        $applications = $applications ?: [];
        include '../views/layouts/main.php';
        include '../views/application/employer_log.php';
    }

    public function reminders($user_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reminder_date']) && isset($_POST['application_id'])) {
            $this->application->setReminder($_POST['application_id'], $_POST['reminder_date']);
        }
        $applications = $this->application->getApplications($user_id);
        $applications = $applications ?: [];
        include '../views/layouts/main.php';
        include '../views/application/reminders.php';
    }

    public function apply($user_id, $job_id) {
        try {
            $this->application->submitApplication($user_id, $job_id);
            header("Location: /application/status/$user_id");
            exit;
        } catch (PDOException $e) {
            error_log("Error submitting application: " . $e->getMessage());
            echo "Failed to submit application. Please try again.";
        }
    }
}
?>