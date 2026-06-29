@extends('layouts.app')

@section('content')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">

<style>
    [x-cloak] {
        display: none !important;
    }

    .fade-in {
        animation: fadeIn 0.4s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .error-text {
        color: red;
        font-size: 12px;
        display: block;
        margin-top: 5px;
    }

    .form-head .step.active {
        font-weight: bold;
        border-bottom: 2px solid #f39800;
    }

    input[readonly],
    textarea[readonly] {
        background-color: #f9f9f9 !important;
        border-color: #eee !important;
        color: #666 !important;
        cursor: not-allowed;
    }

    .wpcf7-submit {
        transition: all 0.3s ease;
        cursor: pointer;
        opacity: 1 !important;
    }

    .wpcf7-submit:disabled {
        background-color: #ccc !important;
        cursor: wait !important;
    }

    .spinner {
        animation: rotate 2s linear infinite;
        margin-right: 8px;
        width: 18px;
        height: 18px;
        vertical-align: middle;
    }

    @keyframes rotate {
        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes dash {
        0% {
            stroke-dasharray: 1, 150;
            stroke-dashoffset: 0;
        }

        50% {
            stroke-dasharray: 90, 150;
            stroke-dashoffset: -35;
        }

        100% {
            stroke-dasharray: 90, 150;
            stroke-dashoffset: -124;
        }
    }
</style>

<div id="contact" x-data="contactProcess()" x-cloak>
    <section class="sc-banner">
        <div class="bg">
            <picture>
                <source media="(max-width: 767px)" srcset="{{ asset('images/contact_banner_sp.jpg') }}">
                <source media="(min-width: 768px)" srcset="{{ asset('images/contact_banner_pc.jpg') }}">
                <img src="{{ asset('images/contact_banner_pc.jpg') }}" alt="Contact Banner">
            </picture>
        </div>
        <div class="container banner-container">
            <p class="tag-block white">Liên Hệ</p>
            <h1 class="title">Để biết thêm về đăng tin tuyển dụng và danh sách việc làm...</h1>
        </div>
    </section>

    <section class="sc-form">
        <div class="container">
            <div class="form-head">
                <span class="step step1" :class="step === 1 ? 'active' : ''">Điền thông tin</span>
                <span class="step step2" :class="step === 2 ? 'active' : ''">Xác nhận</span>
                <span class="step step3" :class="step === 3 ? 'active' : ''">Hoàn thành</span>
            </div>

            <div class="form-main">
                <form x-show="step < 3" @submit.prevent="nextStep" class="fade-in">
                    @csrf

                    <div class="line">
                        <label>Đối tượng <span class="require" x-show="step === 1">Bắt buộc</span></label>
                        <div class="group">
                            <span class="wpcf7-form-control-wrap">
                                <span class="wpcf7-form-control wpcf7-radio">
                                    <span class="wpcf7-list-item">
                                        <label>
                                            <input type="radio" value="individual" x-model="formData.subject_type" :disabled="step === 2">
                                            <span class="wpcf7-list-item-label">Cá nhân</span>
                                        </label>
                                    </span>
                                    <span class="wpcf7-list-item">
                                        <label>
                                            <input type="radio" value="company" x-model="formData.subject_type" :disabled="step === 2">
                                            <span class="wpcf7-list-item-label">Công ty</span>
                                        </label>
                                    </span>
                                </span>
                            </span>
                        </div>
                    </div>

                    <div class="line">
                        <label for="full_name">Họ và tên <span class="require" x-show="step === 1">Bắt buộc</span></label>
                        <div class="group">
                            <input type="text" x-model="formData.full_name" placeholder="Nguyen Van A" :readonly="step === 2">
                            <span class="error-text" x-show="errors.full_name" x-text="errors.full_name"></span>
                        </div>
                    </div>

                    <div class="line">
                        <label for="email">Email <span class="require" x-show="step === 1">Bắt buộc</span></label>
                        <div class="group">
                            <input type="email" x-model="formData.email" placeholder="sample@mail.com" :readonly="step === 2">
                            <span class="error-text" x-show="errors.email" x-text="errors.email"></span>
                        </div>
                    </div>

                    <div class="line">
                        <label for="phone">Điện thoại <span class="require" x-show="step === 1">Bắt buộc</span></label>
                        <div class="group">
                            <input type="tel" x-model="formData.phone" placeholder="0985.XXX.XXX" :readonly="step === 2">
                            <span class="error-text" x-show="errors.phone" x-text="errors.phone"></span>
                        </div>
                    </div>

                    <div class="line">
                        <label for="message">Nội dung <span class="require" x-show="step === 1">Bắt buộc</span></label>
                        <div class="group">
                            <textarea x-model="formData.message" rows="10" placeholder="Nhập nội dung..." :readonly="step === 2"></textarea>
                            <span class="error-text" x-show="errors.message" x-text="errors.message"></span>

                            <div class="accept">
                                <label>
                                    <input type="checkbox" x-model="formData.agreement" :disabled="step === 2">
                                    <span>Đồng ý với các điều khoản</span>
                                </label>
                                <span class="error-text" x-show="errors.agreement" x-text="errors.agreement"></span>
                            </div>
                        </div>
                    </div>

                    <div class="submit">
                        <button type="button" x-show="step === 2" @click="step = 1">
                            Quay lại
                        </button>
                        <button type="submit" class="wpcf7-form-control wpcf7-submit" :disabled="loading" style="display: flex; align-items: center; justify-content: center;">
                            <svg x-show="loading" class="spinner" viewBox="0 0 50 50" x-cloak>
                                <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5" stroke="#fff" stroke-linecap="round" style="stroke-dasharray: 1, 150; stroke-dashoffset: 0; stroke: currentColor; animation: dash 1.5s ease-in-out infinite;"></circle>
                            </svg>
                            <span x-text="loading ? 'Đang xử lý...' : (step === 1 ? 'Xác nhận' : 'Gửi đi ngay')"></span>
                        </button>
                    </div>
                </form>

                <div x-show="step === 3" class="fade-in step" id="thank-you">
                    <p class="text">Cảm ơn bạn đã liên hệ với chúng tôi. <br />
                        Chúng tôi đã gửi mail xác nhận nội dung nhập cho bạn vào địa chỉ email đã nhập, vui lòng kiểm tra hòm thư của bạn.<br />
                        Sau khi xác nhận nội dung, người phụ trách sẽ liên lạc với bạn.</p>
                    <a href="/" class="back">Trở về Trang chủ</a>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function contactProcess() {
        return {
            step: 1,
            loading: false,
            formData: {
                subject_type: 'individual',
                _token: '{{ csrf_token() }}',
                full_name: '',
                email: '',
                phone: '',
                message: '',
                agreement: false
            },
            errors: {},
            validate() {
                this.errors = {};
                if (!this.formData.full_name.trim()) this.errors.full_name = "Nhập họ tên.";
                if (!this.formData.email.includes('@')) this.errors.email = "Email sai định dạng.";

                const phoneRegex = /^[\d\.\-\+ ]+$/;
                if (!this.formData.phone.trim()) {
                    this.errors.phone = "Nhập số điện thoại.";
                } else if (!phoneRegex.test(this.formData.phone)) {
                    this.errors.phone = "Số điện thoại không hợp lệ.";
                }

                if (!this.formData.message.trim()) this.errors.message = "Nhập nội dung.";
                if (!this.formData.agreement) this.errors.agreement = "Cần đồng ý điều khoản.";
                return Object.keys(this.errors).length === 0;
            },
            async nextStep() {
                if (this.step === 1 && this.validate()) {
                    this.step = 2;
                    window.scrollTo({
                        top: 350,
                        behavior: 'smooth'
                    });
                } else if (this.step === 2) {
                    this.loading = true;
                    try {
                        const response = await fetch('{{ route("contact.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(this.formData)
                        });
                        if (response.ok) {
                            this.step = 3;
                            window.scrollTo({
                                top: 350,
                                behavior: 'smooth'
                            });
                        } else {
                            const err = await response.json();
                            alert(err.message || 'Lỗi gửi mail.');
                        }
                    } catch (e) {
                        alert('Lỗi kết nối.');
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    }
</script>
@endsection