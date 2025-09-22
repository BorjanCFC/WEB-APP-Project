<?php
require_once 'C:/xampp/htdocs/OnlineStore/app/models/Product.php';

class SaleController {
    private $productModel;
    private $productsPerPage = 9;

    public function __construct() {
        $this->productModel = new Product();
    }

    public function index() {
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $currentPage = max(1, $currentPage);

        $currentFilter = isset($_GET['filter']) ? strtolower($_GET['filter']) : 'all';

        $allProducts = $this->productModel->getSaleProducts();

        if ($currentFilter !== 'all') {
            $allProducts = array_filter($allProducts, function ($product) use ($currentFilter) {
                $productType = isset($product['type']) ? strtolower($product['type']) : '';

                // Normalize accessory vs accessories
                if ($currentFilter === 'accessory' && $productType === 'accessories') {
                    return true;
                }

                return $productType === $currentFilter;
            });
        }

        $totalProducts = count($allProducts);
        $totalPages = ceil($totalProducts / $this->productsPerPage);
        $currentPage = min($currentPage, $totalPages > 0 ? $totalPages : 1);

        $startIndex = ($currentPage - 1) * $this->productsPerPage;
        $products = array_slice($allProducts, $startIndex, $this->productsPerPage);

        $data = [
            'category'      => "Sale",
            'products'      => $products,
            'title'         => "Big Sale | FashionForward",
            'currentPage'   => $currentPage,
            'totalPages'    => $totalPages,
            'totalProducts' => $totalProducts,
            'currentFilter' => $currentFilter
        ];

        require_once 'C:/xampp/htdocs/OnlineStore/app/views/Sale.php';
    }
}