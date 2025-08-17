<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body p-4">
                <h3 class="card-title text-center mb-4">
                    <i class="bi bi-shield-lock text-primary"></i> Đặt lại mật khẩu
                </h3>
                
                <p class="text-muted text-center mb-4">
                    Nhập mật khẩu mới cho tài khoản của bạn
                </p>
                
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($_SESSION['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($_SESSION['error']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>
                
                <form action="/Mini-4/public/reset-password" method="POST">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token ?? ''); ?>">
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu mới</label>
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Nhập mật khẩu mới" required minlength="6">
                        <div class="form-text">
                            Mật khẩu phải có ít nhất 6 ký tự
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                               placeholder="Nhập lại mật khẩu mới" required minlength="6">
                        <div class="form-text">
                            Nhập lại mật khẩu để xác nhận
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle"></i> Đặt lại mật khẩu
                    </button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="/Mini-4/public/login" class="text-decoration-none">
                        <i class="bi bi-arrow-left"></i> Quay lại đăng nhập
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Kiểm tra mật khẩu khớp nhau
document.getElementById('confirm_password').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    
    if (password !== confirmPassword) {
        this.setCustomValidity('Mật khẩu không khớp');
    } else {
        this.setCustomValidity('');
    }
});
</script>


