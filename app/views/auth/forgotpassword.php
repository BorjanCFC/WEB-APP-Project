<section class="auth-section">
    <div class="container">
        <div class="auth-container">
            <div class="auth-form">
                <h2>Forgot Password</h2>
                <p>Enter your email to receive a verification code</p>

                <?php if(!empty($error)): ?>
                    <div class="error-message" style="color:red;"><?= $error ?></div>
                <?php endif; ?>

                <form action="<?php echo APP_URL; ?>/auth/sendVerificationCode" method="POST">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required placeholder="Enter your registered email">
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">Send Verification Code</button>
                </form>
            </div>
        </div>
    </div>
</section>
