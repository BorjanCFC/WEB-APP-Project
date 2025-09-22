<?php

class AboutUsController {
    
    public function index() {
        $data = [
            'title' => "About Us | FashionForward"
        ];

        require_once 'C:/xampp/htdocs/OnlineStore/app/views/AboutUs.php';
    }
}
