<?php
require_once 'C:/xampp/htdocs/OnlineStore/app/models/HomeModel.php';

class HomeController extends Controller {
    public function index() {
        $homeModel = $this->model('HomeModel');
        
        if (!$homeModel) {
            error_log("Failed to load HomeModel");
            $featured_products = [];
        } else {
            $featured_products = $homeModel->getTop3Products();
            error_log("Products count: " . count($featured_products));
            
            if (!empty($featured_products)) {
                error_log("First product: " . print_r($featured_products[0], true));
            }
        } 
        
        $data = [
            'title' => 'FashionForward',
            'products' => $featured_products
        ];
        
        $this->view('home', $data);
    }
}