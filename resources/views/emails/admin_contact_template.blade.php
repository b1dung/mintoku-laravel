<div style="background-color: #f4f7f9; padding: 40px 10px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #e1e1e1;">
        
        <div style="background: #e05f28; padding: 20px; text-align: center;">
            <h2 style="color: #ffffff; margin: 0; font-size: 18px; text-transform: uppercase; letter-spacing: 1px;">Thông báo liên hệ mới</h2>
        </div>

        <div style="padding: 30px; color: #333;">
            <p style="margin-top: 0;">Hệ thống vừa ghi nhận một yêu cầu liên hệ mới với chi tiết như sau</p>
            
            <div style="margin: 20px 0; padding: 20px; border-radius: 8px; background-color: #f8fbfe; border-left: 4px solid #0b92c7;">
                
                <div style="margin-bottom: 15px;">
                    <span style="display: block; font-size: 11px; color: #999; text-transform: uppercase;">Đối tượng</span>
                    <span style="display: block; font-size: 15px; color: #333; font-weight: 600;">{{ $subject_label }}</span>
                </div>

                <div style="margin-bottom: 15px;">
                    <span style="display: block; font-size: 11px; color: #999; text-transform: uppercase;">Họ và tên</span>
                    <span style="display: block; font-size: 15px; color: #333; font-weight: 600;">{{ $info['full_name'] }}</span>
                </div>

                <div style="margin-bottom: 15px;">
                    <span style="display: block; font-size: 11px; color: #999; text-transform: uppercase;">Email</span>
                    <span style="display: block; font-size: 15px; color: #0b92c7;">{{ $info['email'] }}</span>
                </div>

                <div style="margin-bottom: 15px;">
                    <span style="display: block; font-size: 11px; color: #999; text-transform: uppercase;">Số điện thoại</span>
                    <span style="display: block; font-size: 15px; color: #333; font-weight: 600;">{{ $info['phone'] }}</span>
                </div>

                <div>
                    <span style="display: block; font-size: 11px; color: #999; text-transform: uppercase; margin-bottom: 5px;">Nội dung tin nhắn</span>
                    <div style="padding: 15px; background: #ffffff; border-radius: 6px; border: 1px solid #eef2f6; font-size: 14px; color: #555; line-height: 1.6;">
                        {{ $info['message'] }}
                    </div>
                </div>
            </div>

            <div style="text-align: center; margin-top: 25px;">
                <a href="mailto:{{ $info['email'] }}" style="background-color: #0b92c7; color: #ffffff; padding: 10px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">Phản hồi khách hàng</a>
            </div>
        </div>

        <div style="background-color: #fafafa; padding: 15px; text-align: center; font-size: 11px; color: #bbb;">
            Yêu cầu được gửi từ trang Liên hệ - Mintoku Work
        </div>
    </div>
</div>