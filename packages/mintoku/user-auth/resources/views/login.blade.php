@extends('user-auth::layouts.auth')

@section('title', 'Đăng nhập')

@section('content')
<div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10 border border-gray-100">
        @if ($errors->any())
        <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
            <p class="text-sm text-red-700">{{ $errors->first() }}</p>
        </div>
        @endif
        <form class="space-y-6" action="{{ route('user.login.post') }}" method="POST">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email của bạn</label>
                <div class="mt-1">
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                <div class="mt-1">
                    <input id="password" name="password" type="password" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">Ghi nhớ đăng nhập</label>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent bg-orange-600 rounded-md shadow-sm text-sm font-medium text-white btn-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    Đăng nhập ngay
                </button>
            </div>
        </form>
    </div>
</div>
@endsection