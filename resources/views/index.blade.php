@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/top.css') }}">
@endpush

@section('content')
<div id="top">
    <div class="sc-hero">
        <div class="bg">
            <picture>
                <source media="(max-width: 767px)" srcset="{{ asset('images/top_hero_sp.jpg') }}">
                <source media="(min-width: 768px)" srcset="{{ asset('images/top_hero_pc.jpg') }}">
                <img src="{{ asset('images/top_hero_pc.jpg') }}" alt="Hero">
            </picture>
        </div>
        <div class="container">
            <div class="hero-container">
                <p class="tag-block white">Tìm việc làm miễn phí</p>
                <h1 class="title">Mintoku Work Vietnam là trang web <br />tìm kiếm việc làm miễn phí tại Việt Nam.</h1>
                <x-job-search />
            </div>
        </div>
    </div>

    <div class="sc-jobs">
        <div class="container">
            <div class="jobs-inner">
                <h2 class="tag-block orange">Việc làm mới</h2>
                <div class="jobs-list">
                    @foreach ($latestJobs as $job)
                    <x-job-small :job="$job" />
                    @endforeach
                </div>
                <a href="{{ route('jobs.index') }}" class="more">Xem thêm</a>
            </div>
        </div>
    </div>

    <div class="sc-about">
        <div class="bg">
            <picture>
                <source media="(max-width: 767px)" srcset="{{ asset('images/top_about_bg_sp.jpg') }}">
                <source media="(min-width: 768px)" srcset="{{ asset('images/top_about_bg_pc.jpg') }}">
                <img src="{{ asset('images/top_about_bg_pc.jpg') }}" alt="About mintoku work vietnam">
            </picture>
        </div>
        <div class="container">
            <div class="about-container">
                <div class="data">
                    <h2 class="tag-block black">Về mintoku work vietnam</h2>
                    <div class="logo">
                        <picture>
                            <source srcset="{{ asset('images/logo.png') }}">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo Mintoku">
                        </picture>
                    </div>
                    <span class="sub-title">Cơ hội hiếm có × Hỗ trợ theo tiêu chuẩn Nhật Bản </span>
                    <h3 class="title">Tìm việc tại Việt Nam, <br>hãy chọn “mintoku work vietnam”</h3>
                    <p class="text">
                        Mintoku work Vietnam là trang web tận dụng mạng lưới kinh doanh để tổng hợp và đăng tải những cơ
                        hội việc làm độc quyền. Cơ hội việc làm hiếm có chỉ có tại đây - từ thực tập sinh cho tới kỹ
                        năng đặc định, đều không có trên các trang tuyển dụng lớn. Bạn có thể tìm thấy cơ hội nghề
                        nghiệp phù hợp và trao đổi với chúng tôi dễ dàng qua Messenger. An tâm tìm việc theo nhu cầu của bạn.
                    </p>
                </div>
                <div class="images">
                    <div class="img">
                        <picture>
                            <source media="(max-width: 767px)" srcset="{{ asset('images/top_about_01_sp.jpg') }}">
                            <source media="(min-width: 768px)" srcset="{{ asset('images/top_about_01_pc.jpg') }}">
                            <img class="person" src="{{ asset('images/top_about_01_pc.jpg') }}" alt="About 01">
                        </picture>
                        <img src="{{ asset('images/icon_01.png') }}" alt="Icon 01" class="icon">
                    </div>

                    <div class="img">
                        <picture>
                            <source media="(max-width: 767px)" srcset="{{ asset('images/top_about_02_sp.jpg') }}">
                            <source media="(min-width: 768px)" srcset="{{ asset('images/top_about_02_pc.jpg') }}">
                            <img class="person" src="{{ asset('images/top_about_02_pc.jpg') }}" alt="About 02">
                        </picture>
                        <img src="{{ asset('images/icon_02.png') }}" alt="Icon 02" class="icon">
                    </div>

                    <div class="img">
                        <picture>
                            <source media="(max-width: 767px)" srcset="{{ asset('images/top_about_03_sp.jpg') }}">
                            <source media="(min-width: 768px)" srcset="{{ asset('images/top_about_03_pc.jpg') }}">
                            <img class="person" src="{{ asset('images/top_about_03_pc.jpg') }}" alt="About 03">
                        </picture>
                        <img src="{{ asset('images/icon_03.png') }}" alt="Icon 03" class="icon">
                    </div>
                </div>
                <div class="button">
                    <a href="{{ route('about') }}" title="Xem thêm" class="btn-link">Xem thêm</a>
                </div>
            </div>
        </div>
    </div>
    <div class="sc-contact">
        <div class="bg">
            <picture>
                <source media="(max-width: 767px)" srcset="{{ asset('images/top_contact_sp.png') }}">
                <source media="(min-width: 768px)" srcset="{{ asset('images/top_contact_pc.png') }}">
                <img src="{{ asset('images/top_contact_pc.png') }}" alt="Contact Background">
            </picture>
        </div>
        <div class="container">
            <div class="contact-inner">
                <h2 class="tag-block white">Liên hệ</h2>
                <div>
                    <h3 class="title">Mọi thắc mắc về việc làm và ứng tuyển, nhắn cho chúng tôi qua Messenger!</h3>
                    <p class="text">
                        Mọi thắc mắc về tuyển dụng và cách thức ứng tuyển sẽ được nhân viên hỗ trợ chi nhánh
                        Việt Nam giải đáp qua Messenger. Dù là vấn đề nhỏ, hãy thoải mái trao đổi với chúng tôi. Chúng
                        tôi sẽ phản hồi trong vòng 24 giờ.
                    </p>
                    <a href="{{ route('contact') }}" title="Liên hệ" class="btn-link hover">Liên hệ</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection