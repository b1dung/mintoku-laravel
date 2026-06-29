@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/about.css') }}">
@endpush

@section('content')
<div id="about">
    <section class="sc-banner">
        <div class="bg">
            <picture>
                <source media="(max-width: 767px)" srcset="{{ asset('images/about_banner_sp.jpg') }}">
                <source media="(min-width: 768px)" srcset="{{ asset('images/about_banner_pc.jpg') }}">
                <img src="{{ asset('images/about_banner_pc.jpg') }}" alt="About Banner">
            </picture>
        </div>
        <div class="container banner-container">
            <p class="tag-block white">Về Mintoku Work Vietnam</p>
            <h1 class="title">Nếu bạn muốn tìm kiếm một công việc tại Việt Nam,<br /> hãy truy cập Mintoku Work Vietnam! </h1>
        </div>
    </section>

    @include('partials.breadcrumb')
    <section class="sc-feature">
        <div class="container">
            <h2 class="tag-block black">Đặc điểm công việc</h2>
            <div class="grid">
                <div class="item">
                    <img src="{{ asset('images/icon_01.png') }}" alt="icon" class="icon">
                    <div class="item-inner">
                        <div class="img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{ asset('images/about_feature_01_sp.jpg') }}">
                                <source media="(min-width: 768px)" srcset="{{ asset('images/about_feature_01_pc.jpg') }}">
                                <img src="{{ asset('images/about_feature_01_pc.jpg') }}" alt="Rare Job">
                            </picture>
                        </div>
                        <div class="data">
                            <h3 class="title">RARE JOB</h3>
                            <p class="text">Đăng tin tuyển dụng khó kiếm ở các trang lớn！</p>
                        </div>
                    </div>
                </div>
                {{-- Lặp lại cấu trúc tương tự cho các item 02, 03, 04 --}}
                <div class="item">
                    <img src="{{ asset('images/icon_02.png') }}" alt="icon" class="icon">
                    <div class="item-inner">
                        <div class="img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{ asset('images/about_feature_02_sp.jpg') }}">
                                <source media="(min-width: 768px)" srcset="{{ asset('images/about_feature_02_pc.jpg') }}">
                                <img src="{{ asset('images/about_feature_02_pc.jpg') }}" alt="Internship">
                            </picture>
                        </div>
                        <div class="data">
                            <h3 class="title">Internship</h3>
                            <p class="text">Bài đăng tuyển thực tập sinh khó thấy ở các công ty khác！</p>
                        </div>
                    </div>
                </div>
                {{-- ... (Các item 03 và 04 chuyển đổi tương tự bằng asset()) --}}
                <div class="item">
                    <img src="{{ asset('images/icon_03.png') }}" alt="icon" class="icon">
                    <div class="item-inner">
                        <div class="img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{ asset('images/about_feature_03_sp.jpg') }}">
                                <source media="(min-width: 768px)" srcset="{{ asset('images/about_feature_03_pc.jpg') }}">
                                <img src="{{ asset('images/about_feature_03_pc.jpg') }}" alt="Original Job">
                            </picture>
                        </div>
                        <div class="data">
                            <h3 class="title">mintoku <br />Original Job</h3>
                            <p class="text">Đăng thông tin tuyển dụng độc quyền của Mintoku！</p>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <img src="{{ asset('images/icon_04.png') }}" alt="icon" class="icon">
                    <div class="item-inner">
                        <div class="img">
                            <picture>
                                <source media="(max-width: 767px)" srcset="{{ asset('images/about_feature_04_sp.jpg') }}">
                                <source media="(min-width: 768px)" srcset="{{ asset('images/about_feature_04_pc.jpg') }}">
                                <img src="{{ asset('images/about_feature_04_pc.jpg') }}" alt="Questions">
                            </picture>
                        </div>
                        <div class="data">
                            <h3 class="title">Got Questions? <br />Just Ask!</h3>
                            <p class="text">Sẵn sàng giải đáp bất kỳ thắc mắc nào！</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="sc-industry">
        <div class="container">
            <h2 class="tag-block black">Chúng tôi cung cấp nhiều loại công việc khác nhau, tập trung vào các ngành công nghiệp phổ biến.</h2>
            <p class="desc">Mintoku Work Vietnam – Nơi đăng tải cơ hội việc làm đa ngành nghề!</p>
            <div class="content">
                @php
                $industries = [
                ['id' => '04', 'title' => 'IT Engineer', 'text' => 'Đa dạng công việc trong lĩnh vực IT như phát triển phần mềm, quản lý mạng lưới, phân tích dữ liệu,... Phát huy kỹ năng kỹ thuật – Thăng tiến sự nghiệp trong môi trường tiên tiến'],
                ['id' => '01', 'title' => 'Business Sales', 'text' => 'Từ B2B sales tới Marketing, chúng tôi đăng tải nhiều tin tuyển dụng trong lĩnh vực kinh doanh. Phát huy khả năng đàm phán và khả năng giao tiếp - Mở rộng cơ hội việc làm!'],
                ['id' => '03', 'title' => 'Interpreter', 'text' => 'Nhiều công việc sử dụng tiếng Nhật hoặc tiếng Anh. Nâng cao khả năng biên phiên dịch trong các bối cảnh đàm phán kinh doanh, du lịch, giáo dục.'],
                ['id' => '02', 'title' => 'Factory Worker', 'text' => 'Cơ hội việc làm trong ngành sản xuất, chế biến, lắp ráp linh kiện điện tử tại các nhà máy. Môi trường làm việc ổn định, có nhiều công việc phù hợp ngay cả với những người chưa có kinh nghiệm.'],
                ];
                @endphp

                @foreach($industries as $key => $item)
                <div class="group group{{ $key + 1 }}">
                    <div class="image">
                        <picture>
                            <source srcset="{{ asset('images/job_'.$item['id'].'.png') }}">
                            <img src="{{ asset('images/job_'.$item['id'].'.png') }}" alt="{{ $item['title'] }}">
                        </picture>
                        <h3 class="title">{{ $item['title'] }}</h3>
                    </div>
                    <div class="data">
                        <p class="text">{{ $item['text'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="sc-voice">
        <div class="container">
            <h2 class="tag-block black">Đánh giá từ khách hàng</h2>
            <div class="content">
                @php
                $voices = [
                'Mintoku là lựa chọn đúng đắn khi tôi có thể tìm thấy những tin tuyển dụng không có ở các trang tuyển dụng lớn',
                'Tôi từng gặp khó khăn khi tìm việc ở Việt Nam, nhưng nhờ Mintoku mà tôi đã có công việc mới!',
                'Quy trình ứng tuyển đơn giản, phù hợp với cả những người lần đầu sử dụng!',
                'Sau khi liên hệ qua Messenger thì tôi được phản hồi rất nhanh và có thể ứng tuyển trực tiếp!',
                'Có nhiều tin tuyển dụng không yêu cầu sơ yếu lý lịch nên rất tiện!',
                'Tôi tìm thấy một công việc thực tập và đã ứng tuyển ngay. Rất vui vì có những công việc để sinh viên có thể dễ dàng thử sức!',
                ];
                @endphp
                @foreach($voices as $index => $voice)
                <div class="group">
                    <div class="img">
                        <picture>
                            <source srcset="{{ asset('images/about_voice_0'.($index+1).'.png') }}">
                            <img src="{{ asset('images/about_voice_0'.($index+1).'.png') }}" alt="Customer Voice">
                        </picture>
                    </div>
                    <div class="data">
                        <p class="text">{{ $voice }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="sc-step">
        <div class="container">
            <h2 class="tag-block black">Các bước ứng dụng dễ dàng với mintoku work vietnam.</h2>
            <div class="content">
                @php
                $steps = ['Tìm công việc bạn quan tâm', 'Kiểm tra chi tiết công việc', 'Ứng tuyển qua Messenger', 'Xác nhận trực tiếp'];
                @endphp
                @foreach($steps as $index => $step)
                <div class="group group{{ $index+1 }}">
                    <span class="step">STEP.{{ $index+1 }}</span>
                    <div class="img">
                        <img src="{{ asset('images/step_0'.($index+1).'.png') }}" alt="Step {{ $index+1 }}">
                    </div>
                    <div class="data">
                        <p class="text">{{ $step }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="sc-faq">
        <div class="container">
            <h2 class="tag-block black">Câu hỏi thường gặp</h2>
            <div class="content">
                <dl class="group">
                    <dt class="ques box"><span class="span">Q1.</span> Có thể ứng tuyển công việc trên Mintoku miễn phí không?</dt>
                    <dd class="ans box"><span class="span">A1.</span> Vâng, toàn bộ đều có thể ứng tuyển miễn phí。Bạn có thể ứng tuyển dễ dàng thông qua Messenger, vì vậy hãy liên hệ về công việc bạn quan tâm!</dd>
                </dl>
                {{-- Chuyển đổi các Q2, Q3, Q4 tương tự --}}
                <dl class="group">
                    <dt class="ques box"><span class="span">Q2.</span> Có cần sơ yếu lý lịch khi ứng tuyển không?</dt>
                    <dd class="ans box"><span class="span">A2.</span> Đa số sẽ là những tin tuyển dụng không yêu cầu sơ yếu lý lịch khi ứng tuyển. Chi tiết hãy xác nhận qua thông tin tuyển dụng!</dd>
                </dl>
                <dl class="group">
                    <dt class="ques box"><span class="span">Q3.</span> Có những tin tuyển dụng về ngành nghề nào?</dt>
                    <dd class="ans box"><span class="span">A3.</span> Đăng tải nhiều cơ hội việc làm đa dạng, từ Kinh doanh, Phiên dịch, Kỹ sư IT đến Sản xuất – Nhà máy. Ngoài ra, còn có tuyển dụng Tokutei Gino và Thực tập sinh, hãy khám phá ngay!</dd>
                </dl>
                <dl class="group">
                    <dt class="ques box"><span class="span">Q4.</span> Quy trình ứng tuyển như thế nào?</dt>
                    <dd class="ans box"><span class="span">A4.</span> Sau khi ứng tuyển, người phụ trách sẽ liên lạc với bạn qua Messenger.<br />Sau đó, bạn sẽ được phỏng vấn và nhà tuyển dụng sẽ thực hiện thủ tục đi làm cho bạn trong trường hợp bạn được nhận</dd>
                </dl>
            </div>
        </div>
    </section>

    <section class="sc-actions">
        <div class="container">
            <div class="grid">
                <a href="{{ route('jobs.index') }}" class="link blue">
                    <span>HÃY KHÁM PHÁ NGAY!</span>
                </a>
                <a href="{{ route('contact') }}" class="link orange">
                    <span>LIÊN HỆ ĐỂ ĐƯỢC TƯ VẤN!</span>
                    <picture>
                        <source media="(max-width: 767px)" srcset="{{ asset('images/about_contact_sp.png') }}">
                        <source media="(min-width: 768px)" srcset="{{ asset('images/about_contact_pc.png') }}">
                        <img src="{{ asset('images/about_contact_pc.png') }}" alt="Contact Us">
                    </picture>
                </a>
            </div>
        </div>
    </section>
</div>
@endsection