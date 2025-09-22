<?php
require_once 'C:/xampp/htdocs/OnlineStore/app/models/Product.php';

class ProductController {
    private $productModel;
    private $productsPerPage = 9;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function men() {
        $this->loadCategory('men', "Men's Collection | FashionForward");
    }

    public function women() {
        $this->loadCategory('women', "Women's Collection | FashionForward");
    }

    private function loadCategory($category, $title) {
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $currentPage = max(1, $currentPage); 

        $currentFilter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

        $allProducts = $this->productModel->getProductsByCategory($category);

        if ($currentFilter !== 'all') {
            $allProducts = array_filter($allProducts, function ($product) use ($currentFilter) {
                $productType = isset($product['type']) ? strtolower($product['type']) : '';

                if ($currentFilter === 'accessory' && $productType === 'accessories') {
                    return true;
                }

                return $productType === $currentFilter;
            });
        }

        $totalProducts = count($allProducts);
        $totalPages = ceil($totalProducts / $this->productsPerPage);
        $currentPage = min($currentPage, $totalPages);

        $startIndex = ($currentPage - 1) * $this->productsPerPage;
        $products = array_slice($allProducts, $startIndex, $this->productsPerPage);

        $data = [
            'products'      => $products,
            'title'         => $title,
            'category'      => ucfirst($category),
            'currentPage'   => $currentPage,
            'totalPages'    => $totalPages,
            'totalProducts' => $totalProducts
        ];

        require_once 'C:/xampp/htdocs/OnlineStore/app/views/Category.php';
    }
}