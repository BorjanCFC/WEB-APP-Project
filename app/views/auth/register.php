<!-- Register Section -->
<section class="auth-section">
    <div class="container">
        <div class="auth-container">
            
            <div class="auth-form">
                <h2>Create Account</h2>
                <p>Join us for a better shopping experience</p>
                
                <form action="<?php echo APP_URL; ?>/auth/doregister" method="POST" class="auth-form-container" autocomplete="on" novalidate>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input 
                                type="text" 
                                id="first_name" 
                                name="first_name" 
                                required 
                                placeholder="Enter your first name" 
                                autocomplete="given-name"
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input 
                                type="text" 
                                id="last_name" 
                                name="last_name" 
                                required 
                                placeholder="Enter your last name" 
                                autocomplete="family-name"
                            >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            required 
                            placeholder="Enter your email" 
                            autocomplete="email"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            placeholder="Enter your phone number" 
                            autocomplete="tel" 
                            inputmode="tel"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input 
                            type="text" 
                            id="address" 
                            name="address" 
                            required 
                            placeholder="Enter your address" 
                            autocomplete="street-address"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="city">City</label>
                        <input 
                            type="text" 
                            id="city" 
                            name="city" 
                            required 
                            placeholder="Enter your city" 
                            autocomplete="address-level2"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="card_number">Card Number</label>
                        <!-- pattern accepts 13 to 19 digits (typical card lengths) -->
                        <input
                            type="text"
                            id="card_number"
                            name="card_number"
                            required
                            placeholder="1234 5678 9012 3456"
                            maxlength="19"
                            inputmode="numeric"
                            pattern="\d{13,19}"
                            autocomplete="cc-number"
                            aria-describedby="card-help"
                        >
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="expiry_date">Expiration Date</label>
                            <!-- MM/YY -->
                            <input
                                type="text"
                                id="expiry_date"
                                name="expiry_date"
                                required
                                placeholder="MM/YY"
                                maxlength="5"
                                inputmode="numeric"
                                pattern="(0[1-9]|1[0-2])\/\d{2}"
                                autocomplete="cc-exp"
                                aria-label="Card expiration date MM/YY"
                            >
                        </div>
                        
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input
                                type="text"
                                id="cvv"
                                name="cvv"
                                required
                                placeholder="123"
                                maxlength="4"
                                inputmode="numeric"
                                pattern="\d{3,4}"
                                autocomplete="cc-csc"
                                aria-label="Card CVV"
                            >
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required 
                            placeholder="Create a password" 
                            autocomplete="new-password"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input 
                            type="password" 
                            id="confirm_password" 
                            name="confirm_password" 
                            required 
                            placeholder="Confirm your password" 
                            autocomplete="new-password"
                        >
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-full">
                        Create Account
                    </button>
                </form>
                
                <div class="auth-switch">
                    <p>
                        Already have an account? 
                        <a href="<?php echo APP_URL; ?>/auth/login">Sign in here</a>
                    </p>
                </div>
            </div>
            
            <div class="auth-image">
                <img 
                    src="https://images.unsplash.com/photo-1529139574466-a303027c1d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                    alt="Fashion Register"
                >
                <div class="auth-image-overlay">
                    <h3>Join Our Community</h3>
                    <p>Enjoy personalized recommendations, faster checkout, and order tracking</p>
                </div>
            </div>
            
        </div>
    </div>
</section>
