<!-- Profile Section -->
<section class="profile-section">
    <div class="container">
        <div class="profile-container">
            <div class="profile-sidebar">
                <div class="profile-user">
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3><?php echo $data['user']['first_name'] . ' ' . $data['user']['last_name']; ?></h3>
                    <p><?php echo $data['user']['email']; ?></p>
                </div>
                
                <nav class="profile-nav">
                    <a href="#" class="profile-nav-item active">
                        <i class="fas fa-user"></i> Personal Information
                    </a>
                    <a href="<?php echo APP_URL; ?>/cart" class="profile-nav-item">
                        <i class="fas fa-cart"></i> MyCart
                    </a>
                    <a href="<?php echo APP_URL; ?>/auth/logout" class="profile-nav-item">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </div>
            
            <div class="profile-content">
                <h2>Personal Information</h2>
                
                <form action="<?php echo APP_URL; ?>/auth/updateProfile" method="POST" class="profile-form">
                    <input type="hidden" name="user_id" value="<?php echo $data['user']['user_id']; ?>">
                    
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($data['user']['first_name']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($data['user']['last_name']); ?>" required>
                        </div>
        
                    
            
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($data['user']['email']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($data['user']['phone']); ?>">
                        </div>
                    

                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($data['user']['address']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($data['user']['city']); ?>" required>
                        </div>
                    
                    <!-- Change Password Section -->
                            <div class="form-group">
                                <label style="font-size: 21px;">Change Password</label>
                                <label for="current_password">Current Password</label>
                                <input type="password" id="current_password" name="current_password" placeholder="Enter current password">
                            </div>
                            
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" id="new_password" name="new_password" placeholder="Enter new password">
                            </div>
                        
                        
                            <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password">
                            </div>
                
            
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</section>