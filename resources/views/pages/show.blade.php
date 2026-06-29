@extends('layouts.app')

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
