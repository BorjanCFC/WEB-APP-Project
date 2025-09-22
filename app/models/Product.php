<?php
require_once 'C:/xampp/htdocs/OnlineStore/config/Database.php';

class Product {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die("Database connection failed: " . $this->conn->connect_error);
        }
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function getProductsByCategory($category, $type = null) {
        $category = strtolower($category);
        $sql = "SELECT id, category, price, sale, brand, size, name, reviews, type, image
            FROM product 
            WHERE LOWER(category) = ?";
        
        $params = "s";
        $bindValues = [$category];
        
        if ($type) {
            $sql .= " AND LOWER(type) = ?";
            $params .= "s";
            $bindValues[] = strtolower($type);
        }
        
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            error_log("Prepare failed: " . $this->conn->error);
            return [];
        }

        $stmt->bind_param($params, ...$bindValues);
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            return [];
        }

        $result = $stmt->get_result();
        $products = [];

        while ($row = $result->fetch_assoc()) {
            $discountPercent = intval($row['sale']);
            $originalPrice = floatval($row['price']);
            $finalPrice = $originalPrice;
            
            if ($discountPercent > 0) {
                $finalPrice = $originalPrice * (1 - $discountPercent / 100);
            }
            
            $products[] = [
                'id' => $row['id'],
                'name' => $row['name'] ?? 'Unknown Product',
                'price' => $finalPrice,
                'old_price' => $discountPercent > 0 ? $originalPrice : 0,
                'brand' => $row['brand'] ?? '',
                'size' => $row['size'] ?? '',
                'reviews' => floatval($row['reviews']),
                'image' => $row['image'] ?? 'http://localhost/OnlineStore/public/images/img1.png',
                'discount' => $discountPercent . '% OFF',
                'tag' => $discountPercent > 0 ? 'Sale' : '',
                'type' => $row['type'] ?? ''
            ];
        }

        $stmt->close();
        return $products;
    }

    public function getSaleProducts() {
        $sql = "SELECT id, category, price, sale, brand, size, name, reviews, type, image
                FROM product 
                WHERE sale >= 50";
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

        while ($row = $result->fetch_assoc()) {
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

        $stmt->close();
        return $products;
    }

    public function getProductById($productId) {
        $sql = "SELECT id, name, price, sale, brand, size, reviews, type, category, image 
                FROM product 
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        
        if ($stmt === false) {
            error_log("Prepare failed: " . $this->conn->error);
            return null;
        }
        
        $stmt->bind_param("i", $productId);
        
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            return null;
        }
        
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $discountPercent = intval($row['sale']);
            $finalPrice = floatval($row['price']);
            
            if ($discountPercent > 0) {
                $finalPrice = $finalPrice * (1 - $discountPercent / 100);
            }
            
            return [
                'id' => $row['id'],
                'name' => $row['name'] ?? 'Unknown Product',
                'price' => round($finalPrice, 2),
                'original_price' => floatval($row['price']),
                'brand' => $row['brand'] ?? '',
                'size' => $row['size'] ?? '',
                'reviews' => floatval($row['reviews']),
                'type' => $row['type'] ?? '',
                'category' => $row['category'] ?? '',
                'discount' => $discountPercent,
                'image' => $row['image'] ?? 'http://localhost/OnlineStore/public/images/img1.png',
            ];
        }
        
        $stmt->close();
        return null;
    }

}