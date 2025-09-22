<?php
require_once 'C:/xampp/htdocs/OnlineStore/config/config.php';
require_once 'C:/xampp/htdocs/OnlineStore/config/Database.php';
require_once 'C:/xampp/htdocs/OnlineStore/app/models/Cart.php';

class CartController extends Controller
{
    private $cart;

    public function __construct()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: ' . APP_URL . '/auth/login');
            exit();
        }

        $this->cart = new Cart();
    }

    public function index()
    {
        $items = $this->cart->getItems();
        $total = $this->cart->getTotal();

        $this->view('Cart', [
            'cartItems' => $items,
            'total' => $total,
            'title' => 'Your Cart!'
        ]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $item = [
                'id' => $_POST['id'],
                'name' => $_POST['name'],
                'price' => floatval($_POST['price']),
                'image' => $_POST['image']
            ];
            $this->cart->addItem($item);

            echo json_encode([
                'success' => true,
                'items' => $this->cart->getItems(),
                'total' => $this->cart->getTotal()
            ]);
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->cart->updateQuantity($_POST['id'], $_POST['quantity']);

            echo json_encode([
                'success' => true,
                'items' => $this->cart->getItems(),
                'total' => $this->cart->getTotal()
            ]);
        }
    }

    public function remove()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->cart->removeItem($_POST['id']);

            echo json_encode([
                'success' => true,
                'items' => $this->cart->getItems(),
                'total' => $this->cart->getTotal()
            ]);
        }
    }

    public function checkout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $_SESSION['user'] ?? null;

            if (!$user) {
                echo json_encode([
                    'success' => false,
                    'message' => 'You must be logged in to make a payment.'
                ]);
                exit();
            }

            $cardNumber = trim($_POST['card_number'] ?? '');
            $expiryDate = trim($_POST['expiry_date'] ?? '');
            $cvv = trim($_POST['cvv'] ?? '');

            if (empty($cardNumber) || empty($expiryDate) || empty($cvv)) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Please fill in all payment details.'
                ]);
                exit();
            }

            try {
                $database = new Database();
                $db = $database->getConnection();

                $stmt = $db->prepare("SELECT card_number, expiry_date, cvv FROM users WHERE user_id = :user_id LIMIT 1");
                $stmt->bindParam(':user_id', $user['user_id']);
                $stmt->execute();
                $dbUser = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$dbUser || 
                    $cardNumber !== $dbUser['card_number'] ||
                    $expiryDate !== $dbUser['expiry_date'] ||
                    $cvv !== $dbUser['cvv']
                ) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Invalid payment details. Please try again.'
                    ]);
                    exit();
                }

                $this->cart->clear();

                echo json_encode([
                    'success' => true,
                    'message' => 'Payment successful! Your order will arrive at your address in the near future.'
                ]);
                exit();

            } catch (PDOException $e) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Database error. Please try again later.'
                ]);
                exit();
            }
        }
    }
}