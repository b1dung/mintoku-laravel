@php
$extra = $job->extra_attributes;
$id_job = data_get($extra, 'id_job');
$posting_period = data_get($extra, 'posting_period');
$posting_ended = data_get($extra, 'posting_ended');
$incorporation = data_get($extra, 'work_by');
$jobFairs = data_get($extra, 't_jobfair');

$occupations = $job->categories->where('active', 1);
$visas = $job->visas;

$locations = $job->locations;
$location_text = $locations->map(function($loc) {
return $loc->parent ? "{$loc->name} ({$loc->parent->name})" : $loc->name;
})->join(', ');

$salary_val = data_get($extra, 'salary_by_month');
$unit = strtoupper(data_get($extra, 'unit_salary', 'JPY'));
$level = data_get($extra, 'by_level_salary');

if (is_numeric($salary_val) && (float)$salary_val > 0) {
$salary_text = ($level ? $level . ' ' : '') . number_format((float)$salary_val) . " " . $unit;
} else {
$salary_text = 'Thỏa thuận khi phỏng vấn';
}

$firstCat = $occupations->first();
$catLogo = $firstCat ? get_field($firstCat, 'logo') : null;
$thumbnail = $catLogo ?: asset('images/job_01.png');
@endphp

<div class="job-large">
    <div class="job-top">
        @if($job->created_at >= now()->subDays(7))
        <div class="new">NEW</div>
        @endif

        @foreach($occupations as $category)
        <div class="tag">
            <span>{{ $category->name }}</span>
        </div>
        @endforeach

        @if(!empty($jobFairs) && is_array($jobFairs))
        @foreach($jobFairs as $jobFair)
        @php $logoJobFair = data_get($jobFair, 'logo'); @endphp
        @if($logoJobFair)
        <img src="{{ $logoJobFair }}" alt="Job Fair" class="jobfair-logo">
        @endif
        @endforeach
        @endif

        @if($id_job)
        <div class="id">ID: {{ $id_job }}</div>
        @endif
    </div>

    <div class="grid">
        <div class="thumbnail">
            <a href="{{ route('jobs.show', $job->slug) }}">
                <img src="{{ $thumbnail }}" alt="{{ $job->title }}" onerror="this.src='{{ asset('images/job_01.png') }}'">
            </a>
        </div>

        <h5 class="name">
            <a href="{{ route('jobs.show', $job->slug) }}" title="{{ $job->title }}">
                {{ $job->title }}
            </a>
        </h5>

        <div class="job-content">
            <p class="desc">
                {{ Str::limit(strip_tags($job->description), 150) }}
            </p>

            <div class="info">
                @if($occupations->isNotEmpty())
                <p class="text field">
                    <span class="label">Vị trí:</span>
                    {{ $occupations->first()->name }}
                </p>
                @endif

                @if($locations->isNotEmpty())
                <p class="text location">
                    <span class="label">Địa điểm:</span>
                    {{ $location_text }}
                </p>
                @endif

                <p class="text price">
                    <span class="label">Mức lương:</span> {{ $salary_text }}
                </p>

                @if($job->company)
                <p class="text agency">
                    <span class="label">Công ty:</span>
                    {{ $job->company->name }}
                </p>
                @elseif($incorporation)
                <p class="text agency">
                    <span class="label">Agency:</span>
                    {{ $incorporation }}
                </p>
                @endif
            </div>

            <div class="actions">
                <div class="dates">
                    @if($posting_period)
                    <span class="date">Ngày đăng: {{ $posting_period }}</span>
                    @endif
                    @if($posting_ended)
                    <span class="date">Hạn ứng tuyển: {{ $posting_ended }}</span>
                    @endif
                </div>

                <div class="btn-group" style="display: flex; gap: 10px;">
                    <a href="{{ route('jobs.show', $job->slug) }}" class="link">Xem chi tiết</a>
                </div>
            </div>
        </div>
    </div>
</div>