@props(['job'])

@php
// 1. Lấy các thông tin cơ bản
$posting_period = $job->get_field('posting_period');
$posting_ended = $job->get_field('posting_ended');
$id_job = $job->get_field('id_job');
$person = $job->get_field('person_in_charge');

// 2. Xử lý Logic Lương
$raw_salary = get_field($job, 'salary_by_month');

if (is_numeric($raw_salary) && (float)$raw_salary > 0) {
$formatted_salary = number_format((float)$raw_salary);
$salary = get_field($job, 'by_level_salary') . ' ' .
$formatted_salary . ' ' .
strtoupper(get_field($job, 'unit_salary'));
} else {
// Nếu không phải số hoặc bằng 0, hiển thị thỏa thuận
$salary = 'Thỏa thuận khi phỏng vấn';
}

// 3. Xử lý Categories và Locations (Chỉ lấy những bản ghi có show = 1)
$categories = $job->categories->where('active', 1);
// Lọc địa điểm ngay trong view để đảm bảo chỉ hiện những vùng cho phép
$locations = $job->locations->where('show', 1);

$noImage = asset('images/job_01.png');

// 4. Xử lý Logo (Ưu tiên logo danh mục đầu tiên)
$firstCat = $categories->first();
$logo = ($firstCat) ? get_field($firstCat, 'logo') : null;
@endphp

<div class="job-medium">
    <div class="job-top">
        {{-- Tag NEW nếu mới đăng trong vòng 7 ngày --}}
        @if($job->created_at && $job->created_at->gt(now()->subDays(7)))
        <div class="new">NEW</div>
        @endif

        @if($categories->isNotEmpty())
        @foreach ($categories as $cat)
        @php $categoryImage = get_field($cat, 'image'); @endphp
        <div class="tag">
            @if($categoryImage)
            <img src="{{ $categoryImage }}" alt="{{ $cat->name }}" class="icon">
            @endif
            <span>{{ $cat->name }}</span>
        </div>
        @endforeach
        @endif

        @if ($id_job)
        <span class="id">
            @if ($person)
            NGƯỜI PHỤ TRÁCH: {{ $person }}
            @endif
            <br>
            ID: {{ $id_job }}
        </span>
        @endif
    </div>

    <div class="job-date">
        @if($posting_period)
        <span class="date">Ngày đăng: {{ $posting_period }}</span>
        @endif
        @if($posting_ended)
        <span class="date">Hạn ứng tuyển: {{ $posting_ended }}</span>
        @endif
    </div>

    <div class="job-content">
        <div class="intro">
            {{-- Click vào title hoặc logo để xem chi tiết --}}
            <a href="{{ route('jobs.show', $job->slug) }}">
                <img src="{{ $logo ?: $noImage }}" alt="{{ $job->title }}" onerror="this.src='{{ $noImage }}'">
            </a>
            <h5 class="name">
                <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
            </h5>
        </div>

        <div class="info">
            @if($firstCat)
            <p class="text field">
                <span>{{ $firstCat->name }}</span>
            </p>
            @endif

            @if($locations->isNotEmpty())
            <p class="text location">
                @foreach ($locations as $loc)
                <span>{{ $loc->name }}</span>
                @if(!$loop->last)
                @endif
                @endforeach
            </p>
            @endif

            <p class="text price">{{ $salary }}</p>

            @if ($job->company)
            <p class="text agency">
                <span>{{ $job->company->name }}</span>
            </p>
            @endif
        </div>
    </div>
</div>