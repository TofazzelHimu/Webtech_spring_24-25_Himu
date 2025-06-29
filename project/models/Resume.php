<?php
class Resume {
    private $conn;
    private $table = 'resumes';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function uploadResume($user_id, $file_path) {
        $query = "INSERT INTO " . $this->table . " (user_id, file_path, profile_strength) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id, $file_path, 50]);
    }

    public function createResume($user_id, $content) {
        $query = "INSERT INTO " . $this->table . " (user_id, content, profile_strength) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $strength = $this->calculateProfileStrength($content);
        $stmt->execute([$user_id, $content, $strength]);
    }

    public function getResume($user_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function calculateProfileStrength($content) {
        return strlen($content) > 100 ? 80 : 20;
    }
}
?>