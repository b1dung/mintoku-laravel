<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mintoku Panel')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 20px;
        }

        .sidebar-active {
            background: #eff6ff;
            color: #2563eb;
        }
    </style>
</head>

<body class="bg-[#F8FAFC] antialiased text-[#1E293B]">

    <div class="flex min-h-screen overflow-hidden" x-data="{ mobileMenu: false }">

        <aside class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-orange-100 flex flex-col transform transition-transform duration-300 md:relative md:tranorange-x-0"
            :class="mobileMenu ? 'tranorange-x-0' : '-tranorange-x-full'">

            <div class="p-8">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-orange-600 rounded-[12px] flex items-center justify-center text-white shadow-lg shadow-orange-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight">Mintoku VN</span>
                </div>
            </div>

            <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto custom-scrollbar">
                <div class="px-4 py-4 text-[11px] font-bold text-orange-400 uppercase tracking-[2px]">Bảng điều khiển</div>

                <a href="{{ route('user.job.index') }}"
                    class="flex items-center px-4 py-3.5 rounded-[18px] font-bold transition-all duration-200 group {{ request()->routeIs('user.job.index') ? 'sidebar-active shadow-sm' : 'text-orange-500 hover:bg-orange-50' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span>Quản lý Job đã tạo</span>
                </a>

                <a href="{{ route('user.job.create') }}"
                    class="flex items-center px-4 py-3.5 rounded-[18px] font-bold transition-all duration-200 group {{ request()->routeIs('user.job.create') ? 'sidebar-active shadow-sm' : 'text-orange-500 hover:bg-orange-50' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Đăng Job mới</span>
                </a>
            </nav>

            <div class="p-4 mt-auto">
                @auth
                <div class="p-4 bg-orange-50 rounded-[24px] flex items-center space-x-3 border border-orange-100">
                    <div class="w-10 h-10 rounded-full bg-orange-600 flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-orange-400 font-medium tracking-wide uppercase">Nhà tuyển dụng</p>
                    </div>
                </div>
                @else
                <div class="p-4">
                    <a href="{{ route('user.login') }}" class="block w-full text-center py-3 bg-orange-600 text-white rounded-xl font-bold text-sm">
                        Đăng nhập
                    </a>
                </div>
                @endauth
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

            <header class="h-20 bg-white/80 backdrop-blur-md border-b border-orange-100 flex items-center justify-between px-8 z-40">
                <div class="flex items-center">
                    <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 mr-4 text-orange-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                    <h2 class="text-lg font-extrabold text-orange-800">@yield('header_title')</h2>
                </div>
                @if(Auth::check())
                <div class="flex items-center space-x-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="flex items-center text-sm font-bold text-red-400 hover:text-red-500 transition-colors">
                            <span class="mr-2">Đăng xuất</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
                @endif
            </header>

            <main class="flex-1 overflow-y-auto p-6 md:p-10 custom-scrollbar bg-[#F8FAFC]">
                @yield('content')
            </main>
        </div>

        <div x-show="mobileMenu" @click="mobileMenu = false"
            class="fixed inset-0 bg-orange-900/50 backdrop-blur-sm z-40 md:hidden"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"></div>
    </div>

</body>

</html>