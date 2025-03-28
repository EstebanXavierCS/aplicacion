<?php
class ProductController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAllProducts() {
        $result = $this->db->query('SELECT * FROM products');
        $products = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $products[] = $row;
        }
        return $products;
    }

    public function addProduct($name, $description, $price, $image_url) {
        $stmt = $this->db->prepare('INSERT INTO products (name, description, price, image_url) VALUES (:name, :description, :price, :image_url)');
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $stmt->bindValue(':description', $description, SQLITE3_TEXT);
        $stmt->bindValue(':price', $price, SQLITE3_FLOAT);
        $stmt->bindValue(':image_url', $image_url, SQLITE3_TEXT);
        return $stmt->execute();
    }
}
?>