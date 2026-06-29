<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class PageController extends Controller
{
    public function about()
    {
        $seoData = new SEOData(
            title: 'Về chúng tôi | Mintoku Work Vietnam',
            description: 'mintoku work vietnam - Trang web tìm kiếm việc làm miễn phí tại Việt Nam',
            image: asset('images/about_banner_pc.jpg'),
            url: route('about'),
        );
        return view('pages.about', compact('seoData'));
    }

    public function contact()
    {
        return view('pages.contact');
    }
    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);
        Contact::create([
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'subject' => $validated['subject'] ?? 'Liên hệ từ Website',
            'message' => $validated['message'],
            'active'  => 1,
            'ord'     => 0,
        ]);

        return back()->with('success', 'Cảm ơn bạn! Tin nhắn của bạn đã được gửi đi thành công.');
    }

    public function detail($slug)
    {
        $page = Page::where('slug', $slug)->where('active', 1)->firstOrFail();

        $seoData = [
            'title' => $page->meta_title ?: $page->title,
            'description' => $page->meta_description ?: Str::limit(strip_tags($page->content), 160),
            'og_image' => $page->thumbnail ? asset('storage/' . $page->thumbnail) : asset('images/job_01.png'),
            'canonical' => url()->current()
        ];

        return view('pages.show', compact('page', 'seoData'));
    }
    public function privacy()
    {
        $seoData = new SEOData(
            title: 'Chính sách bảo mật | Mintoku Work Vietnam',
            description: 'mintoku work vietnam - Trang web tìm kiếm việc làm miễn phí tại Việt Nam.',
            image: asset('images/contact_banner_pc.jpg'),
            url: route('privacy'),
        );
        return view('pages.privacy', compact('seoData'));
    }
}
