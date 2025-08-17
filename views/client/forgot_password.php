<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body p-4">
                <h3 class="card-title text-center mb-4">
                    <i class="bi bi-question-circle text-primary"></i> Quên mật khẩu
                </h3>
                
                <p class="text-muted text-center mb-4">
                    Nhập email của bạn để nhận link đặt lại mật khẩu
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
                
                <form action="/Mini-4/public/forgot-password" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               placeholder="Nhập email của bạn" required>
                        <div class="form-text">
                            Chúng tôi sẽ gửi link đặt lại mật khẩu đến email này
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-envelope"></i> Gửi link đặt lại mật khẩu
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


