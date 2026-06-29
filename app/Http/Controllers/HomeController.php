<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class HomeController extends Controller
{
    public function index()
    {
        $latestJobs = Job::with(['company', 'locations'])
            ->where('active', true)
            ->orderBy('ord', 'asc')
            ->orderBy('id', 'desc')
            ->limit(12)
            ->get();

        $seoData = new SEOData(
            title: 'mintoku work vietnam - Trang web tìm kiếm việc làm miễn phí tại Việt Nam',
            description: 'Cổng thông tin việc làm hàng đầu với hơn 10.000+ cơ hội nghề nghiệp mỗi ngày.',
            image: asset('images/og-image-homepage.jpg'),
            url: route('home'),
        );

        return view('index', compact('latestJobs', 'seoData'));
    }
}
