<?php
class Controller {
    public function model($model) {
        require_once 'C:/xampp/htdocs/OnlineStore/app/models/' . $model . '.php';
        return new $model();
    }
    
    public function view($view, $data = []) {
        extract($data);

        $headerFile = 'C:/xampp/htdocs/OnlineStore/app/views/layouts/header.php';
        $footerFile = 'C:/xampp/htdocs/OnlineStore/app/views/layouts/footer.php';
        
        $viewFile = 'C:/xampp/htdocs/OnlineStore/app/views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require_once $headerFile;
            require_once $viewFile;
            require_once $footerFile;
        } else {
            die('View does not exist: ' . $viewFile);
        }
    }
}