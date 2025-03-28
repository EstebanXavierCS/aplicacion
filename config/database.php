<?php
class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        try {
            $dbPath = __DIR__ . '/../database/shop.db';
            $dbDir = dirname($dbPath);
            
            // Create database directory if it doesn't exist
            if (!is_dir($dbDir)) {
                mkdir($dbDir, 0777, true);
            }
            
            // Create database file if it doesn't exist
            if (!file_exists($dbPath)) {
                touch($dbPath);
                chmod($dbPath, 0777);
            }
            
            $this->conn = new SQLite3($dbPath);
            $this->conn->exec('PRAGMA foreign_keys = ON;');
            
        } catch(Exception $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>