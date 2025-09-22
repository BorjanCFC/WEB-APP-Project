<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="<?php echo APP_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header & Navigation -->
    <header>
        <div class="nav-container">
            <a href="<?php echo APP_URL; ?>" class="logo">
                <i class="fas fa-tshirt"></i>
                Fashion<span>Forward</span>
            </a>

            <ul class="nav-links">
                <li><a href="<?php echo APP_URL; ?>">Home</a></li>
                <li><a href="<?php echo APP_URL; ?>/men">Men</a></li>
                <li><a href="<?php echo APP_URL; ?>/women">Women</a></li>
                <li><a href="<?php echo APP_URL; ?>/sale">Sale</a></li>
                <li><a href="<?php echo APP_URL; ?>/AboutUs">About Us</a></li>
            </ul>
        
            <div class="nav-icons">
                <a href="<?php echo APP_URL; ?>/auth/login">
                    <i class="fas fa-user"></i>
                </a>

                <?php
                $cartCount = 0;
                if (isset($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $item) {
                        $cartCount += $item['quantity'];
                    }
                }
                ?>
                <a href="<?php echo APP_URL; ?>/cart" id="cart-link">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="icon-badge" id="cart-count"><?php echo $cartCount; ?></span>
                </a>

            </div>
        </div>
    </header>