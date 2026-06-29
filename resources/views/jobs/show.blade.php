@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/single.css') }}">
<div id="single">
    <section class="sc-banner">
        <div class="bg">
            <picture>
                <source media="(max-width: 767px)" srcset="{{ asset('images/single_banner_sp.jpg') }}">
                <source media="(min-width: 768px)" srcset="{{ asset('images/single_banner_pc.jpg') }}">
                <img src="{{ asset('images/single_banner_pc.jpg') }}" alt="Banner">
            </picture>
        </div>
        <div class="container banner-container">
            <p class="tag-block white">Tìm việc làm miễn phí</p>
            <x-job-search />
        </div>
    </section>
    @include('partials.breadcrumb')
    <section class="sc-job">
        <div class="container">
            <x-job-medium :job="$job" />
        </div>
    </section>
    <section class="sc-actions">
        <div class="container actions-container">
            <div id="cv-auth-group">
                <a onclick="openCvPopup('login',{{$job->id}})" title="Ứng tuyển ngay" class="btn-apply link orange">Ứng tuyển ngay</a>
            </div>
            <a href="https://m.me/331141913426390?ref=fb_lp_id&utm_source=lp&utm_medium=banner&utm_campaign=mintokuvn" class="link blue">Ứng tuyển qua Messenger</a>
        </div>
    </section>
    <section class="sc-content">
        <div class="tabs">
            <span class="tab">Thông tin tuyển dụng</span>
        </div>
        <div class="container">
            <div class="content-container">
                @if($highlight = $job->get_field('highlight'))
                <div class="group">
                    <h3 class="title">Điểm nổi bật</h3>
                    <div class="text">{!! $highlight !!}</div>
                </div>
                @endif
                @if($description = $job->get_field('description'))
                <div class="group">
                    <h3 class="title">Nội dung công việc </h3>
                    <p class="text">{!! $description !!}</p>
                </div>
                @endif
                <div class="group">
                    <h3 class="title">Yêu cầu ứng tuyển</h3>
                    @if($appReq = $job->get_field('requirements'))
                    <div class="text">{!! $appReq !!}</div>
                    @endif
                    @if($require = $job->get_field('require'))
                    <dl class="grid">
                        <dt class="bold">Yêu cầu</dt>
                        <dd class="text">{{ $require }}</dd>
                    </dl>
                    @endif
                    @php $levels = $job->get_field('levels', []); @endphp
                    @if(!empty($levels))
                    <dl class="grid">
                        <dt class="bold">Level</dt>
                        <dd class="text">
                            @foreach ($levels as $level)
                            <span>{{ $level['title'] ?? '' }}</span>
                            @if(!empty($level['note']))
                            <span class="note">({{ $level['note'] }})</span>
                            @endif
                            <br>
                            @endforeach
                        </dd>
                    </dl>
                    @endif
                    @php $require_others = $job->get_field('require_others', []); @endphp
                    @if(!empty($require_others))
                    <dl class="grid">
                        <dt class="bold">Yêu cầu khác・Có thể áp dụng</dt>
                        <dd class="text">
                            <ul>
                                @foreach ($require_others as $other)
                                <li>
                                    {{ $other['title'] ?? '' }}
                                    @if(!empty($other['note']))
                                    <span class="note">({{ $other['note'] }})</span>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                        </dd>
                    </dl>
                    @endif
                </div>
                <div class="group">
                    <h3 class="title">Mô tả</h3>
                    @if($overview = $job->get_field('overview_description'))
                    <p class="text">{!! $overview !!}</p>
                    @endif
                    @if($empType = $job->get_field('type_of_employment'))
                    <dl class="grid">
                        <dt class="bold">Hình thức tuyển dụng</dt>
                        <dd class="text">{{ $empType }}</dd>
                    </dl>
                    @endif
                    @if($workBy = $job->get_field('work_by'))
                    <dl class="grid">
                        <dt class="bold">Vị trí</dt>
                        <dd class="text">{{ $workBy }}</dd>
                    </dl>
                    @endif
                    @if($workingTime = $job->get_field('working_time'))
                    <dl class="grid">
                        <dt class="bold">Thời gian làm việc</dt>
                        <dd class="text">{{ $workingTime }}</dd>
                    </dl>
                    @endif
                    @if($workAddress = $job->get_field('work_address'))
                    <dl class="grid">
                        <dt class="bold">Địa điểm làm việc</dt>
                        <dd class="text">{{ $workAddress }}</dd>
                    </dl>
                    @endif
                    @if($circulate = $job->get_field('circulate'))
                    <dl class="grid">
                        <dt class="bold">Đi lại</dt>
                        <dd class="text">{{ $circulate }}</dd>
                    </dl>
                    @endif
                    <dl class="grid">
                        <dt class="bold">Mức lương</dt>
                        <dd class="text">
                            {{ $job->get_field('by_level_salary') }}
                            @php
                            $salary_val = $job->get_field('salary_by_month');
                            if (is_numeric($salary_val)) {
                            echo number_format((float)$salary_val);
                            } else {
                            echo $salary_val;
                            }
                            @endphp
                            {{ strtoupper($job->get_field('unit_salary')) }}
                        </dd>
                    </dl>
                    @if($holiday = $job->get_field('annual_holiday'))
                    <dl class="grid">
                        <dt class="bold">Ngày nghỉ・Phép</dt>
                        <dd class="text">{!!$holiday!!}</dd>
                    </dl>
                    @endif
                    @if($salaryOthers = $job->get_field('salary_other_conditions'))
                    <dl class="grid">
                        <dt class="bold">Tăng lương・Thưởng</dt>
                        <dd class="text">{{ $salaryOthers }}</dd>
                    </dl>
                    @endif
                    @if($benefits = $job->get_field('benefits_allowances'))
                    <dl class="grid">
                        <dt class="bold">Quyền lợi・Trợ cấp</dt>
                        <dd class="text">{!! $benefits !!}</dd>
                    </dl>
                    @endif
                    @php $insurances = $job->get_field('insurances', []); @endphp
                    @if(!empty($insurances))
                    <dl class="grid">
                        <dt class="bold">Bảo hiểm</dt>
                        <dd class="text">
                            @foreach ($insurances as $ins)
                            {{ $ins['title'] ?? '' }}
                            @if(!empty($ins['note']))
                            <span class="note">({{ $ins['note'] }})</span>
                            @endif
                            @endforeach
                        </dd>
                    </dl>
                    @endif
                </div>
                @if($job->company)
                <div class="group">
                    <h3 class="title">Thông tin nhà tuyển dụng</h3>
                    <div class="text">
                        {!! nl2br(e($job->company->description ?? '')) !!}
                    </div>
                    <dl class="grid">
                        <dt class="bold">Tên công ty</dt>
                        <dd class="text">{{ $job->company->name }}</dd>
                    </dl>
                    @if($compAddress = $job->company->get_field('address'))
                    <dl class="grid">
                        <dt class="bold">Địa chỉ</dt>
                        <dd class="text">{{ $compAddress }}</dd>
                    </dl>
                    @endif
                </div>
                @endif
                <div class="group">
                    <h3 class="title">Cách thức ứng tuyển</h3>
                    @if($appMethod = $job->get_field('application_method'))
                    <p class="text">{!! nl2br(e($appMethod)) !!}</p>
                    @endif
                    <dl class="grid">
                        <dt class="bold">Cách ứng tuyển</dt>
                        <dd class="text">Nhấn vào nút "Ứng tuyển" để truy cập vào Messenger, nhân viên của chúng tôi sẽ trả lời bạn!</dd>
                    </dl>
                    <dl class="grid">
                        <dt class="bold">Quy trình </dt>
                        <dd class="text">
                            [Tuyển chọn hồ sơ]<br />
                            Dựa trên dữ liệu ứng tuyển, những ứng viên đủ điều kiện sẽ được thông báo về lịch trình xét tuyển tiếp theo.
                            <span class="note">Chúng tôi sẽ liên lạc với bạn qua email hoặc điện thoại để trao đổi về quy trình sau khi ứng tuyển
                                (Nếu có thắc mắc vui lòng trao đổi với nhân viên qua Messenger)</span>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </section>
    @if($relatedJobs && $relatedJobs->count() > 0)
    <section id="relate" class="sc-relate">
        <div class="relate-container">
            <div class="container">
                <h2 class="title">VIỆC LÀM DÀNH CHO BẠN</h2>
            </div>
            <div class="relate-swiper swiper">
                <div class="swiper-wrapper">
                    @foreach($relatedJobs as $rJob)
                    <div class="swiper-slide">
                        <x-job-small :job="$rJob" />
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif
</div>
<div id="cv-modal" class="cv-modal-wrapper" style="display:none;">
    <div class="cv-modal-overlay" onclick="closeCvPopup()"></div>
    <div class="cv-modal-content">
        <button onclick="closeCvPopup()" class="cv-modal-close">✕</button>
        <iframe id="cv-iframe" src="" frameborder="0"></iframe>
    </div>
</div>
<style>
    .cv-modal-wrapper {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cv-modal-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(4px);
    }

    .cv-modal-content {
        position: relative;
        width: 95%;
        max-width: 500px;
        height: 85vh;
        background: #fff;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        animation: slideUp 0.3s ease-out;
    }

    .cv-modal-content.profile {
        max-width: 1200px;
    }

    #cv-iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    .cv-modal-close {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 100;
        background: #fff;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #eee;
        cursor: pointer;
        color: #666;
        transition: all 0.2s;
    }

    .cv-modal-close:hover {
        background: #f3f4f6;
        color: #000;
        transform: rotate(90deg);
    }

    @keyframes slideUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    #group-logged-in {
        gap: 15px;
    }

    #group-logged-in .logout {
        background: #0172AF;
    }
</style>
@endsection