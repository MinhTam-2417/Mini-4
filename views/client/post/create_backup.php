<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Tạo bài viết mới - Blog Mini</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

  <style>
    body {
      background-color: #fafafa;
      font-family: 'Segoe UI', sans-serif;
    }

    .sidebar {
      height: 100vh;
      background-color: #fff;
      border-right: 1px solid #ddd;
      padding: 1rem 0.5rem;
      position: sticky;
      top: 0;
    }

    .sidebar .nav-link {
      color: #000;
      font-weight: 500;
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 15px;
      border-radius: 10px;
      transition: background 0.2s;
    }

    .sidebar .nav-link:hover {
      background-color: #f0f0f0;
      text-decoration: none;
    }

    .sidebar .logo {
      font-size: 2rem;
      font-weight: bold;
      text-align: center;
      margin-bottom: 1.5rem;
    }

    .main-content {
      padding: 2rem 1rem;
    }

    .create-form {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      padding: 2rem;
    }

    .form-label {
      font-weight: 600;
      color: #333;
    }

    .form-control:focus {
      border-color: #007bff;
      box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
    }

    .btn-publish {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
      color: white;
      font-weight: 600;
    }

    .btn-draft {
      background: #6c757d;
      border: none;
      color: white;
      font-weight: 600;
    }

    .preview-area {
      background: #f8f9fa;
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 1rem;
      margin-top: 1rem;
    }

    @media (max-width: 768px) {
      .sidebar {
        display: none;
      }
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar trái -->
      <div class="col-md-2 sidebar d-flex flex-column align-items-start">
        <div class="logo">🧵</div>

        <a href="/Mini-4/public/" class="nav-link"><i class="bi bi-house-door"></i> Trang chủ</a>
        <a href="/Mini-4/public/search" class="nav-link"><i class="bi bi-search"></i> Tìm kiếm</a>
        <a href="/Mini-4/public/post/create" class="nav-link active"><i class="bi bi-plus-square"></i> Bài viết</a>
        <a href="#" class="nav-link"><i class="bi bi-heart"></i> Thích</a>
        <a href="/Mini-4/public/profile" class="nav-link"><i class="bi bi-person"></i> Hồ sơ</a>
        <a href="#" class="nav-link"><i class="bi bi-three-dots"></i> Khác</a>

        <div class="mt-auto w-100 px-3">
          <?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
          <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/Mini-4/public/logout" class="btn btn-dark w-100 rounded-pill mt-4">Đăng xuất</a>
          <?php else: ?>
            <a href="/Mini-4/public/login" class="btn btn-dark w-100 rounded-pill mt-4">Đăng nhập</a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Nội dung chính -->
      <div class="col-md-10 main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2><i class="bi bi-plus-circle"></i> Tạo bài viết mới</h2>
          <a href="/Mini-4/public/" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
          </a>
        </div>

        <!-- Session messages -->
        <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($_SESSION['error']); ?>
          </div>
          <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success" role="alert">
            <?php echo htmlspecialchars($_SESSION['success']); ?>
          </div>
          <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

                 <!-- Form tạo bài viết -->
         <div class="create-form">
           <form method="POST" action="/Mini-4/public/post/store" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-8">
                <!-- Tiêu đề -->
                <div class="mb-4">
                  <label for="title" class="form-label">Tiêu đề bài viết *</label>
                  <input type="text" class="form-control form-control-lg" id="title" name="title" 
                         placeholder="Nhập tiêu đề bài viết..." required>
                </div>

                <!-- Nội dung -->
                <div class="mb-4">
                  <label for="content" class="form-label">Nội dung bài viết *</label>
                  <textarea class="form-control" id="content" name="content" rows="15" 
                            placeholder="Viết nội dung bài viết của bạn..." required></textarea>
                </div>

                                 <!-- Hình ảnh đại diện -->
                 <div class="mb-4">
                   <label for="featured_image" class="form-label">Hình ảnh đại diện</label>
                   <input type="file" class="form-control" id="featured_image" name="featured_image" 
                          accept="image/*">
                                       <div class="form-text">Chọn hình ảnh đại diện cho bài viết (JPG, PNG, GIF, WebP)</div>
                    <div class="form-check form-check-inline mt-2">
                      <input class="form-check-input" type="radio" name="image_fit" id="fit_contain" value="contain" checked>
                      <label class="form-check-label" for="fit_contain">Hiển thị toàn bộ hình ảnh</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="image_fit" id="fit_cover" value="cover">
                      <label class="form-check-label" for="fit_cover">Cắt hình ảnh để vừa khung</label>
                    </div>
                   <div id="image-preview" class="mt-2" style="display: none;">
                                           <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px; max-height: 200px; object-fit: contain; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); background-color: #f8f9fa;">
                   </div>
                 </div>

                 <!-- Mô tả ngắn -->
                 <div class="mb-4">
                   <label for="excerpt" class="form-label">Mô tả ngắn</label>
                   <textarea class="form-control" id="excerpt" name="excerpt" rows="3" 
                             placeholder="Mô tả ngắn gọn về bài viết (tự động tạo nếu để trống)"></textarea>
                   <div class="form-text">Để trống để tự động tạo mô tả từ nội dung</div>
                 </div>
              </div>

              <div class="col-md-4">
                <!-- Cài đặt bài viết -->
                <div class="card">
                  <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-gear"></i> Cài đặt bài viết</h6>
                  </div>
                  <div class="card-body">
                    <!-- Danh mục -->
                    <div class="mb-3">
                      <label for="category_id" class="form-label">Danh mục</label>
                      <select class="form-select" id="category_id" name="category_id">
                        <option value="">Chọn danh mục</option>
                        <?php foreach ($categories as $category): ?>
                          <option value="<?php echo $category['id']; ?>">
                            <?php echo htmlspecialchars($category['name']); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <!-- Tags -->
                    <div class="mb-3">
                      <label for="tags" class="form-label">Thẻ (Tags)</label>
                      <select class="form-select" id="tags" name="tags[]" multiple>
                        <?php foreach ($tags as $tag): ?>
                          <option value="<?php echo $tag['id']; ?>">
                            <?php echo htmlspecialchars($tag['name']); ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                      <div class="form-text">Giữ Ctrl (hoặc Cmd trên Mac) để chọn nhiều thẻ</div>
                      <div id="selected-tags" class="mt-2"></div>
                    </div>

                    <!-- Trạng thái -->
                    <div class="mb-3">
                      <label for="status" class="form-label">Trạng thái</label>
                      <select class="form-select" id="status" name="status">
                        <option value="draft">Bản nháp</option>
                        <option value="published">Xuất bản</option>
                      </select>
                    </div>

                    <!-- Preview -->
                    <div class="mb-3">
                      <label class="form-label">Xem trước</label>
                      <div class="preview-area">
                        <div id="preview-title" class="fw-bold mb-2"></div>
                        <div id="preview-excerpt" class="text-muted small"></div>
                      </div>
                    </div>

                    <!-- Nút hành động -->
                    <div class="d-grid gap-2">
                      <button type="submit" name="action" value="publish" class="btn btn-publish">
                        <i class="bi bi-check-circle"></i> Xuất bản
                      </button>
                      <button type="submit" name="action" value="draft" class="btn btn-draft">
                        <i class="bi bi-save"></i> Lưu bản nháp
                      </button>
                    </div>
                  </div>
                </div>

                <!-- Hướng dẫn -->
                <div class="card mt-3">
                  <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-info-circle"></i> Hướng dẫn</h6>
                  </div>
                  <div class="card-body">
                    <ul class="list-unstyled small">
                      <li class="mb-2"><i class="bi bi-check text-success"></i> Viết tiêu đề hấp dẫn</li>
                      <li class="mb-2"><i class="bi bi-check text-success"></i> Nội dung rõ ràng, có cấu trúc</li>
                      <li class="mb-2"><i class="bi bi-check text-success"></i> Chọn danh mục phù hợp</li>
                      <li class="mb-2"><i class="bi bi-check text-success"></i> Kiểm tra trước khi xuất bản</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Preview real-time
    document.getElementById('title').addEventListener('input', function() {
      document.getElementById('preview-title').textContent = this.value || 'Tiêu đề bài viết';
    });

    document.getElementById('excerpt').addEventListener('input', function() {
      document.getElementById('preview-excerpt').textContent = this.value || 'Mô tả bài viết...';
    });

         // Auto-generate excerpt from content
     document.getElementById('content').addEventListener('input', function() {
       const excerptField = document.getElementById('excerpt');
       if (!excerptField.value) {
         const content = this.value;
         const excerpt = content.substring(0, 200) + (content.length > 200 ? '...' : '');
         excerptField.value = excerpt;
         document.getElementById('preview-excerpt').textContent = excerpt || 'Mô tả bài viết...';
       }
     });

           // Image preview
      document.getElementById('featured_image').addEventListener('change', function() {
        const file = this.files[0];
        const preview = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');
        
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
          }
          reader.readAsDataURL(file);
        } else {
          preview.style.display = 'none';
        }
      });

      // Update preview based on image fit option
      document.querySelectorAll('input[name="image_fit"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
          const previewImg = document.getElementById('preview-img');
          if (previewImg.src) {
            previewImg.style.objectFit = this.value;
          }
        });
      });

      // Tags selection
      document.getElementById('tags').addEventListener('change', function() {
        const selectedTags = Array.from(this.selectedOptions).map(option => option.text);
        const selectedTagsDiv = document.getElementById('selected-tags');
        
        if (selectedTags.length > 0) {
          selectedTagsDiv.innerHTML = selectedTags.map(tag => 
            `<span class="badge bg-primary me-1 mb-1">${tag}</span>`
          ).join('');
        } else {
          selectedTagsDiv.innerHTML = '';
        }
      });
  </script>
</body>
</html> 