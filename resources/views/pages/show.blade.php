@extends('layouts.app')

@section('title', $page->seo_title ?? $page->title)

@section('meta_description', $page->seo_description ?? '')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/privacy.css') }}">
@endpush

@section('content')
    <main class="page-detail">
        <div class="container">
            {!! $page->content !!}
        </div>
    </main>
@endsection
