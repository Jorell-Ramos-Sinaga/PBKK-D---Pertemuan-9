/**
 * ToyTopia - Client-side JavaScript
 * Interaksi ringan untuk tombol kuantitas, preview gambar, dan konfirmasi.
 */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Tombol Tambah/Kurang Jumlah (Quantity +/-)
    const qtyInputs = document.querySelectorAll('.qty-input-group');
    qtyInputs.forEach(group => {
        const btnMinus = group.querySelector('.btn-qty-minus');
        const btnPlus = group.querySelector('.btn-qty-plus');
        const input = group.querySelector('input[type="number"]');

        if (btnMinus && btnPlus && input) {
            btnMinus.addEventListener('click', function () {
                let currentVal = parseInt(input.value) || 1;
                const min = parseInt(input.min) || 1;
                if (currentVal > min) {
                    input.value = currentVal - 1;
                    input.dispatchEvent(new Event('change'));
                }
            });

            btnPlus.addEventListener('click', function () {
                let currentVal = parseInt(input.value) || 1;
                const max = parseInt(input.max) || 9999;
                if (currentVal < max) {
                    input.value = currentVal + 1;
                    input.dispatchEvent(new Event('change'));
                }
            });
        }
    });

    // 2. Konfirmasi tombol hapus dengan class .btn-delete-confirm
    const deleteButtons = document.querySelectorAll('.btn-delete-confirm');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            const message = btn.getAttribute('data-confirm') || 'Apakah Anda yakin ingin menghapus data ini?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // 3. Image Upload Preview
    const imageUploadInputs = document.querySelectorAll('.image-upload-preview');
    imageUploadInputs.forEach(input => {
        input.addEventListener('change', function () {
            const targetPreviewId = input.getAttribute('data-preview-target');
            const previewImg = document.getElementById(targetPreviewId);
            if (previewImg && input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    });
});

