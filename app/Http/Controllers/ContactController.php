<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Mail\AdminContactMail;
use App\Mail\UserContactMail;
use App\Services\PancakeCrmService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class ContactController extends Controller
{
    public function index()
    {
        $seoData = new SEOData(
            title: 'Liên hệ - mintoku work vietnam',
            description: 'Cổng thông tin việc làm hàng đầu với hơn 10.000+ cơ hội nghề nghiệp mỗi ngày.',
        );

        return view('contact.index', compact('seoData'));
    }

    public function store(Request $request, PancakeCrmService $pancakeCrmService)
    {
        $validated = $request->validate([
            'subject_type' => 'required|in:individual,company',
            'full_name'    => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => ['required', 'string', 'max:20', 'regex:/^([0-9\s\-\+\.]*)$/'],
            'message'      => 'required|string|max:2000',
            'agreement'    => 'accepted',
        ], [
            'subject_type.required' => 'Vui lòng chọn đối tượng liên hệ.',
            'full_name.required'    => 'Vui lòng nhập họ và tên.',
            'email.required'        => 'Vui lòng nhập địa chỉ email.',
            'email.email'           => 'Địa chỉ email không hợp lệ.',
            'phone.required'        => 'Vui lòng nhập số điện thoại.',
            'message.required'      => 'Vui lòng nhập nội dung tin nhắn.',
            'agreement.accepted'    => 'Bạn cần đồng ý với điều khoản của chúng tôi.'
        ]);

        try {
            Contact::create([
                'name'    => $validated['full_name'],
                'email'   => $validated['email'],
                'subject' => $validated['subject_type'] === 'individual' ? 'Cá nhân' : 'Công ty',
                'message' => "SĐT: {$validated['phone']} \nNội dung: {$validated['message']}",
                'active'  => 1,
            ]);

            $data = [
                'info'          => $validated,
                'subject_label' => $validated['subject_type'] === 'individual' ? 'Cá nhân' : 'Công ty'
            ];

            $adminEmails = ['v1thuc@sougo-career-vietnam.com'];
            Mail::to($adminEmails)->queue(new AdminContactMail($data));
            Mail::to($validated['email'])->queue(new UserContactMail($validated['full_name']));

            $crmResult = $pancakeCrmService->createLead($validated);

            if (! $crmResult['success']) {
                Log::warning('Pancake CRM create lead failed', $crmResult);
            }

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Contact Queue Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi gửi liên hệ.'
            ], 500);
        }
    }
}