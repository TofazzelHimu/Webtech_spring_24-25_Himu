<?php
require_once '../config/database.php';
require_once '../models/Job.php';

class JobController {
    private $db;
    private $job;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->job = new Job($this->db);
    }

    public function index() {
        $jobs = $this->job->getAllJobs();
        // Ensure $jobs is always an array
        $jobs = $jobs ?: [];
        include '../views/layouts/main.php';
        include '../views/job/index.php';
    }

    public function view($id) {
        $job = $this->job->getJobById($id);
        if (!$job) {
            die("Job not found");
        }
        include '../views/layouts/main.php';
        include '../views/job/view.php';
    }

    public function search() {
        $query = isset($_GET['q']) ? trim($_GET['q']) : '';
        $jobs = $this->job->searchJobs($query);
        $jobs = $jobs ?: [];
        include '../views/layouts/main.php';
        include '../views/job/search.php';
    }

    public function saveJob($user_id, $job_id) {
        // Placeholder for saving job (requires authentication)
        echo "Job $job_id saved for user $user_id";
    }
}
?>