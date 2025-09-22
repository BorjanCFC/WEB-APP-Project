<section class="auth-section">
    <div class="container">
        <div class="auth-container">
            <div class="auth-form">
                <h2>Enter Verification Code</h2>
                <p>Check your email for the 6-digit code</p>

                <?php if(!empty($error)): ?>
                    <div class="error-message" style="color:red;"><?= $error ?></div>
                <?php endif; ?>

                <form action="<?php echo APP_URL; ?>/auth/verifyCode" method="POST">
                    <input type="hidden" name="email" value="<?= $email ?>">
                    <div class="form-group">
                        <label for="code">Verification Code</label>
                        <input type="text" id="code" name="code" required placeholder="Enter 6-digit code" maxlength="6">
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">Verify Code</button>
                </form>
            </div>
        </div>
    </div>
</section>
