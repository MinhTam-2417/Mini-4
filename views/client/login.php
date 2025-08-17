<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body p-4">
                <h3 class="card-title text-center mb-4">Đăng nhập</h3>
                
                <form action="/Mini-4/public/login" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="/Mini-4/public/forgot-password" class="text-decoration-none d-block mb-2">
                        <i class="bi bi-question-circle"></i> Quên mật khẩu?
                    </a>
                    <a href="/Mini-4/public/register" class="text-decoration-none">
                        Chưa có tài khoản? <strong>Đăng ký ngay</strong>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
