<div id="cv-modal" style="display:none;">
    <div class="cv-modal-overlay" onclick="closeCvPopup()"></div>
    <div class="cv-modal-content">
        <button class="cv-modal-close" onclick="closeCvPopup()">&times;</button>
        <iframe id="cv-iframe" src="" frameborder="0"></iframe>
    </div>
</div>

<script>
    function openCvPopup(type, jobId = '') {
        const modal = document.getElementById('cv-modal');
        const iframe = document.getElementById('cv-iframe');

        // Đường dẫn đến trang SSO hoặc trang tạo CV của bạn
        let url = `https://sso.mintoku.vn/${type}`;
        if (jobId) url += `?job_id=${jobId}`;

        iframe.src = url;
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeCvPopup() {
        const modal = document.getElementById('cv-modal');
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
</script>