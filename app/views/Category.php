<?php require_once 'C:/xampp/htdocs/OnlineStore/app/views/layouts/header.php'; ?>

<?php 
$bannerImage = '';
if (strtolower($category) === 'men') {
    $bannerImage = 'https://hgthrash.com/wp-content/uploads/2020/11/mens-clothes-suits-lubbock.jpg';
} elseif (strtolower($category) === 'women') {
    $bannerImage = 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1800&q=80';
}
?>

<!-- Category Banner -->
<section class="category-banner" 
    style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
           url('<?php echo $bannerImage; ?>'); 
           background-size: cover; 
           background-position: center;">
    <div class="banner-content">
        <h1><?php echo htmlspecialchars(ucfirst($category)); ?>'s Collection</h1>
        <p>Discover our latest <?php echo strtolower(htmlspecialchars($category)); ?> fashion trends</p>
    </div>
</section>

<!-- Filter & Sort Section -->
<section class="filter-section">
    <div class="container">
        <div class="filter-container">

            <!-- Product Type Filter -->
            <div class="filter-group">
                <h3>Product Type</h3>
                <div class="filter-options">
                    <?php
                    $currentFilter = $_GET['filter'] ?? 'all';
                    $filterOptions = [
                        'all'       => 'All Products',
                        'shirt'     => 'Shirts',
                        'hoodie'    => 'Hoodies',
                        'shoes'     => 'Shoes',
                        'shorts'    => 'Shorts',
                        'jeans'     => 'Jeans',
                        'accessory' => 'Accessories',
                        'jacket'    => 'Jackets'
                    ];
                    
                    foreach ($filterOptions as $value => $label): 
                        $isActive = ($currentFilter === $value) ? 'active' : '';
                    ?>
                        <button 
                            class="filter-btn <?php echo $isActive; ?>" 
                            data-filter="<?php echo $value; ?>">
                            <?php echo $label; ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Sort Options -->
            <div class="filter-group">
                <h3>Sort By</h3>
                <div class="filter-options">
                    <?php
                    $currentSort = $_GET['sort'] ?? 'default';
                    $sortOptions = [
                        'default'    => 'Default',
                        'price-low'  => 'Price: Low to High',
                        'price-high' => 'Price: High to Low',
                        'name-asc'   => 'Name: A to Z',
                        'name-desc'  => 'Name: Z to A',
                        'rating'     => 'Highest Rated'
                    ];
                    ?>
                    <select class="sort-select" id="sortOptions">
                        <?php foreach ($sortOptions as $value => $label): 
                            $isSelected = ($currentSort === $value) ? 'selected' : '';
                        ?>
                            <option value="<?php echo $value; ?>" <?php echo $isSelected; ?>>
                                <?php echo $label; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Active Filters Display -->
            <div class="active-filters">
                <span class="filter-label">Active Filters:</span>
                <div class="active-filter-tags" id="activeFilterTags">
                    <span class="filter-tag">All Products</span>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END FILTER AND SORT SECTION -->

<!-- Products Grid -->
<section class="products-section">
    <div class="container">
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
                                <span class="product-tag">
                                    <?php echo htmlspecialchars($product['tag']); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="product-info">
                            <h3><?php echo htmlspecialchars($product['name'] ?? 'Product'); ?></h3>
                            <p><strong>Brand:</strong> <?php echo htmlspecialchars($product['brand']); ?></p>
                            <p><strong>Type:</strong> <?php echo htmlspecialchars($product['type']); ?></p>
                            
                            <?php if (!empty($product['size'])): ?>
                                <p><strong>Size:</strong> <?php echo htmlspecialchars($product['size']); ?></p>
                            <?php endif; ?>

                            <!-- Product Rating -->
                            <div class="product-rating">
                                <div class="stars">
                                    <?php
                                    $rating     = $product['reviews'] ?? 0;
                                    $fullStars  = floor($rating);
                                    $halfStar   = ($rating - $fullStars) >= 0.5;
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
                                <span class="rating-count">
                                    (<?php echo $product['reviews'] ?? '0'; ?>)
                                </span>
                            </div>

                            <!-- Product Price -->
                            <div class="product-price">
                                <div class="price-container">
                                    <span class="price">
                                        $<?php echo number_format($product['price'] ?? 0, 2); ?>
                                    </span>

                                    <?php if (!empty($product['old_price']) && $product['old_price'] > 0): ?>
                                        <span class="old-price">
                                            $<?php echo number_format($product['old_price'], 2); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- Add to Cart -->
                                <div class="product-actions">
                                    <button 
                                        class="add-to-cart" 
                                        title="Add to Cart"
                                        data-id="<?php echo $product['id']; ?>"
                                        data-name="<?php echo htmlspecialchars($product['name'] ?? 'Product'); ?>"
                                        data-price="<?php echo $product['price'] ?? 0; ?>"
                                        data-image="<?php echo htmlspecialchars($product['image']); ?>">
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

        <!-- PAGINATION SECTION -->
        <?php if (isset($totalPages) && $totalPages > 1): ?>
            <div class="pagination">
                <?php 
                $currentPage  = $currentPage ?? 1;
                $currentFilter = $_GET['filter'] ?? 'all';
                $currentSort   = $_GET['sort'] ?? 'default';
                ?>

                <?php if ($currentPage > 1): ?>
                    <a href="?page=1&filter=<?php echo urlencode($currentFilter); ?>&sort=<?php echo urlencode($currentSort); ?>" class="pagination-link first">First</a>
                    <a href="?page=<?php echo $currentPage - 1; ?>&filter=<?php echo urlencode($currentFilter); ?>&sort=<?php echo urlencode($currentSort); ?>" class="pagination-link prev">Previous</a>
                <?php endif; ?>
                
                <?php 
                // Show page numbers (max 5 pages at a time)
                $startPage = max(1, $currentPage - 2);
                $endPage   = min($totalPages, $startPage + 4);
                $startPage = max(1, $endPage - 4);
                
                for ($i = $startPage; $i <= $endPage; $i++): 
                ?>
                    <a href="?page=<?php echo $i; ?>&filter=<?php echo urlencode($currentFilter); ?>&sort=<?php echo urlencode($currentSort); ?>" 
                       class="pagination-link <?php echo $i == $currentPage ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <a href="?page=<?php echo $currentPage + 1; ?>&filter=<?php echo urlencode($currentFilter); ?>&sort=<?php echo urlencode($currentSort); ?>" class="pagination-link next">Next</a>
                    <a href="?page=<?php echo $totalPages; ?>&filter=<?php echo urlencode($currentFilter); ?>&sort=<?php echo urlencode($currentSort); ?>" class="pagination-link last">Last</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <!-- END PAGINATION SECTION -->
    </div>
</section>

<?php require_once 'C:/xampp/htdocs/OnlineStore/app/views/layouts/footer.php'; ?>
