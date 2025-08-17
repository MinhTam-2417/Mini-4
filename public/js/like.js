// Like functionality
document.addEventListener('DOMContentLoaded', function() {
    console.log('Like.js loaded successfully');
    console.log('User logged in:', document.body.dataset.loggedIn);
    
    // Xử lý nút like
    document.addEventListener('click', function(e) {
        if (!e || !e.target) {
            console.log('No valid event target');
            return;
        }
        
        console.log('Click event:', e.target);
        
        // Kiểm tra xem có phải click vào nút like không
        const likeBtn = e.target.classList && e.target.classList.contains('like-btn') 
            ? e.target 
            : e.target.closest && e.target.closest('.like-btn');
        
        if (likeBtn) {
            e.preventDefault();
            console.log('Like button clicked');
            
            const postId = likeBtn.dataset.postId;
            console.log('Post ID:', postId);
            
            if (!postId) {
                console.error('Post ID not found');
                return;
            }
            
            // Kiểm tra đăng nhập
            if (!isLoggedIn()) {
                showMessage('Vui lòng đăng nhập để like bài viết', 'error');
                return;
            }
            
            // Gửi request like
            toggleLike(postId, likeBtn);
        }
    });
    
    // Xử lý hover để hiển thị danh sách user đã like
    document.addEventListener('mouseenter', function(e) {
        if (!e || !e.target) {
            return;
        }
        
        // Kiểm tra xem có phải hover vào like-count không
        const likeCount = e.target.classList && e.target.classList.contains('like-count') 
            ? e.target 
            : e.target.closest && e.target.closest('.like-count');
        
        if (likeCount) {
            const postId = likeCount.dataset.postId;
            
            if (postId && parseInt(likeCount.textContent) > 0) {
                showUsersWhoLiked(postId, likeCount);
            }
        }
    });
});

// Toggle like
function toggleLike(postId, likeBtn) {
    console.log('Toggle like for post:', postId);
    
    const formData = new FormData();
    formData.append('post_id', postId);
    
    fetch('/Mini-4/public/like/toggle', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        console.log('data.likeCount:', data.likeCount);
        console.log('data.likeCount type:', typeof data.likeCount);
        if (data.success) {
            // Cập nhật UI
            updateLikeUI(likeBtn, data.liked, data.likeCount);
            showMessage(data.message, 'success');
        } else {
            showMessage(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('Có lỗi xảy ra', 'error');
    });
}

// Cập nhật UI like
function updateLikeUI(likeBtn, isLiked, likeCount) {
    console.log('Updating UI - isLiked:', isLiked, 'likeCount:', likeCount);
    
    const postId = likeBtn.dataset.postId;
    const icon = likeBtn.querySelector('.like-icon');
    
    console.log('Icon element:', icon);
    
    // Cập nhật icon trong nút like
    if (icon) {
        if (isLiked) {
            icon.innerHTML = '<i class="bi bi-heart-fill"></i>';
            likeBtn.classList.add('liked');
            likeBtn.classList.remove('btn-outline-danger');
            likeBtn.classList.add('btn-danger');
            console.log('Updated icon to liked');
        } else {
            icon.innerHTML = '<i class="bi bi-heart"></i>';
            likeBtn.classList.remove('liked');
            likeBtn.classList.remove('btn-danger');
            likeBtn.classList.add('btn-outline-danger');
            console.log('Updated icon to unliked');
        }
    }
    
    // Cập nhật title
    if (isLiked) {
        likeBtn.title = 'Bỏ thích';
    } else {
        likeBtn.title = 'Thích';
    }
    
    // Cập nhật số like trong phần hiển thị số lượt like
    const countElements = document.querySelectorAll(`.like-count[data-post-id="${postId}"]`);
    console.log('Found', countElements.length, 'count elements for post', postId);
    
    countElements.forEach(countElement => {
        // Cập nhật số trong text - xử lý trường hợp likeCount undefined
        const textContent = countElement.textContent;
        const safeLikeCount = likeCount !== undefined && likeCount !== null ? likeCount : 0;
        const newTextContent = textContent.replace(/\d+/, safeLikeCount);
        countElement.textContent = newTextContent;
        console.log('Updated count element text to:', newTextContent);
    });
    
    // Cập nhật tất cả các nút like của cùng bài viết
    const allLikeBtns = document.querySelectorAll(`.like-btn[data-post-id="${postId}"]`);
    console.log('Found', allLikeBtns.length, 'like buttons for post', postId);
    
    allLikeBtns.forEach(btn => {
        const btnIcon = btn.querySelector('.like-icon');
        
        if (btnIcon) {
            if (isLiked) {
                btnIcon.innerHTML = '<i class="bi bi-heart-fill"></i>';
                btn.classList.add('liked');
                btn.classList.remove('btn-outline-danger');
                btn.classList.add('btn-danger');
            } else {
                btnIcon.innerHTML = '<i class="bi bi-heart"></i>';
                btn.classList.remove('liked');
                btn.classList.remove('btn-danger');
                btn.classList.add('btn-outline-danger');
            }
        }
        
        // Cập nhật title cho tất cả các nút
        if (isLiked) {
            btn.title = 'Bỏ thích';
        } else {
            btn.title = 'Thích';
        }
    });
}

// Hiển thị danh sách user đã like
function showUsersWhoLiked(postId, likeCountElement) {
    fetch(`/Mini-4/public/like/users/${postId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.users.length > 0) {
                const userNames = data.users.map(user => user.full_name || user.username).join(', ');
                
                // Tạo tooltip
                const tooltip = document.createElement('div');
                tooltip.className = 'like-tooltip';
                tooltip.textContent = `Đã like bởi: ${userNames}`;
                tooltip.style.cssText = `
                    position: absolute;
                    background: #333;
                    color: white;
                    padding: 8px 12px;
                    border-radius: 4px;
                    font-size: 12px;
                    z-index: 1000;
                    max-width: 200px;
                    word-wrap: break-word;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
                `;
                
                // Xóa tooltip cũ nếu có
                const existingTooltip = document.querySelector('.like-tooltip');
                if (existingTooltip) {
                    existingTooltip.remove();
                }
                
                // Thêm tooltip mới
                document.body.appendChild(tooltip);
                
                // Định vị tooltip
                const rect = likeCountElement.getBoundingClientRect();
                tooltip.style.left = rect.left + 'px';
                tooltip.style.top = (rect.top - tooltip.offsetHeight - 5) + 'px';
                
                // Xóa tooltip khi mouse leave
                likeCountElement.addEventListener('mouseleave', function() {
                    setTimeout(() => {
                        if (tooltip.parentNode) {
                            tooltip.remove();
                        }
                    }, 100);
                });
            }
        })
        .catch(error => {
            console.error('Error fetching users who liked:', error);
        });
}

// Kiểm tra đăng nhập
function isLoggedIn() {
    // Kiểm tra session hoặc token
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
const style = document.createElement('style');
style.textContent = `
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
    
    .like-btn {
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
    
    .like-btn:hover {
        transform: scale(1.02);
    }
    
    .like-btn i {
        font-size: 0.875rem !important;
    }
    
    .like-btn.liked {
        color: #dc3545;
    }
    
    .like-count {
        cursor: pointer;
    }
`;
document.head.appendChild(style);
