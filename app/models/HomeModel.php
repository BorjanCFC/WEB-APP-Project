<?php
require_once 'C:/xampp/htdocs/OnlineStore/config/Database.php';

class HomeModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die("Database connection failed: " . $this->conn->connect_error);
        }
    }

    public function getTop3Products() {
    if ($this->conn->connect_error) {
        error_log("Database connection error: " . $this->conn->connect_error);
        return [];
    }

    $sql = "SELECT id, category, price, sale, brand, size, name, reviews, type, image
            FROM product
            ORDER BY sale DESC
            LIMIT 3;";
    
    error_log("SQL Query: " . $sql);
    
    $stmt = $this->conn->prepare($sql);

    if ($stmt === false) {
        error_log("Prepare failed: " . $this->conn->error);
        return [];
    }

    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        return [];
    }

    $result = $stmt->get_result();
    $products = [];
    $rowCount = 0;

    while ($row = $result->fetch_assoc()) {
        $rowCount++;
        error_log("Row $rowCount: " . print_r($row, true));
        
        $discountPercent = intval($row['sale']);
        $finalPrice = floatval($row['price']) * (1 - $discountPercent / 100);

        $products[] = [
            'id' => $row['id'],
            'name' => $row['name'] ?? 'Unknown Product',
            'price' => round($finalPrice, 2),
            'old_price' => floatval($row['price']),
            'brand' => $row['brand'] ?? '',
            'size' => $row['size'] ?? '',
            'reviews' => floatval($row['reviews']),
            'category' => $row['category'],
            'discount' => $discountPercent . '% OFF',
            'image' => $row['image'] ?? 'http://localhost/OnlineStore/public/images/img1.png',
            'tag' => 'Sale',
            'type' => $row['type'] ?? ''
        ];
    }

    error_log("Total rows fetched: " . $rowCount);
    $stmt->close();
    return $products;
    }

}