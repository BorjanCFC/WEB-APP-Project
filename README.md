# 🛒 OnlineStore

**OnlineStore** is a simple PHP-based e-commerce application built using the MVC (Model-View-Controller) architecture.  
It provides basic functionality for browsing products, managing a shopping cart, handling authentication, and managing sales.  

---

## 📂 Project Structure

ONLINESTORE/
├── app/                     # Core application folder, MVC logic
│   ├── controllers/         # Controllers handle user requests
│   │   ├── AboutUsController.php
│   │   ├── AuthController.php
│   │   ├── CartController.php
│   │   ├── HomeController.php
│   │   ├── ProductController.php
│   │   └── SaleController.php
│   │
│   ├── core/                # Framework base ("engine" of the system)
│   │   ├── App.php
│   │   ├── Controller.php
│   │   ├── Database.php
│   │   └── Model.php
│   │
│   ├── models/              # Models interact with the database
│   │   ├── Cart.php
│   │   ├── HomeModel.php
│   │   └── Product.php
│   │
│   └── views/               # Presentation layer (HTML + PHP templates)
│       ├── auth/
│       │   ├── forgot_password.php
│       │   ├── login.php
│       │   ├── profile.php
│       │   ├── register.php
│       │   ├── resetPassword.php
│       │   └── verifyCode.php
│       │
│       ├── layouts/
│       │   ├── footer.php
│       │   └── header.php
│       │
│       ├── AboutUs.php
│       ├── Cart.php
│       ├── Category.php
│       ├── Home.php
│       └── Sale.php
│
├── config/                  # Configuration files
│   ├── config.php
│   └── Database.php
│
├── includes/                # Helper classes/utilities
│   ├── EmailRender.php
│   └── PHPMailer/
│
├── public/                  # Public web root (accessible to browser)
│   ├── css/
│   │   └── style.css
│   ├── images/
│   ├── js/
│   │   └── main.js
│   ├── index.php
│   └── .htaccess            # Apache rewrite rules
│
└── README.md                # Project documentation


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
   git clone https://github.com/your-username/OnlineStore.git
   cd OnlineStore
