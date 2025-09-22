<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Elevate Your Style</h1>
        <p>Discover the latest trends in fashion with our exclusive collection of shoes and clothing for every occasion.</p>
        <a href="<?php echo APP_URL; ?>/Sale" class="btn">Shop Now</a>
    </div>
</section>

<!-- Categories Section -->
<section class="categories">
    <div class="section-title">
        <h2>Shop By Category</h2>
    </div>

    <div class="category-grid">
        <div class="category-card" id="cat_card">
            <img src="https://www.beyours.in/cdn/shop/files/hoodie-sweatshirt-banner.jpg?v=1695638330&width=3000" alt="Men's Collection">
            <div class="category-content">
                <h3>Men's Collection</h3>
                <a href="<?php echo APP_URL; ?>/men" class="btn">Explore</a>
            </div>
        </div>

        <div class="category-card" id="cat_card">
            <img src="https://images.hdqwalls.com/wallpapers/girl-portrait-casual-clothing-la.jpg" alt="Women's Collection">
            <div class="category-content">
                <h3>Women's Collection</h3>
                <a href="<?php echo APP_URL; ?>/women" class="btn">Explore</a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="featured">
    <div class="section-title">
        <h2>Featured Products</h2>
    </div>

    <div class="products-grid">
            <?php if (empty($products)): ?>
                <div class="no-products">
                    <p>No products found in this category.</p>
                    <a href="<?php echo APP_URL; ?>" class="btn">Continue Shopping</a>
                </div>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="product-img">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name'] ?? 'Product'); ?>">
                            <?php if (!empty($product['tag'])): ?>
                                <span class="product-tag"><?php echo htmlspecialchars($product['tag']); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-info">
                            <h3><?php echo htmlspecialchars($product['name'] ?? 'Product'); ?></h3>
                            <p><strong>Brand:</strong> <?php echo htmlspecialchars($product['brand']); ?></p>
                            <p><strong>Type:</strong> <?php echo htmlspecialchars($product['type']); ?></p>
                            
                            <?php if (!empty($product['size'])): ?>
                                <p><strong>Size:</strong> <?php echo htmlspecialchars($product['size']); ?></p>
                            <?php endif; ?>

                            <div class="product-rating">
                                <div class="stars">
                                    <?php
                                        $rating = $product['reviews'] ?? 0;
                                        $fullStars = floor($rating);
                                        $halfStar = ($rating - $fullStars) >= 0.5;
                                        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

                                        for ($i = 0; $i < $fullStars; $i++): ?>
                                            <i class="fas fa-star"></i>
                                        <?php endfor; ?>

                                        <?php if ($halfStar): ?>
                                            <i class="fas fa-star-half-alt"></i>
                                        <?php endif; ?>

                                        <?php for ($i = 0; $i < $emptyStars; $i++): ?>
                                            <i class="far fa-star"></i>
                                        <?php endfor; ?>
                                </div>
                                <span class="rating-count">(<?php echo $product['reviews'] ?? '0'; ?>)</span>
                            </div>

                            <div class="product-price">
                                <div class="price-container">
                                    <span class="price">$<?php echo number_format($product['price'] ?? 0, 2); ?></span>
                                    <?php if (!empty($product['old_price']) && $product['old_price'] > 0): ?>
                                        <span class="old-price">$<?php echo number_format($product['old_price'], 2); ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="product-actions">
                                    <button 
                                        class="add-to-cart" 
                                        title="Add to Cart"
                                        data-id="<?php echo $product['id']; ?>"
                                        data-name="<?php echo htmlspecialchars($product['name'] ?? 'Product'); ?>"
                                        data-price="<?php echo $product['price'] ?? 0; ?>"
                                        data-image="<?php echo htmlspecialchars($product['image']); ?>"
                                    >
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <?php if (!empty($product['discount'])): ?>
                                <p class="discount"><?php echo htmlspecialchars($product['discount']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

</section>

