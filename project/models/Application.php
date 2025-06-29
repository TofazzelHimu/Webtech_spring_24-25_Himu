<?php
class Application {
    private $conn;
    private $table = 'applications';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function submitApplication($user_id, $job_id) {
        $query = "INSERT INTO " . $this->table . " (user_id, job_id, status) VALUES (?, ?, 'submitted')";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id, $job_id]);
    }

    public function getApplications($user_id) {
        $query = "SELECT a.*, j.title, j.company FROM " . $this->table . " a JOIN jobs j ON a.job_id = j.id WHERE a.user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function setReminder($application_id, $reminder_date) {
        $query = "UPDATE " . $this->table . " SET reminder_date = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$reminder_date, $application_id]);
    }
}
?>