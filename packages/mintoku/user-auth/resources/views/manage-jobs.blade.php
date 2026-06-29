@extends('user-auth::layouts.auth')
@section('header_title', 'Danh sách tin tuyển dụng')
@section('content')
<div class="bg-white rounded-[32px] border border-orange-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-left border-collapse min-w-[1200px]">
            <thead>
                <tr class="bg-orange-50/70">
                    <th class="px-4 py-3 text-[11px] font-bold text-orange-500 uppercase tracking-widest w-64">Tiêu đề công việc</th>
                    <th class="px-4 py-3 text-[11px] font-bold text-orange-500 uppercase tracking-widest w-48">Ngành nghề</th>
                    <th class="px-4 py-3 text-[11px] font-bold text-orange-500 uppercase tracking-widest w-48">Khu vực</th>
                    <th class="px-4 py-3 text-[11px] font-bold text-orange-500 uppercase tracking-widest w-52 text-center">Mức lương</th>
                    <th class="px-4 py-3 text-[11px] font-bold text-orange-500 uppercase tracking-widest w-32 text-center">Trạng thái</th>
                    <th class="px-4 py-3 text-[11px] font-bold text-orange-500 uppercase tracking-widest w-40 text-center">Ngày đăng / Hết hạn</th>
                    <th class="px-4 py-3 text-[11px] font-bold text-orange-500 uppercase tracking-widest text-right w-32">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-orange-50">
                @forelse($my_jobs as $job)
                <tr class="group hover:bg-orange-50/60 transition-all duration-200">
                    <td class="px-4 py-3">
                        <div class="flex flex-col">
                            <a href="{{ route('user.job.edit', $job->id) }}"
                                class="font-bold text-orange-800 group-hover:text-orange-600 transition-colors hover:underline">
                                {{ $job->title }}
                            </a>
                            <div class="flex items-center mt-1.5 space-x-3 text-[11px] text-orange-500 font-medium">
                                <span>ID: {{ $job->extra_attributes['id_job'] ?? 'N/A' }}</span>
                                <span>•</span>
                                <span>{{ $job->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm text-slate-700">
                        @if($job->categories->isNotEmpty())
                        {{ $job->categories->pluck('name')->take(2)->implode(', ') }}
                        @if($job->categories->count() > 2)
                        <span class="text-orange-400">+{{ $job->categories->count() - 2 }}</span>
                        @endif
                        @else
                        <span class="text-slate-400 italic">Chưa chọn</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-slate-700">
                        @if($job->locations->isNotEmpty())
                        {{ $job->locations->pluck('name')->take(2)->implode(', ') }}
                        @if($job->locations->count() > 2)
                        <span class="text-orange-400">+{{ $job->locations->count() - 2 }}</span>
                        @endif
                        @else
                        <span class="text-slate-400 italic">Chưa chọn</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        @php
                        $unit = $job->extra_attributes['unit_salary'] ?? 'jpy';
                        $symbol = $unit === 'jpy' ? '¥' : ($unit === 'usd' ? '$' : '₫');
                        $by = $job->extra_attributes['by_level_salary'] ?? '';
                        $salary_month = $job->extra_attributes['salary_by_month'] ?? null;
                        $salary_hour = $job->extra_attributes['salary_by_hour'] ?? null;
                        @endphp
                        @if($salary_month)
                        <div class="font-bold text-orange-700">
                            {{ $by }} {{ number_format($salary_month) }}{{ $symbol }}/tháng
                        </div>
                        @if($salary_hour)
                        <div class="text-[11px] text-orange-500 mt-1">
                            + {{ $salary_hour }} {{ $symbol }}/giờ
                        </div>
                        @endif
                        @elseif($salary_hour)
                        <div class="font-bold text-orange-700">
                            {{ $salary_hour }} {{ $symbol }}/giờ
                        </div>
                        @else
                        <span class="text-slate-400 italic text-sm">Thỏa thuận</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($job->active)
                        <span class="inline-flex items-center px-3.5 py-1.5 bg-green-100 text-green-700 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            Hiển thị
                        </span>
                        @else
                        <span class="inline-flex items-center px-3.5 py-1.5 bg-orange-100 text-orange-700 rounded-full text-[10px] font-bold uppercase tracking-wider shadow-sm">
                            <span class="w-2 h-2 bg-orange-500 rounded-full mr-2"></span>
                            Chờ duyệt
                        </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center text-sm text-slate-600">
                        <div class="flex flex-wrap">
                            <span>{{ $job->created_at->format('d/m/Y') }}</span>
                            @if(!empty($job->extra_attributes['posting_ended']))
                             &nbsp; - &nbsp;<span class="text-orange-500 font-medium">{{ \Carbon\Carbon::parse($job->extra_attributes['posting_ended'])->format('d/m/Y') }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex justify-end space-x-3 opacity-80 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('user.job.edit', $job->id) }}"
                                class="p-2.5 text-orange-500 hover:text-orange-700 hover:bg-orange-50 rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            <form action="{{ route('user.job.destroy', $job->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Bạn chắc chắn muốn xóa tin này?')"
                                    class="p-2.5 text-orange-500 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-8 py-24 text-center">
                        <div class="flex flex-col items-center space-y-3">
                            <svg class="w-16 h-16 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-orange-500 font-bold text-lg">Bạn chưa có tin tuyển dụng nào</p>
                            <a href="{{ route('user.job.create') }}"
                                class="text-orange-600 hover:text-orange-800 font-medium underline">Đăng tin ngay</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection