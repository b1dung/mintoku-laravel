@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/archive.css') }}">
<div id="archive">
    <section class="sc-banner">
        <div class="bg">
            <picture>
                <source media="(max-width: 767px)" srcset="{{ asset('images/single_banner_sp.jpg') }}">
                <source media="(min-width: 768px)" srcset="{{ asset('images/single_banner_pc.jpg') }}">
                <img src="{{ asset('images/single_banner_pc.jpg') }}" alt="Banner">
            </picture>
        </div>
        <div class="container banner-container">
            <p class="tag-block white">Search Jobs Post Job for free</p>
            <x-job-search />
        </div>
    </section>

    @include('partials.breadcrumb')

    <section class="sc-list">
        <div class="container">
            <form action="{{ route('jobs.index') }}" method="GET" id="frm-filter" onchange="this.submit()">
                <input type="hidden" name="s" value="{{ request('s') }}">
                <div class="list-container">
                    @include('jobs.sidebar')

                    <article class="article">
                        <div class="article-head">
                            <h1 class="title">
                                {{ $searchTitle }}
                            </h1>
                            <p class="text">Đã tìm thấy <span class="number">{{ $jobs->total() }}</span> cơ hội việc làm phù hợp</p>
                        </div>

                        <div class="article-filter">
                            <div class="filter-order--by">
                                <div class="order--by">
                                    <span class="label">Sắp xếp</span>
                                    <label for="order-by-time">
                                        <input id="order-by-time" type="radio" name="order-by" value="DESC"
                                            {{ request('order-by', 'DESC') == 'DESC' ? 'checked' : '' }}> Mới nhất
                                    </label>
                                    <label for="order-by-salary">
                                        <input id="order-by-salary" type="radio" name="order-by" value="SALARY"
                                            {{ request('order-by') == 'SALARY' ? 'checked' : '' }}> Mức lương
                                    </label>
                                </div>
                                <div class="clear--display">
                                    <a class="filter-clear" href="{{ route('jobs.index') }}" title="Xóa lọc">Xóa lọc</a>
                                    <select name="perpage" id="perpage-job">
                                        @foreach([10, 20, 30] as $val)
                                        <option value="{{ $val }}" {{ request('perpage') == $val ? 'selected' : '' }}>
                                            {{ $val }} kết quả
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="article-content">
                            @if($jobs->count() > 0)
                            @foreach($jobs as $job)
                            @include('jobs.job-card', ['job' => $job])
                            @endforeach
                            <div class="pagination-wrapper">
                                {{ $jobs->links('pagination') }}
                            </div>
                            @else
                            <p>Không có dữ liệu phù hợp.</p>
                            @endif
                        </div>
                    </article>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection