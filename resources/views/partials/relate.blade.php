@php
$currentId = isset($job) ? $job->id : null;
$relatedJobs = \App\Models\Job::getRelated($currentId, 10);
@endphp

@if($relatedJobs->isNotEmpty())
<div id="relate">
    <div class="container">
        <h2 class="title">VIỆC LÀM DÀNH CHO BẠN</h2>
    </div>
    <div class="relate-swiper swiper">
        <div class="swiper-wrapper">
            @foreach($relatedJobs as $rJob)
            <div class="swiper-slide">
                {{-- Truyền biến $rJob vào partial job-small --}}
                @include('partials.job-small', ['job' => $rJob])
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif