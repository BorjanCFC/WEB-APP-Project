 <!-- Login Section -->
    <section class="auth-section">
        <div class="container">
            <div class="auth-container">
                <div class="auth-form">
                    <h2>Welcome Back</h2>
                    <p>Sign in to your account to continue shopping</p>

                    <?php if(!empty($error)): ?>
    <div class="error-message">
        <?= $error ?>
    </div>
<?php endif; ?>
                    
                    <form action="<?php echo APP_URL; ?>/auth/dologin" method="POST" class="auth-form-container">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required placeholder="Enter your email">
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required placeholder="Enter your password">
                            <a href="<?php echo APP_URL; ?>/auth/forgetpassword" class="forgot-password">Forgot Password?</a>

                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-full">Sign In</button>
                    </form>
                    
                    <div class="auth-switch">
                        <p>Don't have an account? <a href="<?php echo APP_URL; ?>/auth/register">Create one here</a></p>
                    </div>
                </div>
                
                <div class="auth-image">
                    <img src="https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Fashion Login">
                    <div class="auth-image-overlay">
                        <h3>Fashion Forward</h3>
                        <p>Sign in to access your personalized shopping experience</p>
                    </div>
                </div>
            </div>
        </div>
    </section>