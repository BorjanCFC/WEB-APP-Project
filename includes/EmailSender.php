<?php
require_once 'C:/xampp/htdocs/OnlineStore/PHPMailer/src/Exception.php';
require_once 'C:/xampp/htdocs/OnlineStore/PHPMailer/src/PHPMailer.php';
require_once 'C:/xampp/htdocs/OnlineStore/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EmailSender {
    private $mail;

    public function __construct() {
        $this->mail = new PHPMailer(true);

        // Use SMTP
        $this->mail->isSMTP();
        $this->mail->Host       = 'smtp.gmail.com'; 
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = 'borjanpetrevski03@gmail.com';
        $this->mail->Password   = 'kjckjmjgithowqkc'; 
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = 587;

        $this->mail->CharSet = 'UTF-8';
        $this->mail->setFrom('borjanpetrevski03@gmail.com', 'FashionForward');
        $this->mail->isHTML(true);
    }

    public function sendWelcomeEmail($toEmail, $firstName, $userId) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($toEmail, $firstName);

            $this->mail->Subject = 'Welcome to FashionForward!';
            $this->mail->Body    = $this->getWelcomeTemplate($firstName);
            $this->mail->AltBody = 'Welcome to FashionForward, ' . $firstName . '! Your account has been created successfully.';

            if ($this->mail->send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            error_log("Email sending failed: " . $this->mail->ErrorInfo);
            return false;
        }
    }

    public function getWelcomeTemplate($firstName) {
        $appUrl = defined('APP_URL') ? APP_URL : 'http://localhost/OnlineStore';
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Welcome to FashionForward</title>
            <style>
                :root {
                    --primary: #2c3e50;
                    --secondary: #e74c3c;
                    --accent: #3498db;
                    --light: #ecf0f1;
                    --dark: #2c3e50;
                    --text: #333;
                    --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    --transition: all 0.3s ease;
                }

                body { 
                    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
                    background-color: var(--light); 
                    margin: 0; 
                    padding: 20px; 
                    color: var(--text);
                }

                .container { 
                    max-width: 600px; 
                    margin: 0 auto; 
                    background: white; 
                    padding: 40px; 
                    border-radius: 10px; 
                    box-shadow: var(--shadow); 
                }

                .header { 
                    text-align: center; 
                    margin-bottom: 30px; 
                }

                .header h1 { 
                    color: var(--primary); 
                    margin: 0; 
                    font-size: 32px; /* slightly bigger */
                }

                .content { 
                    color: var(--text); 
                    line-height: 1.6; 
                    margin-bottom: 20px; 
                }

                .btn { 
                    display: inline-block; 
                    background-color: var(--secondary); 
                    color: var(--light); 
                    padding: 15px 35px; /* slightly bigger padding */
                    text-decoration: none; 
                    border-radius: 5px; 
                    font-weight: 500; 
                    font-size: 18px; /* bigger font */
                    margin: 20px 0; 
                    transition: var(--transition);
                }

                .btn:hover { 
                    background-color: var(--accent); 
                    color: var(--primary); 
                }

                .footer { 
                    text-align: center; 
                    color: var(--text); 
                    font-size: 12px; 
                    margin-top: 30px; 
                    padding-top: 20px; 
                    border-top: 1px solid var(--light); 
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Welcome to FashionForward!</h1>
                </div>
                <div class='content'>
                    <p>Hi <strong>{$firstName}</strong>,</p>
                    <p>Thank you for joining FashionForward! Your account has been created successfully.</p>
                    
                    <p>Start exploring our latest fashion collections and enjoy a personalized shopping experience.</p>
                    
                    <a href='{$appUrl}' class='btn'>Start Shopping Now</a>
                    
                    <p style='margin-top: 25px;'>
                        If you have any questions or need assistance, feel free to contact our support team.
                    </p>
                </div>
                <div class='footer'>
                    <p>Best regards,<br>
                    <strong>The FashionForward Team</strong></p>
                    <p>© 2025 FashionForward. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>";
    }

    public function testEmail($toEmail, $testName = 'Test User') {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($toEmail, $testName);
            
            $this->mail->Subject = 'Test Email from FashionForward';
            $this->mail->Body    = "<h2>Test Email Configuration</h2><p>If you received this email, your email setup is working!</p>";
            $this->mail->AltBody = 'Test email configuration successful!';
            
            if ($this->mail->send()) {
                return true;
            } else {
                echo "Mailer failed: " . $this->mail->ErrorInfo;
                return false;
            }
        } catch (Exception $e) {
            echo "Mailer Exception: " . $this->mail->ErrorInfo;
            return false;
        }
    }

    public function sendVerificationCodeEmail($toEmail, $firstName, $code) {
        try {
            $this->mail->clearAddresses();
            $this->mail->addAddress($toEmail, $firstName);

            $this->mail->Subject = 'Your Password Reset Verification Code';
            
            $this->mail->Body = $this->getVerificationCodeTemplate($firstName, $code);
            $this->mail->AltBody = "Hi $firstName, your verification code is: $code";

            if ($this->mail->send()) {
                return true;
            } else {
                error_log("Failed to send verification code: " . $this->mail->ErrorInfo);
                return false;
            }

        } catch (Exception $e) {
            error_log("Exception sending verification code: " . $this->mail->ErrorInfo);
            return false;
        }
    }

    public function getVerificationCodeTemplate($firstName, $code) {
        $appUrl = defined('APP_URL') ? APP_URL : 'http://localhost/OnlineStore';
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Password Reset Code</title>
            <style>
                body { 
                    font-family: Arial, sans-serif; 
                    background-color: #f5f5f5; 
                    padding: 20px; 
                }
                .container { 
                    max-width: 600px; 
                    margin: 0 auto; 
                    background: #fff; 
                    padding: 30px; 
                    border-radius: 10px; 
                }
                .header { 
                    text-align: center; 
                    margin-bottom: 20px; 
                }
                .header h1 { 
                    color: #2c3e50; 
                }
                .code { 
                    font-size: 28px; 
                    font-weight: bold; 
                    color: #e74c3c; 
                    text-align: center; 
                    margin: 20px 0; 
                }
                .btn { 
                    display: inline-block; 
                    padding: 15px 30px; 
                    background-color: #3498db; 
                    color: #fff; 
                    text-decoration: none; 
                    border-radius: 5px; 
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Password Reset Code</h1>
                </div>
                <p>Hi <strong>$firstName</strong>,</p>
                <p>We received a request to reset your password. Use the verification code below to proceed:</p>
                <div class='code'>$code</div>
                <p>If you did not request a password reset, please ignore this email.</p>
            </div>
        </body>
        </html>";
    }
}