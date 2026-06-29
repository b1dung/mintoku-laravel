@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/privacy.css') }}">
@endpush

@section('content')
<div id="privacy">
    <section class="sc-banner">
        <div class="bg">
            <picture>
                <source media="(max-width: 767px)" srcset="{{ asset('images/contact_banner_sp.jpg') }}">
                <source media="(min-width: 768px)" srcset="{{ asset('images/contact_banner_pc.jpg') }}">
                <img src="{{ asset('images/contact_banner_pc.jpg') }}" alt="Banner Privacy">
            </picture>
        </div>
        <div class="container banner-container">
            <p class="tag-block white">Chính sách</p>
            <h1 class="title">
                Chính sách bảo mật của mintoku work vietnam
            </h1>
        </div>
    </section>

    @include('partials.breadcrumb')

    <div class="sc-content">
        <div class="container">
            <dl class="group">
                <dt class="ttl"><span class="num">1.</span>Tên, địa chỉ, người đại diện và người quản lý của doanh nghiệp xử lý thông tin cá nhân</dt>
                <dd class="text">CÔNG TY TNHH CAMCOM VIỆT NAM</dd>
                <dd class="text">Tầng 11, Văn phòng 2 – Tòa nhà Sunsquare, số 21 Lê Đức Thọ, Phường Mỹ Đình 2, Quận Nam Từ Liêm, Thành phố Hà Nội, Việt Nam </dd>
                <dd class="text">
                    Giám đốc đại diện Hayashida Hisashi <br />
                    Tel: (+84)24-7109-4510 *Dùng trong nước tại Việt Nam <br />
                    Email: info_scv@sougo-career-vietnam.com
                </dd>
            </dl>

            <dl class="group">
                <dt class="ttl"><span class="num">2.</span>Mục đích sử dụng thông tin cá nhân</dt>
                <dd class="text">Mục đích sử dụng thông tin cá nhân chúng tôi thu thập như sau. </dd>

                <dd class="text">
                    <p><span class="num">(1)</span>Thông tin thu được khi trả lời các câu hỏi</p>
                    <div class="indent">
                        <p><span class="num">①</span>Đối với những người đã gửi thắc mắc, chúng tôi sẽ sử dụng thông tin đó để trả lời các câu hỏi của bạn.</p>
                    </div>
                    <p><span class="num">(2)</span>Thông tin về người nộp đơn vào cơ hội việc làm của công ty chúng tôi</p>
                    <div class="indent">
                        <p><span class="num">②</span>Nếu bạn nộp đơn xin việc tại công ty chúng tôi, chúng tôi sẽ sử dụng thông tin của bạn để sàng lọc và liên hệ với bạn.</p>
                    </div>
                </dd>
            </dl>

            <dl class="group">
                <dt class="ttl"><span class="num">3.</span>Tự nguyện cung cấp thông tin cá nhân và những điểm cần lưu ý</dt>
                <dd class="text">
                    <p><span class="num">(1)</span>Việc cung cấp thông tin cá nhân là tự nguyện, nhưng xin lưu ý rằng chúng tôi có thể không phản hồi được yêu cầu của bạn nếu các trường bắt buộc không được điền hoặc thông tin không chính xác.</p>
                    <p><span class="num">(2)</span>Khi chúng tôi trực tiếp nhận được thông tin cá nhân, chúng tôi không có nghĩa vụ phải trả lại thông tin đó bằng bất kỳ phương tiện nào.</p>
                </dd>
            </dl>

            <dl class="group">
                <dt class="ttl"><span class="num">3.</span>Về việc cung cấp thông tin cá nhân cho bên thứ ba</dt>
                <dd class="text">Thông tin cá nhân do công ty chúng tôi nắm giữ sẽ không được cung cấp cho bên thứ ba ngoại trừ các trường hợp sau.</dd>
                <dd class="text">
                    <p><span class="num">(1)</span>Khi những vấn đề cần thiết được nêu rõ hoặc thông báo trước cho người đó và nhận được sự đồng ý của người đó.</p>
                    <p><span class="num">(2)</span>Các trường hợp dựa trên luật và quy định</p>
                </dd>
            </dl>

            <dl class="group">
                <dt class="ttl"><span class="num">5.</span>Ký gửi thông tin cá nhân</dt>
                <dd class="text">
                    Việc ủy thác thông tin cá nhân Công ty chúng tôi sẽ tuân thủ 2 điều trên. Thông tin cá nhân có thể được ủy thác cho các công ty bên ngoài trong phạm vi cần thiết để đạt được mục đích sử dụng. Về gia công phần mềm, chúng tôi chọn những doanh nghiệp đáp ứng các tiêu chuẩn bảo vệ thông tin cá nhân do công ty chúng tôi đặt ra và chúng tôi thuê ngoài thông tin sau khi trao đổi hợp đồng để đảm bảo quản lý phù hợp.
                </dd>
            </dl>

            <dl class="group">
                <dt class="ttl"><span class="num">6.</span>Sử dụng chung</dt>
                <dd class="text">Chúng tôi sẽ cùng nhau sử dụng thông tin cá nhân mà chúng tôi nhận được như sau.</dd>
                <dd class="text">
                    6.1　Thông tin về lãnh đạo và nhân viên của đối tác kinh doanh <br />
                    <div class="indent">
                        <p><span class="num">(1)</span>Các mục thông tin cá nhân sẽ được sử dụng chung</p>
                        <div class="indent">Tên, tên công ty, tên bộ phận, chức danh, địa chỉ, địa chỉ email, số điện thoại, số fax, v.v.</div>
                        <p><span class="num">(2)</span>Phạm vi người dùng chung</p>
                        <div class="indent">Các công ty thuộc tập đoàn của chúng tôi (Bấm vào <a style="color: #000080;" href="https://cam-com.inc/company/#group">đây</a> để xem chi tiết)</div>
                        <p><span class="num">(3)</span>Mục đích sử dụng chung</p>
                        <div class="indent">・Cung cấp thông tin và đề xuất về các dịch vụ được cung cấp bởi các công ty thuộc tập đoàn <br />
                            ・Để thực hiện các giao dịch như hợp đồng, đơn đăng ký, yêu cầu, v.v.</div>
                        <p><span class="num">(4)</span>Làm thế nào để có được</p>
                        <div class="indent">Trao đổi danh thiếp, đàm phán kinh doanh, đơn đăng ký giao dịch, đơn đăng ký sự kiện và hội thảo, giải đáp thắc mắc về dịch vụ, v.v.</div>
                        <p><span class="num">(5)</span>Người chịu trách nhiệm quản lý thông tin cá nhân được chia sẻ</p>
                        <div class="indent">Công ty TNHH Lựa chọn nghề nghiệp Sougo <br />
                            Người quản lý thông tin cá nhân <br />
                            Địa chỉ: 2-4-1 Hamamatsucho, Minato-ku, Tokyo <br />
                            Người đại diện: Giám đốc đại diện Takata Oizumi</div>
                    </div>
                </dd>
            </dl>

            <dl class="group">
                <dt class="ttl"><span class="num">7.</span>Các vấn đề về biện pháp quản lý an toàn</dt>
                <dd class="text">
                    Công ty chúng tôi sẽ thực hiện các biện pháp quản lý an toàn cần thiết và phù hợp để quản lý dữ liệu cá nhân, bao gồm ngăn chặn rò rỉ, mất mát hoặc hư hỏng dữ liệu đó. Ngoài ra, chúng tôi sẽ thực hiện giám sát cần thiết và phù hợp đối với nhân viên và nhà thầu phụ (bao gồm cả nhà thầu phụ, v.v.) xử lý dữ liệu cá nhân. Các biện pháp quản lý an toàn dữ liệu cá nhân được quy định cụ thể trong các quy định nội bộ riêng, nội dung chính như sau.
                </dd>
                <dd class="text">
                    <p><span class="num">(1)</span>Xây dựng các chính sách cơ bản để thực hiện từng phản hồi theo quy định của pháp luật và hướng dẫn xử lý đúng thông tin cá nhân và dữ liệu cá nhân. </p>
                    <p><span class="num">(2)</span>Xây dựng các quy định khác nhau quy định từng phản hồi như mua lại, sử dụng, lưu trữ, cung cấp, xóa, thải bỏ, v.v., cũng như những người và vai trò chịu trách nhiệm. </p>
                    <p><span class="num">(3)</span>Bổ nhiệm người chịu trách nhiệm, làm rõ nhân viên xử lý dữ liệu cá nhân và phạm vi dữ liệu cá nhân được xử lý, thiết lập hệ thống báo cáo cho người phụ trách trong trường hợp phát hiện sự việc hoặc dấu hiệu vi phạm pháp luật và quy định ; Các biện pháp quản lý an toàn của tổ chức như kiểm tra định kỳ về điều kiện xử lý </p>
                    <p><span class="num">(4)</span>Các biện pháp quản lý an toàn cá nhân như nêu rõ các vấn đề liên quan đến bảo mật dữ liệu cá nhân trong quy tắc làm việc và tiến hành giáo dục và đào tạo về các vấn đề cần lưu ý liên quan đến việc xử lý dữ liệu cá nhân </p>
                    <p><span class="num">(5)</span>Các biện pháp quản lý an toàn vật lý như quản lý ra/vào nhân viên, hạn chế mang thiết bị vào cũng như hạn chế và kiểm soát việc mang ra ngoài để ngăn chặn các thiết bị xử lý dữ liệu cá nhân, phương tiện điện tử và tài liệu bị đánh cắp hoặc thất lạc. </p>
                    <p><span class="num">(6)</span>Các biện pháp kiểm soát an ninh kỹ thuật như giới thiệu hệ thống bảo vệ hệ thống thông tin xử lý dữ liệu cá nhân khỏi sự truy cập trái phép từ bên ngoài hoặc phần mềm trái phép.</p>
                </dd>
            </dl>

            <dl class="group">
                <dt class="ttl"><span class="num">8.</span>Thu thập thông tin cá nhân bằng Cookie, v.v.</dt>
                <dd class="text">
                    Trang web của chúng tôi sử dụng cookie, v.v. để cung cấp các dịch vụ tùy chỉnh cho từng người dùng. Các công cụ này cung cấp thông tin hệ thống cần thiết để xem các trang, thông tin để xác nhận rằng người dùng đó là cùng một người, lịch sử hành vi của người dùng (các trang đã truy cập, nội dung đã xem, v.v.), thông tin thiết bị đầu cuối và Chúng tôi có thể lấy thông tin vị trí, v.v. Mặc dù thông tin này không bao gồm thông tin có thể nhận dạng cá nhân, nhưng các cá nhân có thể được xác định bằng cách so sánh nó với thông tin do công ty chúng tôi nắm giữ và sử dụng trong phạm vi mục đích sử dụng được nêu ở mục 2. ở trên. <br />
                    Xin lưu ý rằng bạn có thể từ chối chấp nhận cookie bằng cách thay đổi cài đặt trên trình duyệt của mình, nhưng xin lưu ý rằng bạn có thể không sử dụng được một số chức năng trên trang web của chúng tôi.
                </dd>
            </dl>

            <dl class="group">
                <dt class="ttl"><span class="num">9.</span>Đầu mối liên hệ giải đáp thắc mắc về thông tin cá nhân</dt>
                <dd class="text">
                    Đối với “khiếu nại liên quan đến thông tin cá nhân”, vui lòng liên hệ với chúng tôi dưới đây.
                </dd>
                <dd class="text">
                    Tầng 11, Văn phòng 2 – Tòa nhà Sunsquare, số 21 Lê Đức Thọ, Phường Mỹ Đình 2, Quận Nam Từ Liêm, Thành phố Hà Nội, Việt Nam <br />
                    CÔNG TY TNHH CAMCOM VIỆT NAM Văn phòng bảo vệ thông tin cá nhân <br />
                    Giám đốc đại diện Hayashida Hisashi <br />
                    Tel: (+84)24-7109-4510 (Các ngày trong tuần 9:00-18:00) *Dùng trong nước tại Việt Nam <br />
                    Mail : info_scv@sougo-career-vietnam.com
                </dd>
            </dl>
        </div>
    </div>
</div>
@endsection