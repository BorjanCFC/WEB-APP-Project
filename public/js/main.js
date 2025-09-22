console.log("Script loaded")
document.addEventListener('DOMContentLoaded', function() {
    // ========================
    // Profile nav switching
    // ========================
    const navItems = document.querySelectorAll('.profile-nav-item');
    const sections = document.querySelectorAll('.profile-section-content');
    const sectionTitle = document.getElementById('section-title');

    if (navItems.length && sections.length && sectionTitle) {
        navItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();

                navItems.forEach(nav => nav.classList.remove('active'));
                sections.forEach(section => section.classList.add('hidden'));

                this.classList.add('active');
                const target = this.textContent.trim().toLowerCase();

                if (target.includes('personal')) {
                    document.getElementById('personal-info-section')?.classList.remove('hidden');
                    sectionTitle.textContent = 'Personal Information';
                } else if (target.includes('orders')) {
                    document.getElementById('orders-section')?.classList.remove('hidden');
                    sectionTitle.textContent = 'My Orders';
                } else if (target.includes('wishlist')) {
                    document.getElementById('wishlist-section')?.classList.remove('hidden');
                    sectionTitle.textContent = 'Wishlist';
                } else if (target.includes('addresses')) {
                    document.getElementById('addresses-section')?.classList.remove('hidden');
                    sectionTitle.textContent = 'Addresses';
                }
            });
        });
    }
});

// ========================
// Notification
// ========================
function showMessage(message, isError = false) {
    console.log("showMessage called with:", message);

    const existingNotification = document.querySelector('.notification');
    if (existingNotification) existingNotification.remove();

    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;

    if (isError) notification.classList.add('error');

    document.body.appendChild(notification);

    setTimeout(() => notification.classList.add('show'), 10);

    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// ========================
// Cart + Favorites badges
// ========================
document.addEventListener("DOMContentLoaded", function() {
    const cartBadge = document.getElementById("cart-count");
    let cartCount = cartBadge ? parseInt(cartBadge.textContent) || 0 : 0;

    // Add to cart
    document.querySelectorAll(".add-to-cart").forEach(button => {
        button.addEventListener("click", () => {
            cartCount++;
            if (cartBadge) cartBadge.textContent = cartCount;

            const oldContent = button.innerHTML;
            button.style.backgroundColor = "#2ecc71";
            button.innerHTML = '<i class="fas fa-check"></i>';

            setTimeout(() => {
                button.style.backgroundColor = "";
                button.innerHTML = oldContent;
            }, 1000);

            showMessage("Added to cart!");
        });
    });
});

// ========================
// Countdown (Sale page)
// ========================
document.addEventListener('DOMContentLoaded', function() {
    const countdownContainer = document.querySelector('.sale-countdown');
    if (!countdownContainer) return;

    const daysEl = document.getElementById('days');
    const hoursEl = document.getElementById('hours');
    const minutesEl = document.getElementById('minutes');
    const secondsEl = document.getElementById('seconds');

    if (!daysEl || !hoursEl || !minutesEl || !secondsEl) return;

    const endTimeStr = countdownContainer.dataset.endTime;
    const countdownDate = new Date(endTimeStr.replace(' ', 'T'));

    function updateCountdown() {
        const now = new Date().getTime();
        const distance = countdownDate.getTime() - now;

        if (distance <= 0) {
            clearInterval(interval);
            countdownContainer.innerHTML = '<span>Sale Ended!</span>';
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        daysEl.textContent = String(days).padStart(2, '0');
        hoursEl.textContent = String(hours).padStart(2, '0');
        minutesEl.textContent = String(minutes).padStart(2, '0');
        secondsEl.textContent = String(seconds).padStart(2, '0');
    }

    updateCountdown(); 
    const interval = setInterval(updateCountdown, 1000);
});

// ========================
// Product Filtering and Sorting functionality
// ========================
function setupProductFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const sortSelect = document.getElementById('sortOptions');
    const activeFilterTags = document.getElementById('activeFilterTags');
    const productsGrid = document.querySelector('.products-grid');
    const productCards = document.querySelectorAll('.product-card');

    const urlParams = new URLSearchParams(window.location.search);
    let currentFilter = urlParams.get('filter') || localStorage.getItem('productFilter') || 'all';
    let currentSort = urlParams.get('sort') || localStorage.getItem('productSort') || 'default';

    localStorage.setItem('productFilter', currentFilter);
    localStorage.setItem('productSort', currentSort);

    function updateURL() {
        const url = new URL(window.location);
        url.searchParams.set('filter', currentFilter);
        url.searchParams.set('sort', currentSort);
        url.searchParams.set('page', '1');
        window.history.replaceState({}, '', url);
    }

    productCards.forEach(card => {
        const productName = card.querySelector('h3').textContent.toLowerCase();
        const productType = card.querySelector('p:nth-child(3)')
            .textContent.replace('Type: ', '')
            .trim().toLowerCase();

        let normalizedType = productType;
        if (normalizedType === "accessories") normalizedType = "accessory";

        card.setAttribute('data-name', productName);
        card.setAttribute('data-type', normalizedType);

        const priceText = card.querySelector('.price').textContent;
        const price = parseFloat(priceText.replace('$', '')) || 0;
        card.setAttribute('data-price', price);

        const ratingEl = card.querySelector('.rating-count');
        const rating = ratingEl ? parseFloat(ratingEl.textContent.replace(/[()]/g, '')) : 0;
        card.setAttribute('data-rating', rating);
    });

    filterButtons.forEach(button => {
        if (button.getAttribute('data-filter') === currentFilter) {
            button.classList.add('active');
        }
    });

    if (sortSelect) {
        sortSelect.value = currentSort;
    }

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.getAttribute('data-filter');

            localStorage.setItem('productFilter', currentFilter);
            updateURL();

            const url = new URL(window.location);
            url.searchParams.set('filter', currentFilter);
            url.searchParams.set('page', '1');
            window.location.href = url.toString();
        });
    });

    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            currentSort = this.value;

            localStorage.setItem('productSort', currentSort);
            updateURL();

            const url = new URL(window.location);
            url.searchParams.set('sort', currentSort);
            url.searchParams.set('page', '1');
            window.location.href = url.toString();
        });
    }

    function updateActiveFilterTags(filter) {
        const map = {
            all: 'All Products',
            shirt: 'Shirts',
            hoodie: 'Hoodies',
            shoes: 'Shoes',
            shorts: 'Shorts',
            accessory: 'Accessories',
            jacket: 'Jackets',
            jeans: 'Jeans'
        };

        let filterText = map[filter] || filter;
        activeFilterTags.innerHTML = `<span class="filter-tag">${filterText}</span>`;

        if (currentSort !== 'default') {
            const sortMap = {
                'price-low': 'Price: Low to High',
                'price-high': 'Price: High to Low',
                'name-asc': 'Name: A to Z',
                'name-desc': 'Name: Z to A',
                'rating': 'Highest Rated'
            };
            activeFilterTags.innerHTML += `<span class="filter-tag">${sortMap[currentSort]}</span>`;
        }
    }

    updateActiveFilterTags(currentFilter);
}

document.addEventListener('DOMContentLoaded', setupProductFilters);

document.addEventListener("DOMContentLoaded", () => {
    const baseUrl = `${window.location.origin}/OnlineStore/cart`;

    // Add to cart buttons
    document.querySelectorAll(".add-to-cart").forEach(btn => {
        btn.addEventListener("click", () => {
            const product = {
                id: btn.dataset.id,
                name: btn.dataset.name,
                price: btn.dataset.price,
                image: btn.dataset.image
            };

            fetch(`${baseUrl}/add`, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams(product)
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        updateCartCounter(data.items);
                    }
                });
        });
    });

    // Update quantity
    document.querySelectorAll(".quantity-input").forEach(input => {
        let oldQuantity = parseInt(input.value);

        input.addEventListener("change", () => {
            const newQuantity = parseInt(input.value);
            const id = input.dataset.id;

            fetch(`${baseUrl}/update`, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({
                    id: id,
                    quantity: newQuantity
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (newQuantity > oldQuantity) {
                            showMessage("Added to cart!");
                            setTimeout(() => location.reload(), 300);
                        } else if (newQuantity < oldQuantity) {
                            showMessage("Removed from cart!");
                            setTimeout(() => location.reload(), 300);
                        }
                        oldQuantity = newQuantity;
                        setTimeout(() => location.reload(), 300);
                    }
                });
        });
    });

    // Plus button functionality
    document.querySelectorAll(".quantity-btn.plus").forEach(btn => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            const quantityInput = document.querySelector(`.quantity-input[data-id="${id}"]`);
            const currentQuantity = parseInt(quantityInput.value);
            const newQuantity = currentQuantity + 1;

            quantityInput.quantity = newQuantity;
            fetch(`${baseUrl}/update`, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({
                    id: id,
                    quantity: newQuantity
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showMessage("Added to cart!");
                        updateCartCounter(data.items);
                        setTimeout(() => location.reload(), 300);
                    }
                });
        });
    });

    // Minus button functionality
    document.querySelectorAll(".quantity-btn.minus").forEach(btn => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            const quantityInput = document.querySelector(`.quantity-input[data-id="${id}"]`);
            const currentQuantity = parseInt(quantityInput.value);

            if (currentQuantity <= 1) {
                return;
            }

            const newQuantity = currentQuantity - 1;

            quantityInput.quantity = newQuantity;

            fetch(`${baseUrl}/update`, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({
                    id: id,
                    quantity: newQuantity
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showMessage("Removed from cart!");
                        updateCartCounter(data.items);
                        setTimeout(() => location.reload(), 300);
                    }
                });
        });
    });

    // Remove item
    document.querySelectorAll(".remove-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            fetch(`${baseUrl}/remove`, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({ id: btn.dataset.id })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showMessage("Removed from cart!");
                        setTimeout(() => location.reload(), 300);
                    }
                });
        });
    });


    // Checkout modal
    const checkoutBtn = document.getElementById("checkout-btn");
    const modal = document.getElementById("checkout-modal");
    const closeBtn = modal.querySelector(".close");
    const closeCheckoutBtn = document.getElementById("close-checkout");

    if (checkoutBtn) {
        checkoutBtn.addEventListener("click", () => modal.style.display = "block");
    }
    if (closeBtn) {
        closeBtn.addEventListener("click", () => modal.style.display = "none");
    }
    if (closeCheckoutBtn) {
        closeCheckoutBtn.addEventListener("click", () => modal.style.display = "none");
    }

    function updateCartCounter(items) {
        const count = Object.values(items).reduce((acc, item) => acc + item.quantity, 0);
        const counter = document.getElementById("cart-counter");
        if (counter) counter.textContent = count;
    }

    document.querySelectorAll(".quantity-btn").forEach(function(btn) {
        btn.addEventListener("click", function() {
            const input = this.parentElement.querySelector(".quantity-input");
            let currentValue = parseInt(input.value) || 1;

            if (this.classList.contains("plus")) {
                currentValue++;
            } else if (this.classList.contains("minus") && currentValue > 1) {
                currentValue--;
            }

            input.value = currentValue;

            fetch(`${APP_URL}/cart/updateQuantity`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    id: this.dataset.id,
                    quantity: currentValue
                })
            }).then(res => res.json())
                .then(data => {
                    console.log("Updated:", data);
                });
        });
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const checkoutForm = document.getElementById("checkout-form");
    const resultModal = document.getElementById("result-modal");
    const resultMessage = document.getElementById("result-message");
    const closeResult = document.getElementById("close-result");
    const okResult = document.getElementById("ok-result");

    checkoutForm.addEventListener("submit", async function(e) {
        e.preventDefault();

        const formData = new FormData(checkoutForm);
        const response = await fetch(checkoutForm.action, {
            method: "POST",
            body: formData
        });
        const data = await response.json();

        resultMessage.textContent = data.message;
        resultModal.style.display = "block";
    });

    [closeResult, okResult].forEach(btn => {
        btn.addEventListener("click", () => {
            resultModal.style.display = "none";
            if (resultMessage.textContent.includes("successful")) {
                window.location.href = "/OnlineStore/cart"; 
            }
        });
    });

    window.addEventListener("click", (e) => {
        if (e.target === resultModal) {
            resultModal.style.display = "none";
        }
    });
});
