<?php
class Job {
    private $conn;
    private $table = 'jobs';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllJobs() {
        try {
            $query = "SELECT * FROM " . $this->table . " ORDER BY posted_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching jobs: " . $e->getMessage());
            return [];
        }
    }

    public function getJobById($id) {
        try {
            $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching job ID $id: " . $e->getMessage());
            return null;
        }
    }

    public function searchJobs($query) {
        try {
            $search = "%$query%";
            $sql = "SELECT * FROM " . $this->table . " WHERE title LIKE ? OR description LIKE ? OR company LIKE ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$search, $search, $search]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error searching jobs: " . $e->getMessage());
            return [];
        }
    }
}
?>