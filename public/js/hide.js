// Hide post functionality
document.addEventListener('DOMContentLoaded', function() {
    console.log('Hide.js loaded successfully');
    
    // Xử lý nút ẩn bài viết
    document.addEventListener('click', function(e) {
        console.log('Click event detected');
        console.log('Target:', e.target);
        console.log('Target classes:', e.target.className);
        
        if (!e || !e.target) {
            console.log('No event or target');
            return;
        }
        
        // Kiểm tra xem có phải click vào nút ẩn không
        const hideBtn = e.target.closest('.hide-btn');
        console.log('Hide button found:', hideBtn);
        
        if (hideBtn) {
            e.preventDefault();
            console.log('Hide button clicked');
            
            const postId = hideBtn.dataset.postId;
            console.log('Post ID:', postId);
            
            if (!postId) {
                console.error('Post ID not found');
                return;
            }
            
            // Kiểm tra đăng nhập
            if (!isLoggedIn()) {
                showMessage('Vui lòng đăng nhập để ẩn bài viết', 'error');
                return;
            }
            
            // Gửi request ẩn/hiện bài viết
            toggleHide(postId, hideBtn);
        }
    });
});

// Toggle ẩn/hiện bài viết
function toggleHide(postId, hideBtn) {
    console.log('Toggle hide for post:', postId);
    
    const formData = new FormData();
    formData.append('post_id', postId);
    
    fetch('/Mini-4/public/hide/toggle', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Cập nhật UI
            updateHideUI(hideBtn, data.hidden);
            showMessage(data.message, 'success');
            
            // Nếu ẩn bài viết, xóa khỏi trang chủ
            if (data.hidden) {
                const card = hideBtn.closest('.card');
                if (card) {
                    card.style.opacity = '0.5';
                    card.style.pointerEvents = 'none';
                    setTimeout(() => {
                        card.remove();
                    }, 500);
                }
            }
        } else {
            showMessage(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('Có lỗi xảy ra', 'error');
    });
}

// Cập nhật UI ẩn bài viết
function updateHideUI(hideBtn, isHidden) {
    console.log('Updating UI - isHidden:', isHidden);
    
    const icon = hideBtn.querySelector('.hide-icon');
    const postId = hideBtn.dataset.postId;
    
    console.log('Icon element:', icon);
    console.log('Post ID:', postId);
    
    // Cập nhật icon trong nút ẩn
    if (icon) {
        if (isHidden) {
            icon.innerHTML = '<i class="bi bi-eye-slash"></i>';
            hideBtn.classList.add('btn-warning');
            hideBtn.classList.remove('btn-outline-warning');
            hideBtn.title = 'Hiện bài viết';
            console.log('Updated icon to hidden');
        } else {
            icon.innerHTML = '<i class="bi bi-eye"></i>';
            hideBtn.classList.remove('btn-warning');
            hideBtn.classList.add('btn-outline-warning');
            hideBtn.title = 'Ẩn bài viết';
            console.log('Updated icon to visible');
        }
    }
    
    // Cập nhật tất cả các nút ẩn của cùng bài viết
    const allHideBtns = document.querySelectorAll(`.hide-btn[data-post-id="${postId}"]`);
    console.log('Found', allHideBtns.length, 'hide buttons for post', postId);
    
    allHideBtns.forEach(btn => {
        const btnIcon = btn.querySelector('.hide-icon');
        
        if (btnIcon) {
            if (isHidden) {
                btnIcon.innerHTML = '<i class="bi bi-eye-slash"></i>';
                btn.classList.add('btn-warning');
                btn.classList.remove('btn-outline-warning');
                btn.title = 'Hiện bài viết';
            } else {
                btnIcon.innerHTML = '<i class="bi bi-eye"></i>';
                btn.classList.remove('btn-warning');
                btn.classList.add('btn-outline-warning');
                btn.title = 'Ẩn bài viết';
            }
        }
    });
}

// Kiểm tra đăng nhập
function isLoggedIn() {
    const loggedIn = document.body.dataset.loggedIn === 'true';
    console.log('User logged in:', loggedIn);
    return loggedIn;
}

// Hiển thị thông báo
function showMessage(message, type = 'info') {
    // Tạo toast notification
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 20px;
        border-radius: 4px;
        color: white;
        font-weight: 500;
        z-index: 10000;
        animation: slideIn 0.3s ease;
    `;
    
    // Màu sắc theo loại
    if (type === 'success') {
        toast.style.backgroundColor = '#28a745';
    } else if (type === 'error') {
        toast.style.backgroundColor = '#dc3545';
    } else {
        toast.style.backgroundColor = '#17a2b8';
    }
    
    document.body.appendChild(toast);
    
    // Tự động xóa sau 3 giây
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 300);
    }, 3000);
}

// CSS animation
const hideStyle = document.createElement('style');
hideStyle.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
         .hide-btn {
         cursor: pointer;
         transition: all 0.2s ease;
         width: 32px !important;
         height: 32px !important;
         padding: 0.25rem !important;
         font-size: 0.875rem !important;
         display: inline-flex !important;
         align-items: center !important;
         justify-content: center !important;
         min-width: auto !important;
         max-width: 32px !important;
     }
     
     .hide-btn:hover {
         transform: scale(1.02);
     }
    
    .hide-btn.btn-warning {
        color: #fff;
    }
    
    .hide-btn.btn-outline-warning {
        color: #ffc107;
        border-color: #ffc107;
    }
    
    .hide-btn.btn-outline-warning:hover {
        color: #000;
        background-color: #ffc107;
        border-color: #ffc107;
    }
`;
document.head.appendChild(hideStyle);
