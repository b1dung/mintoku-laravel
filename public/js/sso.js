					const CV_DOMAIN = "http://127.0.0.1:8000";
					document.addEventListener("DOMContentLoaded", function() {
						if (localStorage.getItem('cv_logged_in') === 'true') {
							showLoggedInHeader();
						}
					});

					function openCvPopup(action) {
    const modal = document.getElementById('cv-modal');
    const iframe = document.getElementById('cv-iframe');
    const modalContent = modal.querySelector('.cv-modal-content');
    const jobId = jQuery('#current_job_id').val() || ''; 

    modalContent.classList.remove('apply-cv', 'profile');

    let url = '';
    if (action === 'login' || action === 'apply') {
        url = `${CV_DOMAIN}/apply-flow?job_id=${jobId}`;
        modalContent.classList.add('apply-cv');
    } else if (action === 'profile') {
        url = `${CV_DOMAIN}/profile/edit`;
        modalContent.classList.add('profile');
    }

    iframe.src = url;
    modal.style.display = 'flex';
}

function closeCvPopup() {
    const modal = document.getElementById('cv-modal');
    const iframe = document.getElementById('cv-iframe');
    modal.style.display = 'none';
    iframe.src = '';
}

					function handleCvLogout() {
						localStorage.removeItem('cv_logged_in');
						const img = new Image();
						img.src = `${CV_DOMAIN}/logout`; 
						window.location.reload();
					}

					function showLoggedInHeader() {
						document.getElementById('group-logged-in').style.display = 'flex';
					}

					window.addEventListener("message", function(event) {		 
						if (event.origin !== CV_DOMAIN) return;
													 	
						if (event.data.type === 'SSO_LOGIN_SUCCESS') {
							localStorage.setItem('cv_logged_in', 'true');
							localStorage.setItem('mtk_auth_token', data.token);
							localStorage.setItem('mtk_user_email', data.user.email);
							localStorage.setItem('mtk_token_expires', data.expires_at);
							showLoggedInHeader();
						}
						if (event.data.type === 'APPLY_SUCCESS') {
							document.getElementById('cv-modal').style.display = 'none';
						}
					});

												  function showCvLoggedInButtons() {
    const groupGuest = document.getElementById('group-guest');
    const groupLoggedIn = document.getElementById('group-logged-in');
    
    if (groupGuest && groupLoggedIn) {
        groupLoggedIn.style.setProperty('display', 'flex', 'important');
    }
}

document.addEventListener("DOMContentLoaded", function() {
    if (localStorage.getItem('cv_logged_in') === 'true') {
        showCvLoggedInButtons();
    }
});
																	 window.addEventListener("message", function(event) {
    if (event.origin !== CV_DOMAIN) return;

    const modal = document.getElementById('cv-modal');
    const modalContent = modal.querySelector('.cv-modal-content');

    if (event.data.type === 'PAGE_NAVIGATION') {
        const pageType = event.data.page_type;
        if (pageType === 'profile') {
            modalContent.classList.remove('apply-cv');
            modalContent.classList.add('profile');
        } else {
            modalContent.classList.remove('profile');
            modalContent.classList.add('apply-cv');
        }
    }
});