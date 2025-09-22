# 🛒 OnlineStore

**OnlineStore** is a simple PHP-based e-commerce application built using the MVC (Model-View-Controller) architecture.  
It provides basic functionality for browsing products, managing a shopping cart, handling authentication, and managing sales.  

---

## 📂 Project Structure

ONLINESTORE/
├── app/                          # Core application folder, MVC logic
│   ├── controllers/              # Controllers handle user requests
│   │   ├── AboutUsController.php
│   │   ├── AuthController.php
│   │   ├── CartController.php
│   │   ├── HomeController.php
│   │   ├── ProductController.php
│   │   └── SaleController.php
│   │
│   ├── core/                     # Framework base ("engine" of the system)
│   │   ├── App.php
│   │   ├── Controller.php
│   │   ├── Database.php
│   │   └── Model.php
│   │
│   ├── models/                   # Models interact with the database
│   │   ├── Cart.php
│   │   ├── HomeModel.php
│   │   └── Product.php
│   │
│   └── views/                    # Presentation layer (HTML + PHP templates)
│       ├── auth/                 # Authentication views
│       │   ├── forgot_password.php
│       │   ├── login.php
│       │   ├── profile.php
│       │   ├── register.php
│       │   ├── resetPassword.php
│       │   └── verifyCode.php
│       │
│       ├── layouts/              # Reusable layout components
│       │   ├── footer.php
│       │   └── header.php
│       │
│       ├── AboutUs.php           # About Us page
│       ├── Cart.php              # Shopping cart page
│       ├── Category.php          # Product category pages
│       ├── Home.php              # Homepage
│       └── Sale.php              # Sale page
│
├── config/                       # Configuration files
│   ├── config.php                # Application configuration
│   └── Database.php              # Database configuration
│
├── includes/                     # Helper classes/utilities
│   ├── EmailSender.php           # Email sending functionality
│   └── PHPMailer/                # PHPMailer library for SMTP
│
├── public/                       # Public web root (browser accessible)
│   ├── css/                      # Stylesheets
│   │   └── style.css
│   ├── images/                   # Static images
│   ├── js/                       # JavaScript files
│   │   └── main.js
│   ├── index.php                 # Front controller
│   └── .htaccess                 # Apache rewrite rules for clean URLs
│
└── README.md                     # Project documentation

---

## 🚀 Features

- **Home Page** – Browse featured products and categories.
- **Product Management** – View product details.
- **Shopping Cart** – Add, remove, and update product quantities.
- **Sales Page** – Display discounted products.
- **Authentication** – Login, Register, Forgot Password, Reset Password.
- **User Profile** – Manage account details.
- **About Us** – Informational page about the store.
- **Email Integration** – Password reset and verification via PHPMailer.

---

## 🛠️ Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/BorjanCFC/WEB-APP-Project.git
