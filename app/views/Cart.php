<?php require_once 'C:/xampp/htdocs/OnlineStore/app/views/layouts/header.php'; ?>

<div class="container" id="cart-container">
    
    <?php if (empty($data['cartItems'])): ?>
        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <h2>Your cart is empty</h2>
            <p>Looks like you haven't added any items to your cart yet.</p>
            <a href="<?php echo APP_URL; ?>/sale" class="btn btn-primary">Continue Shopping</a>
        </div>
    <?php else: ?>
        <div class="cart-container">
            <div class="cart-items">
                <?php foreach ($data['cartItems'] as $item): ?>
                    <div class="cart-item" data-id="<?php echo $item['id']; ?>">
                        <div class="item-image">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                 alt="<?php echo htmlspecialchars($item['name'] ?? 'Product');?> class="small_pic">
                        </div>
                        <div class="item-details">
                            <h3><?php echo $item['name']; ?></h3>
                            <p class="item-price">$<?php echo number_format($item['price'], 2); ?></p>
                        </div>
                        <div class="item-quantity">
                            <button type="button" class="quantity-btn minus" data-id="<?php echo $item['id']; ?>">-</button>
                            <input type="number" value="<?php echo $item['quantity']; ?>" min="1" class="quantity-input" data-id="<?php echo $item['id']; ?>">
                            <button type="button" class="quantity-btn plus" data-id="<?php echo $item['id']; ?>">+</button>
                        </div>

                        <div class="item-total">
                            $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                        </div>
                        <div class="item-remove">
                            <button class="remove-btn" data-id="<?php echo $item['id']; ?>">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="cart-summary">
                <h2>Order Summary</h2>
                <div class="summary-line total">
                    <span>Total:</span>
                    <span id="total">$<?php echo number_format($data['total'], 2); ?></span>
                </div>

                <!-- Buttons wrapper -->
                <div class="cart-buttons">
                    <button id="checkout-btn" class="btn btn-primary">Proceed to Checkout</button>
                    <a href="<?php echo APP_URL; ?>/sale" class="btn btn-secondary" id="cont_button">Continue Shopping</a>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<div id="checkout-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Checkout</h2>
            <span class="close">&times;</span>
        </div>
        <div class="modal-body">
            <form id="checkout-form" action="<?php echo APP_URL; ?>/cart/checkout" method="POST">
                <div class="form-group">
                    <label for="card-number">Card Number</label>
                    <input type="text" id="card-number" name="card_number" placeholder="XXXX XXXX XXXX XXXX" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="expiry">Expiry Date</label>
                        <input type="text" id="expiry" name="expiry_date" placeholder="MM/YY" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" name="cvv" placeholder="XXX" required>
                    </div>
                </div>
                <div class="pay-now-container">
                    <button type="submit" class="btn btn-primary">Pay Now</button>
                    <button type="button" class="btn btn-secondary" id="close-checkout">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="result-modal" class="modal">
    <div class="modal-content result-modal-content">
        <div class="modal-header">
            <h2>Payment Status</h2>
            <span class="close" id="close-result">&times;</span>
        </div>
        <div class="modal-body">
            <p id="result-message"></p>
        </div>
    </div>
</div>




<?php require_once 'C:/xampp/htdocs/OnlineStore/app/views/layouts/footer.php'; ?>