<?php
require_once 'C:/xampp/htdocs/OnlineStore/config/Database.php';

class AuthController extends Controller {
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login() {
        if (isset($_SESSION['user'])) {
            header('Location: ' . APP_URL . '/auth/profile');
            exit();
        }

        $data = [
            'title' => 'Login | FashionForward',
            'error' => $_SESSION['error'] ?? null
        ];
        
        unset($_SESSION['error']);
        
        $this->view('auth/login', $data);
    }
    
    public function register() {
        if (isset($_SESSION['user'])) {
            header('Location: ' . APP_URL . '/auth/profile');
            exit();
        }

        $data = [
            'title' => 'Register | FashionForward',
            'error' => $_SESSION['error'] ?? null
        ];
        
        unset($_SESSION['error']);
        
        $this->view('auth/register', $data);
    }
    
    public function profile() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . APP_URL . '/auth/login');
            exit();
        }
        
        $data = [
            'title' => 'My Profile | FashionForward',
            'user' => $_SESSION['user']
        ];
        
        $this->view('auth/profile', $data);
    }
    
    public function doLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['error'] = "Email and password are required.";
                header('Location: ' . APP_URL . '/auth/login');
                exit();
            }

            try {
                $database = new Database();
                $db = $database->getConnection();

                $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && $password === $user['password']) {
                    $_SESSION['user'] = [
                        'user_id' => $user['user_id'],
                        'first_name' => $user['first_name'],
                        'last_name' => $user['last_name'],
                        'email' => $user['email'],
                        'phone' => $user['phone'],
                        'address' => $user['address'],
                        'city' => $user['city']
                    ];

                    unset($_SESSION['error']); 
                    header('Location: ' . APP_URL . '/auth/profile');
                    exit();
                } else {
                    $_SESSION['error'] = "<span style='color:red;'>Incorrect password or email.</span>";
                    header('Location: ' . APP_URL . '/auth/login');
                    exit();
                }
            } catch (PDOException $e) {
                $_SESSION['error'] = "<span style='color:red;'>Database error. Please try again later.</span>";
                header('Location: ' . APP_URL . '/auth/login');
                exit();
            }
        } else {
            header('Location: ' . APP_URL . '/auth/login');
            exit();
        }
    }

    public function doRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $city = trim($_POST['city'] ?? '');
            $cardNumber = trim($_POST['card_number'] ?? '');
            $expiryDate = trim($_POST['expiry_date'] ?? '');
            $cvv = trim($_POST['cvv'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
                $_SESSION['error'] = "All required fields must be filled.";
                header('Location: ' . APP_URL . '/auth/register');
                exit();
            }

            if ($password !== $confirmPassword) {
                $_SESSION['error'] = "Passwords do not match.";
                header('Location: ' . APP_URL . '/auth/register');
                exit();
            }

            if (strlen($password) < 6) {
                $_SESSION['error'] = "Password must be at least 6 characters long.";
                header('Location: ' . APP_URL . '/auth/register');
                exit();
            }

            try {
                $database = new Database();
                $db = $database->getConnection();

                $checkQuery = "SELECT user_id FROM users WHERE email = :email LIMIT 1";
                $checkStmt = $db->prepare($checkQuery);
                $checkStmt->bindParam(':email', $email);
                $checkStmt->execute();
                
                if ($checkStmt->rowCount() > 0) {
                    $_SESSION['error'] = "Email already registered. Please use a different email.";
                    header('Location: ' . APP_URL . '/auth/register');
                    exit();
                }

                $query = "INSERT INTO users 
                    (first_name, last_name, email, phone, address, city, card_number, expiry_date, cvv, password) 
                    VALUES 
                    (:first_name, :last_name, :email, :phone, :address, :city, :card_number, :expiry_date, :cvv, :password)";

                $stmt = $db->prepare($query);
                $stmt->bindParam(':first_name', $firstName);
                $stmt->bindParam(':last_name', $lastName);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->bindParam(':city', $city);
                $stmt->bindParam(':card_number', $cardNumber);
                $stmt->bindParam(':expiry_date', $expiryDate);
                $stmt->bindParam(':cvv', $cvv);
                $stmt->bindParam(':password', $password);

                if ($stmt->execute()) {
                    $newUserId = $db->lastInsertId();

                    $_SESSION['user'] = [
                        'user_id' => $newUserId,
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'email' => $email,
                        'phone' => $phone,
                        'address' => $address,
                        'city' => $city
                    ];

                    require_once 'C:/xampp/htdocs/OnlineStore/includes/EmailSender.php';
                    $emailSender = new EmailSender();
                    
                    $emailSent = $emailSender->sendWelcomeEmail($email, $firstName, $newUserId);

                    unset($_SESSION['error']);
                    header('Location: ' . APP_URL . '/auth/profile');
                    exit();
                } else {
                    $_SESSION['error'] = "Error: Could not register user. Please try again.";
                    header('Location: ' . APP_URL . '/auth/register');
                    exit();
                }
            } catch (PDOException $e) {
                $_SESSION['error'] = "Database error. Please try again later.";
                header('Location: ' . APP_URL . '/auth/register');
                exit();
            }
        }
    }

    public function updateProfile() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . APP_URL . '/auth/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'] ?? 0;
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $city = trim($_POST['city'] ?? '');
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (empty($firstName) || empty($lastName) || empty($email) || empty($address) || empty($city)) {
                $data = [
                    'title' => 'My Profile | FashionForward',
                    'user' => $_SESSION['user'],
                    'message' => 'All required fields must be filled.'
                ];
                $this->view('auth/profile', $data);
                return;
            }

            try {
                $database = new Database();
                $db = $database->getConnection();

                $userQuery = "SELECT * FROM users WHERE user_id = :user_id LIMIT 1";
                $userStmt = $db->prepare($userQuery);
                $userStmt->bindParam(':user_id', $userId);
                $userStmt->execute();
                $currentUser = $userStmt->fetch(PDO::FETCH_ASSOC);

                if (!$currentUser || $currentUser['user_id'] != $_SESSION['user']['user_id']) {
                    $data = [
                        'title' => 'My Profile | FashionForward',
                        'user' => $_SESSION['user'],
                        'message' => 'Unauthorized access.'
                    ];
                    $this->view('auth/profile', $data);
                    return;
                }

                if ($email !== $currentUser['email']) {
                    $emailCheckQuery = "SELECT user_id FROM users WHERE email = :email AND user_id != :user_id LIMIT 1";
                    $emailCheckStmt = $db->prepare($emailCheckQuery);
                    $emailCheckStmt->bindParam(':email', $email);
                    $emailCheckStmt->bindParam(':user_id', $userId);
                    $emailCheckStmt->execute();
                    
                    if ($emailCheckStmt->rowCount() > 0) {
                        $data = [
                            'title' => 'My Profile | FashionForward',
                            'user' => $_SESSION['user'],
                            'message' => 'Email address is already taken by another user.'
                        ];
                        $this->view('auth/profile', $data);
                        return;
                    }
                }

                $updatePassword = false;
                if (!empty($newPassword)) {
                    if ($currentPassword !== $currentUser['password']) {
                        $data = [
                            'title' => 'My Profile | FashionForward',
                            'user' => $_SESSION['user'],
                            'message' => 'Current password is incorrect.'
                        ];
                        $this->view('auth/profile', $data);
                        return;
                    }

                    if ($newPassword !== $confirmPassword) {
                        $data = [
                            'title' => 'My Profile | FashionForward',
                            'user' => $_SESSION['user'],
                            'message' => 'New passwords do not match.'
                        ];
                        $this->view('auth/profile', $data);
                        return;
                    }

                    if (strlen($newPassword) < 6) {
                        $data = [
                            'title' => 'My Profile | FashionForward',
                            'user' => $_SESSION['user'],
                            'message' => 'New password must be at least 6 characters long.'
                        ];
                        $this->view('auth/profile', $data);
                        return;
                    }

                    $updatePassword = true;
                }

                $sql = "UPDATE users SET 
                        first_name = :first_name, 
                        last_name = :last_name, 
                        email = :email, 
                        phone = :phone, 
                        address = :address, 
                        city = :city";
                
                $params = [
                    ':first_name' => $firstName,
                    ':last_name' => $lastName,
                    ':email' => $email,
                    ':phone' => $phone,
                    ':address' => $address,
                    ':city' => $city
                ];

                if ($updatePassword) {
                    $sql .= ", password = :password";
                    $params[':password'] = $newPassword;
                }

                $sql .= " WHERE user_id = :user_id";
                $params[':user_id'] = $userId;

                $stmt = $db->prepare($sql);
                $stmt->execute($params);

                $_SESSION['user'] = [
                    'user_id' => $userId,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $email,
                    'phone' => $phone,
                    'address' => $address,
                    'city' => $city
                ];

                $data = [
                    'title' => 'My Profile | FashionForward',
                    'user' => $_SESSION['user'],
                    'message' => 'Profile updated successfully!'
                ];
                
                $this->view('auth/profile', $data);

            } catch (PDOException $e) {
                $data = [
                    'title' => 'My Profile | FashionForward',
                    'user' => $_SESSION['user'],
                    'message' => 'Database error. Please try again later.'
                ];
                $this->view('auth/profile', $data);
            }
        } else {
            header('Location: ' . APP_URL . '/auth/profile');
            exit();
        }
    }
    
    public function logout() {
        session_destroy();
        header('Location: ' . APP_URL);
        exit();
    }

    public function forgetpassword() {  
        $data = [
            'title' => 'Forgot Password | FashionForward',
            'error' => $_SESSION['error'] ?? null
        ];
        unset($_SESSION['error']);
        $this->view('auth/forgotpassword', $data);
    }

    public function sendVerificationCode() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');

            if (empty($email)) {
                $_SESSION['error'] = "Email is required.";
                header('Location: ' . APP_URL . '/auth/forgotPassword');
                exit();
            }

            try {
                $database = new Database();
                $db = $database->getConnection();

                $stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    $code = rand(100000, 999999);

                    $_SESSION['password_reset_code'] = $code;
                    $_SESSION['password_reset_email'] = $email;

                    require_once 'C:/xampp/htdocs/OnlineStore/includes/EmailSender.php';
                    $emailSender = new EmailSender();
                    $emailSender->sendVerificationCodeEmail($email, $user['first_name'], $code);

                    header('Location: ' . APP_URL . '/auth/verifyCode?email=' . urlencode($email));
                    exit();
                } else {
                    $_SESSION['error'] = "Email not found in our records.";
                    header('Location: ' . APP_URL . '/auth/forgotPassword');
                    exit();
                }

            } catch (PDOException $e) {
                $_SESSION['error'] = "Database error. Try again later.";
                header('Location: ' . APP_URL . '/auth/forgotPassword');
                exit();
            }
        }
    }

    public function verifyCode() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $code = $_POST['code'] ?? '';

            if ($email === ($_SESSION['password_reset_email'] ?? '') &&
                $code === strval($_SESSION['password_reset_code'] ?? '')) {
                
                header('Location: ' . APP_URL . '/auth/resetPassword?email=' . urlencode($email));
                exit();
            } else {
                $_SESSION['error'] = "Incorrect verification code.";
                header('Location: ' . APP_URL . '/auth/verifyCode?email=' . urlencode($email));
                exit();
            }
        } else {
            $data = [
                'title' => 'Verify Code | FashionForward',
                'email' => $_GET['email'] ?? '',
                'error' => $_SESSION['error'] ?? null
            ];

            unset($_SESSION['error']);
            $this->view('auth/verifyCode', $data);
        }
    }

    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if ($newPassword !== $confirmPassword) {
                $_SESSION['error'] = "Passwords do not match.";
                header('Location: ' . APP_URL . '/auth/resetPassword?email=' . urlencode($email));
                exit();
            }

            if (strlen($newPassword) < 6) {
                $_SESSION['error'] = "Password must be at least 6 characters.";
                header('Location: ' . APP_URL . '/auth/resetPassword?email=' . urlencode($email));
                exit();
            }

            try {
                $database = new Database();
                $db = $database->getConnection();

                $stmt = $db->prepare("UPDATE users SET password = :password WHERE email = :email");
                $stmt->bindParam(':password', $newPassword); // plain text for testing
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                unset($_SESSION['password_reset_email'], $_SESSION['password_reset_code']);

                $_SESSION['success'] = "Password updated successfully! Please login.";
                header('Location: ' . APP_URL . '/auth/login');
                exit();
            } catch (PDOException $e) {
                $_SESSION['error'] = "Database error. Try again later.";
                header('Location: ' . APP_URL . '/auth/resetPassword?email=' . urlencode($email));
                exit();
            }
        } else {
            $email = $_GET['email'] ?? '';
            $data = [
                'title' => 'Reset Password | FashionForward',
                'email' => $email,
                'error' => $_SESSION['error'] ?? null
            ];
            unset($_SESSION['error']);
            $this->view('auth/resetPassword', $data);
        }
    }
}