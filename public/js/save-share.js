// Save and Share functionality
class SaveShareManager {
    constructor() {
        this.initSaveButtons();
        this.initShareButtons();
        this.initShareDropdowns();
    }

    // Khởi tạo nút lưu bài viết
    initSaveButtons() {
        document.querySelectorAll('.save-btn, .unsave-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleSave(btn);
            });
        });
    }

    // Khởi tạo nút chia sẻ
    initShareButtons() {
        document.querySelectorAll('.share-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.showShareOptions(btn);
            });
        });
    }

    // Khởi tạo dropdown chia sẻ
    initShareDropdowns() {
        document.querySelectorAll('.share-dropdown-item').forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const postId = item.dataset.postId;
                const shareType = item.dataset.shareType;
                this.sharePost(postId, shareType);
            });
        });
    }

    // Toggle lưu/bỏ lưu bài viết
    async toggleSave(btn) {
        const postId = btn.dataset.postId;
        const isSaved = btn.classList.contains('unsave-btn');
        const url = isSaved ? '/Mini-4/public/post/unsave' : '/Mini-4/public/post/save';

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `post_id=${postId}`
            });

            const data = await response.json();

            if (data.success) {
                this.updateSaveButton(btn, data.saved);
                this.updateSaveCount(postId, data.save_count);
                this.showAlert(data.message, 'success');
                
                // Nếu đang ở trang saved posts và bỏ lưu thành công, xóa bài viết khỏi danh sách
                if (window.location.pathname.includes('saved-posts') && !data.saved) {
                    const postCard = btn.closest('.card');
                    if (postCard) {
                        postCard.style.opacity = '0.5';
                        postCard.style.pointerEvents = 'none';
                        setTimeout(() => {
                            postCard.remove();
                            // Cập nhật số lượng bài viết đã lưu
                            const badge = document.querySelector('.badge.bg-primary');
                            if (badge) {
                                const currentCount = parseInt(badge.textContent);
                                badge.textContent = Math.max(0, currentCount - 1);
                            }
                        }, 500);
                    }
                }
            } else {
                this.showAlert(data.message || 'Có lỗi xảy ra', 'danger');
            }
        } catch (error) {
            console.error('Error:', error);
            this.showAlert('Có lỗi xảy ra', 'danger');
        }
    }

    // Cập nhật trạng thái nút lưu
    updateSaveButton(btn, isSaved) {
        const icon = btn.querySelector('i');
        const text = btn.querySelector('span');

        if (isSaved) {
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('btn-primary', 'unsave-btn');
            btn.classList.remove('save-btn');
            icon.className = 'bi bi-bookmark-fill';
            btn.title = 'Bỏ lưu';
            // Chỉ cập nhật text nếu có span và không phải trong trang saved posts
            if (text && !window.location.pathname.includes('saved-posts')) {
                text.textContent = 'Đã lưu';
            }
        } else {
            btn.classList.remove('btn-primary', 'unsave-btn');
            btn.classList.add('btn-outline-primary', 'save-btn');
            icon.className = 'bi bi-bookmark';
            btn.title = 'Lưu';
            // Chỉ cập nhật text nếu có span và không phải trong trang saved posts
            if (text && !window.location.pathname.includes('saved-posts')) {
                text.textContent = 'Lưu';
            }
        }
    }

    // Cập nhật số lượt lưu
    updateSaveCount(postId, count) {
        const countElement = document.querySelector(`[data-save-count="${postId}"]`);
        if (countElement) {
            countElement.textContent = count;
        }
    }

    // Hiển thị tùy chọn chia sẻ
    showShareOptions(btn) {
        const postId = btn.dataset.postId;
        const postTitle = btn.dataset.postTitle || 'Bài viết';
        const postUrl = `${window.location.origin}/Mini-4/public/post/${postId}`;

        // Tạo dropdown menu
        const dropdown = document.createElement('div');
        dropdown.className = 'dropdown-menu show';
        dropdown.style.position = 'absolute';
        dropdown.style.zIndex = '1000';

        const shareOptions = [
            { type: 'facebook', icon: 'bi-facebook', name: 'Facebook', color: 'text-primary' },
            { type: 'twitter', icon: 'bi-twitter', name: 'Twitter', color: 'text-info' },
            { type: 'linkedin', icon: 'bi-linkedin', name: 'LinkedIn', color: 'text-primary' },
            { type: 'email', icon: 'bi-envelope', name: 'Email', color: 'text-success' },
            { type: 'copy_link', icon: 'bi-link-45deg', name: 'Copy Link', color: 'text-secondary' }
        ];

        shareOptions.forEach(option => {
            const item = document.createElement('a');
            item.className = 'dropdown-item';
            item.href = '#';
            item.innerHTML = `<i class="bi ${option.icon} ${option.color}"></i> ${option.name}`;
            item.addEventListener('click', (e) => {
                e.preventDefault();
                this.sharePost(postId, option.type, postTitle, postUrl);
                dropdown.remove();
            });
            dropdown.appendChild(item);
        });

        // Thêm vào DOM
        btn.parentNode.style.position = 'relative';
        btn.parentNode.appendChild(dropdown);

        // Đóng dropdown khi click ngoài
        document.addEventListener('click', function closeDropdown(e) {
            if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
                dropdown.remove();
                document.removeEventListener('click', closeDropdown);
            }
        });
    }

    // Chia sẻ bài viết
    async sharePost(postId, shareType, postTitle, postUrl) {
        // Ghi lại lượt chia sẻ
        try {
            await fetch('/Mini-4/public/post/share', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `post_id=${postId}&share_type=${shareType}`
            });
        } catch (error) {
            console.error('Error recording share:', error);
        }

        // Thực hiện chia sẻ
        switch (shareType) {
            case 'facebook':
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(postUrl)}`, '_blank');
                break;
            case 'twitter':
                window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(postTitle)}&url=${encodeURIComponent(postUrl)}`, '_blank');
                break;
            case 'linkedin':
                window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(postUrl)}`, '_blank');
                break;
            case 'email':
                window.open(`mailto:?subject=${encodeURIComponent(postTitle)}&body=${encodeURIComponent(`Xem bài viết tại: ${postUrl}`)}`, '_blank');
                break;
            case 'copy_link':
                navigator.clipboard.writeText(postUrl).then(() => {
                    this.showAlert('Đã copy link bài viết!', 'success');
                }).catch(() => {
                    this.showAlert('Không thể copy link', 'danger');
                });
                break;
        }

        this.showAlert(`Đã chia sẻ bài viết qua ${this.getShareTypeName(shareType)}`, 'success');
    }

    // Lấy tên loại chia sẻ
    getShareTypeName(shareType) {
        const names = {
            'facebook': 'Facebook',
            'twitter': 'Twitter',
            'linkedin': 'LinkedIn',
            'email': 'Email',
            'copy_link': 'Copy Link'
        };
        return names[shareType] || 'Chia sẻ';
    }

    // Hiển thị thông báo
    showAlert(message, type) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        alertDiv.style.top = '20px';
        alertDiv.style.right = '20px';
        alertDiv.style.zIndex = '9999';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(alertDiv);

        // Tự động ẩn sau 3 giây
        setTimeout(() => {
            alertDiv.remove();
        }, 3000);
    }

    // Lấy trạng thái lưu của bài viết
    async getSaveStatus(postId) {
        try {
            const response = await fetch(`/Mini-4/public/post/save-status?post_id=${postId}`);
            const data = await response.json();
            
            if (data.success) {
                this.updateSaveButtonByPostId(postId, data.saved);
                this.updateSaveCount(postId, data.save_count);
            }
        } catch (error) {
            console.error('Error getting save status:', error);
        }
    }

    // Cập nhật nút lưu theo post ID
    updateSaveButtonByPostId(postId, isSaved) {
        const btn = document.querySelector(`[data-post-id="${postId}"]`);
        if (btn) {
            this.updateSaveButton(btn, isSaved);
        }
    }
}

// Khởi tạo khi DOM load xong
document.addEventListener('DOMContentLoaded', function() {
    window.saveShareManager = new SaveShareManager();
});

// CSS để giới hạn kích thước nút
const saveShareStyle = document.createElement('style');
saveShareStyle.textContent = `
    .save-btn, .unsave-btn, .share-btn {
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
    
    /* Nút trong trang saved posts có text */
    .saved-posts .unsave-btn {
        width: auto !important;
        max-width: none !important;
        padding: 0.375rem 0.75rem !important;
    }
    
    .save-btn i, .unsave-btn i, .share-btn i {
        font-size: 0.875rem !important;
    }
    
    .save-btn:hover, .unsave-btn:hover, .share-btn:hover {
        transform: scale(1.02) !important;
    }
`;
document.head.appendChild(saveShareStyle);

