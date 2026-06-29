<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('favicon.ico') }}" sizes="180x180">
    {!! $seoTags ?? seo($seoData) !!}
    @php
    $currentModel = $job ?? $post ?? $page ?? null;
    @endphp
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    @stack('styles')
    @if($currentModel && method_exists($currentModel, 'getJobSchema'))
    <script type="application/ld+json">
        {
            !!json_encode($currentModel - > getJobSchema(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!
        }
    </script>
    @endif
</head>

<body>
    <div id="wrapper">
        <header id="header">
            <div class="header-container">
                <a href="{{ url('/') }}" class="header-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" />
                </a>
                <div id="group-logged-in" style="display:none;">
                    <a href="javascript:void(0)" onclick="openCvPopup('profile')" class="btn-link cv">Hồ sơ của tôi</a>
                    <a href="javascript:void(0)" onclick="handleCvLogout()" class="btn-link logout">Đăng xuất</a>
                </div>
                <div class="toggle-menu"><span class="line"></span></div>
            </div>
            <div class="menu">
                <nav class="nav">
                    <a href="{{ route('jobs.index') }}" class="link">Danh sách công việc</a>
                    <a href="{{ route('contact') }}" class="link">Liên hệ với chúng tôi</a>
                    <a href="{{ route('about') }}" class="link">Về chúng tôi</a>
                </nav>
            </div>
        </header>

        <main id="main">
            @yield('content')
        </main>

        <footer id="footer">
            <div class="footer-container">
                <a href="{{ url('/') }}" class="footer-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" />
                </a>
                <div class="footer-links">
                    <ul class="navMenu">
                        <li class="menu-item"><a href="https://vietnam-camcom.com/vi/" title="Công ty" target="_blank"><span class="hover link">Công ty</span></a></li>
                        <li class="menu-item"><a href="{{route('privacy')}}"><span class="hover link">Chính sách quyền riêng tư</span></a></li>
                        <li class="menu-item"><a href="{{route('contact')}}"><span class="hover link">Liên hệ</span></a></li>
                    </ul>
                </div>
                <a href="https://www.facebook.com/MintokuWorkVietnam" class="fb-link" target="_blank">
                    <svg width="30" height="30" viewBox="0 0 0.6 0.6" xmlns="http://www.w3.org/2000/svg" fill="none">
                        <path fill="#1877F2" d="M0.563 0.3a0.263 0.263 0 0 0 -0.263 -0.263 0.263 0.263 0 0 0 -0.041 0.522v-0.183H0.192V0.3h0.067V0.242c0 -0.066 0.039 -0.102 0.099 -0.102 0.029 0 0.059 0.005 0.059 0.005v0.065h-0.033c-0.033 0 -0.043 0.02 -0.043 0.041V0.3h0.073l-0.012 0.076H0.341v0.183A0.263 0.263 0 0 0 0.563 0.3"></path>
                        <path fill="#fff" d="M0.402 0.376 0.414 0.3H0.341V0.251c0 -0.021 0.01 -0.041 0.043 -0.041h0.033V0.145s-0.03 -0.005 -0.059 -0.005c-0.06 0 -0.099 0.036 -0.099 0.102V0.3H0.192v0.076h0.067v0.183a0.263 0.263 0 0 0 0.082 0v-0.183z"></path>
                    </svg>
                </a>
            </div>
            <div class="copyright">© VIETNAM CAMCOM Co., Ltd</div>
        </footer>
    </div>

    <button id="back-to-top">
        <img src="{{ asset('images/backtop.png') }}" alt="Back to top" />
    </button>

    <div id="contact-fix">
        <img src="{{ asset('images/messenger-icon.png') }}" alt="Messenger" class="contact-fix-btn" />
        <div class="content">
            <h4 class="title">Hỗ trợ trực tuyến</h4>
            <a class="content-inner" href="https://m.me/331141913426390?ref=fb_lp_id&utm_source=lp&utm_medium=banner&utm_campaign=mintokuvn" target="_blank">
                <img src="{{ asset('images/messenger-person.png') }}" alt="Support Person" />
                <p class="text">
                    <span>Nhân viên Mintoku work vn</span><br />
                    Trả lời trong vòng 24h。
                </p>
            </a>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}" defer></script>
    <script src="{{ asset('js/select2.min.js') }}" defer></script>
    <script src="{{ asset('js/swiper-bundle.min.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    <script src="{{ asset('js/filter.js') }}" defer></script>
    <script>
        const CV_DOMAIN = "https://cv.mintoku.vn";

        function openCvPopup(action, jobId = null) {
            const modal = document.getElementById('cv-modal');
            const iframe = document.getElementById('cv-iframe');
            const loader = document.getElementById('cv-iframe-loader');

            if (!modal || !iframe) {
                console.error("Không tìm thấy modal hoặc iframe CV");
                return;
            }

            const modalContent = modal.querySelector('.cv-modal-content');
            let finalJobId = '';
            if (jobId) {
                finalJobId = jobId;
            } else {
                @if(isset($job))
                finalJobId = '{{ $job->extra_attributes['
                id_job '] ?? "" }}';
                @endif
            }
            modalContent.classList.remove('apply-cv', 'profile');

            let url = '';
            if (action === 'login' || action === 'apply') {
                url = `${CV_DOMAIN}/apply-flow?job_id=${finalJobId}`;
                modalContent.classList.add('apply-cv');
            } else if (action === 'profile') {
                url = `${CV_DOMAIN}/profile/edit`;
                modalContent.classList.add('profile');
            }
            if (loader) loader.classList.remove('cv-loader-hidden');

            iframe.src = url;
            modal.style.display = 'flex';

            const startTime = Date.now();
            iframe.onload = function() {
                const elapsed = Date.now() - startTime;
                const delay = Math.max(0, 800 - elapsed);
                setTimeout(() => {
                    if (loader) loader.classList.add('cv-loader-hidden');
                }, delay);
            };
        }

        function closeCvPopup() {
            const modal = document.getElementById('cv-modal');
            const iframe = document.getElementById('cv-iframe');
            if (modal) modal.style.display = 'none';
            if (iframe) iframe.src = '';
        }

        function handleCvLogout() {
            localStorage.removeItem('cv_logged_in');
            localStorage.removeItem('mtk_auth_token');
            localStorage.removeItem('mtk_user_email');
            localStorage.removeItem('mtk_token_expires');

            const returnUrl = encodeURIComponent(window.location.href);
            const logoutUrl = `${CV_DOMAIN}/sso-logout-bridge?redirect_to=${returnUrl}`;
            window.location.href = logoutUrl;
        }

        function showCvLoggedInButtons() {
            const groupLoggedIn = document.getElementById('group-logged-in');
            const groupLoggedOut = document.getElementById('group-logged-out');

            if (groupLoggedIn) groupLoggedIn.style.setProperty('display', 'flex', 'important');
            if (groupLoggedOut) groupLoggedOut.style.setProperty('display', 'none', 'important');
        }
        async function verifyTokenFromServer() {
            const token = localStorage.getItem('mtk_auth_token');
            const expiresAt = localStorage.getItem('mtk_token_expires');

            if (!token || !expiresAt) return false;
            if (new Date() > new Date(expiresAt)) return false;

            try {
                const response = await jQuery.ajax({
                    url: `${CV_DOMAIN}/sso/verify`,
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        token: token
                    },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    xhrFields: {
                        withCredentials: true
                    }
                });
                return response.success === true;
            } catch (error) {
                return false;
            }
        }
        window.addEventListener("message", function(event) {
            console.log(event);
            if (event.origin !== CV_DOMAIN) return;

            const data = event.data;
            if (data.type === 'SSO_LOGIN_SUCCESS') {
                localStorage.setItem('cv_logged_in', 'true');
                localStorage.setItem('mtk_auth_token', data.token);
                localStorage.setItem('mtk_user_email', data.user.email);
                localStorage.setItem('mtk_token_expires', data.expires_at);
                showCvLoggedInButtons();
            }
            if (data.type === 'APPLY_SUCCESS') {
                setTimeout(() => {
                    closeCvPopup();
                }, 2000);
            }
            if (data.type === 'PAGE_NAVIGATION') {
                const modal = document.getElementById('cv-modal');
                const modalContent = modal ? modal.querySelector('.cv-modal-content') : null;
                if (modalContent) {
                    if (data.page_type === 'profile') {
                        modalContent.classList.replace('apply-cv', 'profile');
                    } else {
                        modalContent.classList.replace('profile', 'apply-cv');
                    }
                }
            }
        });
        document.addEventListener("DOMContentLoaded", async function() {
            if (localStorage.getItem('cv_logged_in') === 'true') {
                const isValid = await verifyTokenFromServer();
                if (isValid) {
                    showCvLoggedInButtons();
                } else {
                    const groupLoggedIn = document.getElementById('group-logged-in');
                    if (groupLoggedIn) groupLoggedIn.style.display = 'none';
                }
            }
        });
    </script>
    @stack('scripts')
</body>

</html>