<div class="job-small">
    <div class="job-top">
        @if($job->created_at && $job->created_at->gt(now()->subDays(7)))
        <div class="new">NEW</div>
        @endif

        <div class="id">ID: {{ $job->get_field('id_job') }}</div>
    </div>

    <div class="job-middle">
        @php
        $firstCat = $job->categories->where('active', 1)->first();
        $noImage = asset('images/job_01.png');
        $logo = ($firstCat) ? get_field($firstCat, 'logo') : $noImage;
        @endphp

        <a href="{{ route('jobs.show', $job->slug) }}">
            <img src="{{ $logo ?: $noImage }}" alt="{{ $job->title }}" onerror="this.src='{{ $noImage }}'">
        </a>

        <h5 class="name">
            <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
        </h5>
    </div>

    <div class="job-bottom">
        <p class="text price">
            @php
            $salary_val = $job->get_field('salary_by_month');
            $level = $job->get_field('by_level_salary');
            $unit = strtoupper($job->get_field('unit_salary'));
            @endphp

            @if(is_numeric($salary_val) && (float)$salary_val > 0)
            {{ $level }} {{ number_format((float)$salary_val) }} {{ $unit }}
            @else
            Thỏa thuận khi phỏng vấn
            @endif
        </p>

        @php
        $visibleLocations = $job->locations;
        @endphp

        @if($visibleLocations->isNotEmpty())
        <p class="text location">
            @foreach($visibleLocations as $loc)
            <span>{{ $loc->name }}</span>
            @if(!$loop->last)
            @endif
            @endforeach
        </p>
        @endif
    </div>
</div>