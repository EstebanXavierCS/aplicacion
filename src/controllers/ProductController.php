<?php
class ProductController {
    private $db;

    public function __construct() {
        try {
            $this->db = Database::getInstance()->getConnection();
            
            // Create products table if it doesn't exist
            $this->db->exec('
                CREATE TABLE IF NOT EXISTS products (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    description TEXT,
                    price DECIMAL(10,2) NOT NULL,
                    image_url TEXT
                )
            ');
        } catch(Exception $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getAllProducts() {
        try {
            $result = $this->db->query('SELECT * FROM products');
            $products = [];
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $products[] = $row;
            }
            return $products;
        } catch(Exception $e) {
            return [];
        }
    }

    public function addProduct($name, $description, $price, $image_url) {
        try {
            $stmt = $this->db->prepare('INSERT INTO products (name, description, price, image_url) VALUES (:name, :description, :price, :image_url)');
            $stmt->bindValue(':name', $name, SQLITE3_TEXT);
            $stmt->bindValue(':description', $description, SQLITE3_TEXT);
            $stmt->bindValue(':price', $price, SQLITE3_FLOAT);
            $stmt->bindValue(':image_url', $image_url, SQLITE3_TEXT);
            return $stmt->execute();
        } catch(Exception $e) {
            return false;
        }
    }
}
?>