<section class="auth-section">
    <div class="container">
        <div class="auth-container">
            <div class="auth-form">
                <h2>Reset Password</h2>
                <p>Enter your new password</p>

                <?php if(!empty($error)): ?>
                    <div class="error-message" style="color:red;"><?= $error ?></div>
                <?php endif; ?>

                <form action="<?php echo APP_URL; ?>/auth/resetPassword" method="POST">
                    <input type="hidden" name="email" value="<?= $email ?>">
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="new_password" required placeholder="Enter new password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm new password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</section>
