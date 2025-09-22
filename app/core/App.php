<?php
class App {
    public function __construct() {
        $url = $this->parseUrl();
        
        if (empty($url[0])) {
            $url[0] = 'home';
        }

        $controllerName = strtolower($url[0]);
        $method = isset($url[1]) ? $url[1] : 'index';
        
        if (in_array($controllerName, ['men', 'women'])) {
            $controllerFile = 'C:/xampp/htdocs/OnlineStore/app/controllers/ProductController.php';
            
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controller = new ProductController();
                
                if (method_exists($controller, $controllerName)) {
                    $controller->{$controllerName}();
                    return;
                } else {
                    $this->showError('Method "' . $controllerName . '" not found in ProductController');
                    return;
                }
            } else {
                $this->showError('ProductController not found');
                return;
            }
        }

        if (strtolower($controllerName) === 'sale') {
            $controllerFile = 'C:/xampp/htdocs/OnlineStore/app/controllers/SaleController.php';
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controller = new SaleController();
                
                if (method_exists($controller, 'index')) {
                    $controller->index();
                    return;
                } else {
                    $this->showError('Index method not found in SaleController');
                    return;
                }
            } else {
                $this->showError('SaleController not found');
                return;
            }
        }

        $controllerName = ucfirst($controllerName) . 'Controller';
        $controllerFile = 'C:/xampp/htdocs/OnlineStore/app/controllers/' . $controllerName . '.php';
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                
                if (method_exists($controller, $method)) {
                    $params = array_slice($url, 2);
                    call_user_func_array([$controller, $method], $params);
                } else {
                    $this->showError('Method "' . $method . '" not found in ' . $controllerName);
                }
            } else {
                $this->showError('Class "' . $controllerName . '" not found');
            }
        } else {
            $this->showError('Controller "' . $controllerName . '" not found');
        }
    }
    
    public function parseUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
    
    private function showError($message) {
        echo "<!DOCTYPE html>";
        echo "<html><head><title>Error</title></head><body>";
        echo "<div style='text-align: center; margin-top: 50px; font-family: Arial, sans-serif;'>";
        echo "<h1 style='color: red;'>Error</h1>";
        echo "<p>" . htmlspecialchars($message) . "</p>";
        echo "<p><a href='" . APP_URL . "' style='color: blue;'>Go to Homepage</a></p>";
        echo "</div></body></html>";
        exit();
    }
}