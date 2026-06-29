@extends('user-auth::layouts.auth')
@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<div class="max-w-6xl mx-auto px-4 py-10 font-sans selection:bg-orange-100 selection:text-orange-600"
    x-data="jobForm()" x-init="jobForm()" x-cloak style="font-family: 'Inter', sans-serif;">
    <div class="mb-16 text-center">
        <h1 class="text-3xl font-black text-orange-900 mb-2 tracking-tight">
            {{ $job ? 'Chỉnh Sửa Tin Tuyển Dụng' : 'Đăng Tin Tuyển Dụng' }}
        </h1>
        <p class="text-orange-500 text-sm mb-10">Vui lòng kiểm tra kỹ các thông tin có dấu (*)</p>
        <div class="relative flex items-center justify-between max-w-5xl mx-auto px-4">
            <div class="absolute left-4 right-4 top-3 h-1 bg-orange-100 rounded-full"></div>
            <div class="absolute left-4 top-3 h-1 bg-orange-500 transition-all duration-700 ease-in-out rounded-full shadow-[0_0_15px_rgba(249,115,22,0.4)]"
                :style="'width: ' + ((step - 1) / 7 * 100) + '%'"></div>
            <template x-for="i in 8">
                <div class="relative z-10 flex flex-col items-center">
                    <div @click="step = i"
                        :class="step >= i ? 'bg-orange-600 border-orange-200 text-white shadow-lg' : 'bg-white border-orange-200 text-orange-400'"
                        class="w-10 h-10 rounded-full border-2 flex items-center justify-center font-bold transition-all duration-300 cursor-pointer hover:scale-110"
                        x-text="i"></div>
                    <span class="absolute -bottom-8 text-[9px] font-black uppercase tracking-wider w-24 text-center transition-colors duration-300"
                        :class="step === i ? 'text-orange-600' : 'text-orange-400'"
                        x-text="stepNames[i-1]"></span>
                </div>
            </template>
        </div>
    </div>
    <form id="post-job-form" action="{{ $job ? route('user.job.update', $job->id) : route('user.job.store') }}"
        method="POST" class="bg-white shadow-[0_20px_60px_rgba(0,0,0,0.07)] rounded-[3rem] border border-orange-100 overflow-hidden">
        @csrf
        @if($job) @method('PUT') @endif
        <div class="p-8 md:p-16 space-y-12">
            <div x-show="step === 1" x-transition class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-orange-700 mb-1.5">Tên công việc *</label>
                        <input type="text" name="name" required
                            :class="{ 'border-red-500 focus:border-red-500 focus:ring-red-200': touched.name && errors.name }"
                            value="{{ old('name', $job?->title ?? '') }}"
                            class="w-full rounded-xl border border-orange-200 px-4 py-3 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-200 outline-none transition"
                            placeholder="VD: Senior PHP Developer">
                        <template x-if="touched.name && errors.name">
                            <p class="text-red-600 text-xs mt-2 p-2 bg-red-50 border border-red-200 rounded-lg" x-text="errors.name"></p>
                        </template>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-orange-700 mb-1.5">Visa hỗ trợ *</label>
                        <div class="flex flex-wrap gap-x-6 gap-y-2 mt-1">
                            @foreach($visas as $visa)
                            <label class="flex items-center gap-1.5 cursor-pointer text-xs group">
                                <input type="radio" name="visas[]" value="{{ $visa->id }}"
                                    {{ old('visas.0', $job?->visas->first()?->id) == $visa->id ? 'checked' : '' }}
                                    class="w-4 h-4 text-orange-600 border-gray-300 focus:ring-orange-500">
                                <span class="group-hover:text-orange-600 transition-colors">{{ $visa->name }}</span>
                            </label>
                            @endforeach
                        </div>
                        <template x-if="touched.visa && errors.visa">
                            <p class="text-red-600 text-xs mt-2 p-2 bg-red-50 border border-red-200 rounded-lg" x-text="errors.visa"></p>
                        </template>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-3 rounded-2xl border border-orange-200 shadow-sm">
                        <label class="block text-base font-bold text-orange-600 mb-3">Ngành nghề *</label>
                        <div class="h-80 overflow-y-auto pr-3 custom-scrollbar space-y-4">
                            @foreach($categories as $grand)
                            @php
                            $grandChildrenIds = $grand->children->pluck('id')->merge($grand->children->flatMap->children->pluck('id'))->join(',');
                            @endphp
                            <div class="p-3 bg-orange-50/50 rounded-2xl border border-orange-100">
                                <label class="flex items-center gap-3 cursor-pointer mb-3 group">
                                    <input type="checkbox" value="{{ $grand->id }}" name="job_categories[]"
                                        x-model="selectedValues.categories"
                                        @change="sync('categories', {{ $grand->id }}, [], [{{ $grandChildrenIds }}])"
                                        class="w-5 h-5 rounded-md text-orange-600 border-orange-300">
                                    <span class="text-sm font-black text-orange-800">{{ $grand->name }}</span>
                                </label>

                                <div class="ml-7 space-y-4 border-l-2 border-orange-100/50 pl-4">
                                    @foreach($grand->children as $parent)
                                    @php
                                    $childIds = $parent->children->pluck('id')->join(',');
                                    $parentSiblings = $grand->children->pluck('id')->join(',');
                                    @endphp
                                    <div>
                                        <label class="flex items-center gap-2 cursor-pointer group mb-2">
                                            <input type="checkbox" value="{{ $parent->id }}" name="job_categories[]"
                                                x-model="selectedValues.categories"
                                                @change="sync('categories', {{ $parent->id }}, [{{ $grand->id }}], [{{ $childIds }}], [{{ $parentSiblings }}])"
                                                class="w-4 h-4 text-orange-500 rounded border-orange-300">
                                            <span class="text-sm font-bold text-orange-700">{{ $parent->name }}</span>
                                        </label>

                                        <div class="ml-6 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                            @foreach($parent->children as $child)
                                            <label class="flex items-center gap-2 cursor-pointer p-1 hover:bg-white rounded transition-all group">
                                                <input type="checkbox" name="job_categories[]" value="{{ $child->id }}"
                                                    x-model="selectedValues.categories"
                                                    @change="sync('categories', {{ $child->id }}, [{{ $parent->id }}, {{ $grand->id }}], [], [{{ $childIds }}])"
                                                    class="w-3.5 h-3.5 text-orange-400 rounded border-orange-300">
                                                <span class="text-xs text-orange-500">{{ $child->name }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <template x-if="touched.categories && errors.categories">
                            <p class="text-red-600 text-xs mt-2 p-2 bg-red-50 border border-red-200 rounded-lg" x-text="errors.categories"></p>
                        </template>
                    </div>

                    <div class="bg-white p-3 rounded-2xl border border-orange-200 shadow-sm">
                        <label class="block text-base font-bold text-orange-600 mb-3">Khu vực làm việc *</label>
                        <div class="h-80 overflow-y-auto pr-3 custom-scrollbar space-y-4">
                            @foreach($locations as $region)
                            @php
                            $regionChildrenIds = $region->children->pluck('id')->merge($region->children->flatMap->children->pluck('id'))->join(',');
                            @endphp
                            <div class="p-3 bg-orange-50/30 rounded-2xl border border-orange-100/50">
                                <label class="flex items-center gap-3 cursor-pointer mb-3 group">
                                    <input type="checkbox" value="{{ $region->id }}" name="locations[]"
                                        x-model="selectedValues.locations"
                                        @change="sync('locations', {{ $region->id }}, [], [{{ $regionChildrenIds }}])"
                                        class="w-5 h-5 rounded-md text-orange-600 border-orange-300">
                                    <span class="text-sm font-black text-orange-800">{{ $region->name }}</span>
                                </label>

                                <div class="ml-7 space-y-4 border-l-2 border-orange-100/50 pl-4">
                                    @foreach($region->children as $prefecture)
                                    @php
                                    $districtIds = $prefecture->children->pluck('id')->join(',');
                                    $prefSiblings = $region->children->pluck('id')->join(',');
                                    @endphp
                                    <div>
                                        <label class="flex items-center gap-2 cursor-pointer group mb-2">
                                            <input type="checkbox" value="{{ $prefecture->id }}" name="locations[]"
                                                x-model="selectedValues.locations"
                                                @change="sync('locations', {{ $prefecture->id }}, [{{ $region->id }}], [{{ $districtIds }}], [{{ $prefSiblings }}])"
                                                class="w-4 h-4 text-orange-500 rounded border-orange-300">
                                            <span class="text-sm font-bold text-orange-700">{{ $prefecture->name }}</span>
                                        </label>

                                        <div class="ml-6 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                            @foreach($prefecture->children as $district)
                                            <label class="flex items-center gap-2 cursor-pointer p-1 hover:bg-white rounded transition-all group">
                                                <input type="checkbox" name="locations[]" value="{{ $district->id }}"
                                                    x-model="selectedValues.locations"
                                                    @change="sync('locations', {{ $district->id }}, [{{ $prefecture->id }}, {{ $region->id }}], [], [{{ $districtIds }}])"
                                                    class="w-3.5 h-3.5 text-orange-400 rounded border-orange-300">
                                                <span class="text-xs text-orange-500">{{ $district->name }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <template x-if="touched.locations && errors.locations">
                            <p class="text-red-600 text-xs mt-2 p-2 bg-red-50 border border-red-200 rounded-lg" x-text="errors.locations"></p>
                        </template>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-3 rounded-2xl border border-orange-200">
                        <label class="block text-sm font-bold text-purple-600 mb-3">Danh mục / Nhãn</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($jobLabels as $label)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="job_labels[]" value="{{ $label->id }}"
                                    {{ in_array($label->id, old('job_labels', $job?->labels?->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                                    class="hidden peer">
                                <span class="px-3 py-1.5 rounded-full border border-orange-300 text-xs font-medium cursor-pointer peer-checked:bg-purple-600 peer-checked:text-white transition">
                                    {{ $label->name }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white p-3 rounded-2xl border border-orange-200">
                        <label class="block text-sm font-bold text-green-600 mb-3">Kinh nghiệm</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($experiences as $exp)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="experiences[]" value="{{ $exp->id }}"
                                    {{ in_array($exp->id, old('experiences', $job?->experiences?->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                                    class="hidden peer">
                                <span class="px-3 py-1.5 rounded-full border border-orange-300 text-xs font-medium cursor-pointer peer-checked:bg-green-600 peer-checked:text-white transition">
                                    {{ $exp->name }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white p-3 rounded-2xl border border-orange-200">
                        <label class="block text-sm font-bold text-indigo-600 mb-3">Chiến dịch</label>
                        <div class="space-y-2 max-h-32 overflow-y-auto custom-scrollbar">
                            @foreach($campaigns as $cp)
                            <label class="flex items-center gap-2 cursor-pointer text-xs">
                                <input type="checkbox" name="campaigns[]" value="{{ $cp->id }}"
                                    {{ in_array($cp->id, old('campaigns', $job?->campaigns?->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                                    class="w-4 h-4 text-indigo-600 rounded">
                                <span>{{ $cp->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white p-3 rounded-2xl border border-orange-200">
                        <label class="block text-sm font-bold text-amber-600 mb-3">Job Fair / Sự kiện</label>
                        <div class="space-y-2 max-h-32 overflow-y-auto custom-scrollbar">
                            @foreach($jobFairs as $jf)
                            <label class="flex items-center gap-2 cursor-pointer text-xs">
                                <input type="checkbox" name="job_fairs[]" value="{{ $jf->id }}"
                                    {{ in_array($jf->id, old('job_fairs', $job?->jobFairs?->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}
                                    class="w-4 h-4 text-amber-600 rounded">
                                <span>{{ $jf->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div x-show="step === 2" x-transition class="space-y-3">
                <label class="block text-xs font-bold text-orange-500 uppercase tracking-wider mb-2">Thông tin nổi bật (Highlight)</label>
                <textarea name="highlight" rows="6" class="w-full rounded-2xl border border-orange-200 p-3 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-200 outline-none resize-y leading-relaxed"
                    placeholder="Những điểm thu hút nhất của công việc (mức lương cao, môi trường tốt, cơ hội thăng tiến...)">{{ old('highlight', $job?->extra_attributes['highlight'] ?? '') }}</textarea>
            </div>
            <div x-show="step === 3" x-transition class="space-y-3">
                <label class="block text-xs font-bold text-orange-500 uppercase tracking-wider mb-2">Mô tả công việc chi tiết</label>
                <textarea name="description" rows="8" class="w-full rounded-2xl border border-orange-200 p-3 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-200 outline-none resize-y leading-relaxed"
                    placeholder="Nhiệm vụ hàng ngày, trách nhiệm chính, yêu cầu kỹ năng, môi trường làm việc...">{{ old('job_description', $job?->extra_attributes['job_description'] ?? $job?->description ?? '') }}</textarea>
            </div>
            <div x-show="step === 4" x-transition class="space-y-6">
                <div>
                    <label class="block text-xs font-bold text-orange-500 uppercase tracking-wider mb-2">Yêu cầu ứng viên</label>
                    <textarea name="application_requirement" rows="3" class="w-full rounded-2xl border border-orange-200 p-4 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-200 outline-none resize-y"
                        placeholder="Kỹ năng, kinh nghiệm, trình độ cần có...">{{ old('application_requirement', $job?->extra_attributes['application_requirement'] ?? $job?->requirements ?? '') }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-orange-500 uppercase tracking-wider mb-2">Yêu cầu đặc biệt</label>
                    <textarea name="require" rows="3" class="w-full rounded-2xl border border-orange-200 p-4 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-200 outline-none resize-y"
                        placeholder="Kỹ năng, kinh nghiệm, trình độ cần có...">{{ old('application_requirement', $job?->extra_attributes['application_requirement'] ?? $job?->requirements ?? '') }}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-orange-50/40 p-3 rounded-2xl border border-dashed border-orange-200">
                        <label class="block text-[11px] font-black text-orange-800 uppercase tracking-widest mb-3">Trình độ tiếng Nhật</label>
                        <div x-data="{ levels: @js(old('levels', $job?->extra_attributes['levels'] ?? [])) }">
                            <template x-for="(lvl, idx) in levels" :key="idx">
                                <div class="flex gap-3 mb-2">
                                    <input type="text" :name="'levels['+idx+'][title]'" x-model="lvl.title" placeholder="VD: N2"
                                        class="w-5/12 rounded-xl border border-orange-200 p-2.5 text-sm outline-none focus:ring-1 focus:ring-orange-200">
                                    <input type="text" :name="'levels['+idx+'][note]'" x-model="lvl.note" placeholder="Ghi chú (ưu tiên...)"
                                        class="flex-1 rounded-xl border border-orange-200 p-2.5 text-sm outline-none focus:ring-1 focus:ring-orange-200">
                                    <button type="button" @click="levels.splice(idx, 1)" class="text-red-400 hover:text-red-600 px-2 text-lg font-bold">×</button>
                                </div>
                            </template>
                            <button type="button" @click="levels.push({title:'', note:''})"
                                class="mt-2 text-xs font-bold text-orange-600 hover:underline transition">
                                + Thêm trình độ
                            </button>
                        </div>
                    </div>
                    <div class="bg-orange-50/40 p-3 rounded-2xl border border-dashed border-orange-200">
                        <label class="block text-[11px] font-black text-orange-800 uppercase tracking-widest mb-3">Yêu cầu khác</label>
                        <div x-data="{ others: @js(old('require_others', $job?->extra_attributes['require_others'] ?? [])) }">
                            <template x-for="(item, idx) in others" :key="idx">
                                <div class="flex gap-3 mb-2">
                                    <input type="text" :name="'require_others['+idx+'][title]'" x-model="item.title" placeholder="VD: Có xe máy"
                                        class="w-5/12 rounded-xl border border-orange-200 p-2.5 text-sm outline-none focus:ring-1 focus:ring-orange-200">
                                    <input type="text" :name="'require_others['+idx+'][description]'" x-model="item.description" placeholder="Chi tiết (bắt buộc...)"
                                        class="flex-1 rounded-xl border border-orange-200 p-2.5 text-sm outline-none focus:ring-1 focus:ring-orange-200">
                                    <button type="button" @click="others.splice(idx, 1)" class="text-red-400 hover:text-red-600 px-2 text-lg font-bold">×</button>
                                </div>
                            </template>
                            <button type="button" @click="others.push({title:'', description:''})"
                                class="mt-2 text-xs font-bold text-orange-600 hover:underline transition">
                                + Thêm yêu cầu
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div x-show="step === 5" x-transition class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-orange-500 uppercase mb-1.5">Job ID</label>
                        <input type="text" name="id_job" disabled readonly value="{{ old('id_job', $job?->extra_attributes['id_job'] ?? '') }}"
                            class="w-full rounded-xl border border-orange-200 px-4 py-2.5 text-sm outline-none focus:border-orange-500 focus:ring-1">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-orange-500 mb-1.5">Thời gian ứng tuyển</label>
                            <input type="date" name="posting_period" value="{{ old('posting_period', $job?->extra_attributes['posting_period'] ?? '') }}"
                                class="w-full rounded-xl border border-orange-200 px-3 py-2.5 text-sm outline-none focus:border-orange-500 focus:ring-1">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-orange-500 mb-1.5">Thời gian kết thúc</label>
                            <input type="date" name="posting_ended" value="{{ old('posting_ended', $job?->extra_attributes['posting_ended'] ?? '') }}"
                                class="w-full rounded-xl border border-orange-200 px-3 py-2.5 text-sm outline-none focus:border-orange-500 focus:ring-1">
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-orange-500 uppercase tracking-wider mb-1.5">Mô tả tổng quan</label>
                    <textarea name="overview_description" rows="3" class="w-full rounded-2xl border border-orange-200 p-3 text-sm focus:border-orange-500 outline-none resize-y"
                        placeholder="Tổng quan ngắn gọn về công việc, công ty, môi trường...">{{ old('overview_description', $job?->extra_attributes['overview_description'] ?? '') }}</textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-orange-500 mb-1.5">Địa điểm làm việc</label>
                        <input type="text" name="work_address" value="{{ old('work_address', $job?->extra_attributes['work_address'] ?? '') }}"
                            class="w-full rounded-xl border border-orange-200 px-4 py-2.5 text-sm outline-none focus:border-orange-500 focus:ring-1">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-orange-500 mb-1.5">Phương tiện di chuyển</label>
                        <input type="text" name="work_by" value="{{ old('work_by', $job?->extra_attributes['work_by'] ?? '') }}"
                            class="w-full rounded-xl border border-orange-200 px-4 py-2.5 text-sm outline-none focus:border-orange-500 focus:ring-1"
                            placeholder="Tàu điện, xe buýt...">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-orange-500 mb-1.5">Loại hình nhân viên</label>
                        <input type="text" name="type_of_employment" value="{{ old('type_of_employment', $job?->extra_attributes['type_of_employment'] ?? '') }}"
                            class="w-full rounded-xl border border-orange-200 px-4 py-2.5 text-sm outline-none focus:border-orange-500 focus:ring-1"
                            placeholder="Full-time, Part-time...">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-orange-500 mb-1.5">Thời gian làm việc</label>
                        <input type="text" name="working_time" value="{{ old('working_time', $job?->extra_attributes['working_time'] ?? '') }}"
                            class="w-full rounded-xl border border-orange-200 px-4 py-2.5 text-sm outline-none focus:border-orange-500 focus:ring-1"
                            placeholder="9:00 - 18:00 (nghỉ trưa 60p)...">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-orange-500 mb-1.5">Ngày nghỉ</label>
                        <textarea name="annual_holiday" rows="3" class="w-full rounded-2xl border border-orange-200 p-3 text-sm focus:border-orange-500 outline-none resize-y"
                            placeholder="Thứ Bảy, CN, nghỉ lễ Nhật Bản...">{{ old('annual_holiday', $job?->extra_attributes['annual_holiday'] ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-orange-500 mb-1.5">Quyền lợi - Ưu đãi khác</label>
                        <textarea name="benefits_allowances" rows="3" class="w-full rounded-2xl border border-orange-200 p-3 text-sm focus:border-orange-500 outline-none resize-y"
                            placeholder="Thưởng, trợ cấp nhà ở, đi lại, bảo hiểm, đào tạo...">{{ old('benefits_allowances', $job?->extra_attributes['benefits_allowances'] ?? '') }}</textarea>
                    </div>
                </div>
                <div class="bg-orange-50/40 p-3 rounded-2xl border border-dashed border-orange-200">
                    <label class="block text-xs font-black text-orange-800 uppercase tracking-widest mb-3">Bảo hiểm</label>
                    <div x-data="{ insurances: @js(old('insurances', $job?->extra_attributes['insurances'] ?? [])) }">
                        <template x-for="(ins, idx) in insurances" :key="idx">
                            <div class="flex gap-3 mb-2">
                                <input type="text" :name="'insurances['+idx+'][name]'" x-model="ins.name" placeholder="VD: Bảo hiểm xã hội"
                                    class="w-5/12 rounded-xl border border-orange-200 p-2.5 text-sm outline-none focus:ring-1 focus:ring-orange-200">
                                <input type="text" :name="'insurances['+idx+'][note]'" x-model="ins.note" placeholder="Chi tiết..."
                                    class="flex-1 rounded-xl border border-orange-200 p-2.5 text-sm outline-none focus:ring-1 focus:ring-orange-200">
                                <button type="button" @click="insurances.splice(idx, 1)" class="text-red-400 hover:text-red-600 px-2 text-lg font-bold">×</button>
                            </div>
                        </template>
                        <button type="button" @click="insurances.push({name:'', note:''})"
                            class="mt-2 text-xs font-bold text-orange-600 hover:underline transition">
                            + Thêm bảo hiểm
                        </button>
                    </div>
                </div>
            </div>
            <div x-show="step === 6" x-transition>
                <label class="block text-[11px] font-bold text-orange-400 uppercase tracking-widest mb-4 text-center">Nội dung quy trình ứng tuyển</label>
                <textarea name="application_method" rows="8" class="w-full rounded-3xl border-2 border-orange-100 p-6 focus:border-orange-500 outline-none"
                    placeholder="VD: Gửi CV -> Phỏng vấn 1 -> Phỏng vấn 2...">{{ old('application_method', $job?->extra_attributes['application_method'] ?? '') }}</textarea>
            </div>
            <div x-show="step === 7" x-transition class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="bg-orange-900 p-3 rounded-2xl text-center">
                        <label class="block text-[10px] text-orange-400 font-bold uppercase mb-2 tracking-wider">Đơn vị tiền tệ *</label>
                        <select name="unit_salary" required
                            class="bg-transparent text-orange-400 font-bold text-lg outline-none w-full cursor-pointer">
                            <option value="" disabled {{ old('unit_salary', $job?->extra_attributes['unit_salary'] ?? '') ? '' : 'selected' }}>Chọn</option>
                            <option value="usd" {{ old('unit_salary', $job?->extra_attributes['unit_salary'] ?? '') == 'usd' ? 'selected' : '' }}>USD ($)</option>
                            <option value="vnd" {{ old('unit_salary', $job?->extra_attributes['unit_salary'] ?? '') == 'vnd' ? 'selected' : '' }}>VND (đ)</option>
                            <option value="jpy" {{ old('unit_salary', $job?->extra_attributes['unit_salary'] ?? 'jpy') == 'jpy' ? 'selected' : '' }}>JPY (¥)</option>
                        </select>
                        @error('unit_salary') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="bg-orange-50 p-3 rounded-2xl border border-orange-200">
                        <label class="block text-[10px] font-bold text-orange-500 uppercase mb-2 tracking-wider text-center">Lương tháng</label>
                        <div class="flex items-center gap-3">
                            <select name="by_level_salary" required
                                class="font-bold text-orange-500 text-base outline-none bg-transparent cursor-pointer">
                                <option value="" disabled {{ old('by_level_salary', $job?->extra_attributes['by_level_salary'] ?? '') ? '' : 'selected' }}>Chọn</option>
                                <option value="Upto" {{ old('by_level_salary', $job?->extra_attributes['by_level_salary'] ?? '') == 'Upto' ? 'selected' : '' }}>Upto</option>
                                <option value="Từ" {{ old('by_level_salary', $job?->extra_attributes['by_level_salary'] ?? '') == 'Từ' ? 'selected' : '' }}>Từ</option>
                                <option value="~" {{ old('by_level_salary', $job?->extra_attributes['by_level_salary'] ?? '') == '~' ? 'selected' : '' }}>~</option>
                            </select>
                            <input type="number" name="salary_by_month" min="0" step="1"
                                value="{{ old('salary_by_month', $job?->extra_attributes['salary_by_month'] ?? '') }}"
                                class="w-full bg-transparent text-2xl font-bold text-orange-800 outline-none border-b-2 border-orange-300 focus:border-orange-500 transition-all text-center"
                                placeholder="VD: 250000">
                        </div>
                        @error('salary_by_month') <p class="text-red-400 text-xs mt-1 text-center">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="bg-orange-50 p-4 rounded-2xl border border-orange-200">
                    <label class="block text-[10px] font-bold text-orange-500 uppercase mb-2 tracking-wider">Lương theo giờ</label>
                    <input type="text" name="salary_by_hour" value="{{ old('salary_by_hour', $job?->extra_attributes['salary_by_hour'] ?? '') }}"
                        class="w-full rounded-xl border border-orange-200 px-4 py-3 text-sm outline-none focus:border-orange-500 focus:ring-1"
                        placeholder="VD: 1500 ¥/giờ hoặc 120000 ₫/giờ">
                    <p class="text-xs text-orange-500 mt-1">Để trống nếu không áp dụng.</p>
                </div>
                <div class="bg-orange-50 p-4 rounded-2xl border border-orange-200">
                    <label class="block text-[10px] font-bold text-orange-500 uppercase mb-2 tracking-wider">Trợ cấp & ưu đãi khác</label>
                    <textarea name="salary_other_conditions" rows="3" class="w-full rounded-xl border border-orange-200 p-3 text-sm focus:border-orange-500 outline-none resize-y"
                        placeholder="Trợ cấp nhà ở, đi lại, ăn trưa, thưởng, bảo hiểm...">{{ old('salary_other_conditions', $job?->extra_attributes['salary_other_conditions'] ?? '') }}</textarea>
                    <p class="text-xs text-orange-500 mt-1">Liệt kê chi tiết nếu có.</p>
                </div>
            </div>
            <div x-show="step === 8" x-transition class="text-center py-8">
                <div class="w-20 h-20 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-orange-900 mb-2">Hoàn tất đăng tin</h2>
                <p class="text-orange-500 mb-6 text-sm">Bạn có thể tải lên tài liệu mô tả chi tiết nếu có</p>
                <div class="max-w-md mx-auto relative group">
                    <input type="url" name="pdf_url" value="{{ old('pdf_url', $job?->extra_attributes['pdf_url'] ?? '') }}"
                        class="w-full rounded-xl border border-orange-200 px-5 py-4 text-sm focus:border-orange-500 outline-none pr-12 transition-all"
                        placeholder="Link PDF (Google Drive, Dropbox...)">
                    <div class="absolute right-4 top-1/2 -tranorange-y-1/2 text-orange-400 group-focus-within:text-orange-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.5v-5H8l4-4 4 4h-3v5h-2zm4.25-10.75l-1.5-1.5L12 8.5l-1.75-1.75-1.5 1.5L12 11.5l3.25-3.25z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-orange-50/80 px-10 py-10 flex justify-between items-center border-t border-orange-100 backdrop-blur-md">
            <button type="button" x-show="step > 1" @click="step--"
                class="font-black text-orange-400 hover:text-orange-600 transition-colors uppercase tracking-[3px] text-xs">
                ← Quay lại
            </button>
            <div class="flex gap-4">
                <button type="button" x-show="step < 8" @click="nextStep()"
                    class="px-14 py-5 bg-orange-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-[3px] hover:bg-orange-600 transition-all shadow-xl active:scale-95">
                    Bước tiếp theo
                </button>
                <button type="submit" x-show="step === 8" @click="submitForm()"
                    class="px-16 py-5 bg-orange-600 text-white rounded-2xl font-black text-[10px] uppercase tracking-[3px] hover:bg-orange-700 transition-all shadow-xl shadow-orange-200">
                    Xác nhận & Lưu tin
                </button>
            </div>
        </div>
    </form>
</div>
<script>
    function jobForm() {
        return {
            step: 1,
            selectedValues: {
                categories: @js($job ? $job-> categories-> pluck('id')-> toArray() : []),
                locations: @js($job ? $job-> locations-> pluck('id')-> toArray() : []),
            },
            stepNames: ['Tổng quan', 'Nổi bật', 'Mô tả', 'Yêu cầu', 'Thông tin', 'Cách thức', 'Lương', 'Tài liệu'],
            errors: {},
            touched: {},
            validateCurrentStep() {
                this.errors = {};
                let isValid = true;
                this.touched = {};
                if (this.step === 1) {
                    const nameEl = document.querySelector('input[name="name"]');
                    if (!nameEl?.value.trim()) {
                        this.errors.name = 'Vui lòng nhập tên công việc';
                        isValid = false;
                    }
                    if (!document.querySelector('input[name="visas[]"]:checked')) {
                        this.errors.visa = 'Vui lòng chọn loại visa hỗ trợ';
                        isValid = false;
                    }
                    if (!this.selectedValues.categories || this.selectedValues.categories.length === 0) {
                        this.errors.categories = 'Vui lòng chọn ít nhất một ngành nghề';
                        isValid = false;
                    }
                    if (!this.selectedValues.locations || this.selectedValues.locations.length === 0) {
                        this.errors.locations = 'Vui lòng chọn ít nhất một khu vực làm việc';
                        isValid = false;
                    }
                }
                if (this.step === 7) {
                    if (!document.querySelector('select[name="unit_salary"]')?.value) {
                        this.errors.unit_salary = 'Vui lòng chọn đơn vị tiền tệ';
                        isValid = false;
                    }
                    if (!document.querySelector('select[name="by_level_salary"]')?.value) {
                        this.errors.by_level_salary = 'Vui lòng chọn loại mức lương';
                        isValid = false;
                    }
                }
                Object.keys(this.errors).forEach(key => {
                    this.touched[key] = true;
                });
                return isValid;
            },
            nextStep() {
                if (this.validateCurrentStep()) {
                    if (this.step < 8) {
                        this.step++;
                        window.scrollTo({
                            top: 0,
                            behavior: 'smooth'
                        });
                    }
                } else {
                    this.scrollToFirstError();
                }
            },
            submitForm() {
                const step1Valid = this.validateStep(1);
                const step7Valid = this.validateStep(7);
                if (step1Valid && step7Valid) {
                    document.getElementById('post-job-form').submit();
                } else {
                    if (!step1Valid) {
                        this.step = 1;
                        this.$nextTick(() => {
                            this.validateCurrentStep();
                            this.scrollToFirstError();
                        });
                    } else if (!step7Valid) {
                        this.step = 7;
                        this.$nextTick(() => {
                            this.validateCurrentStep();
                            this.scrollToFirstError();
                        });
                    }
                }
            },
            validateStep(targetStep) {
                const current = this.step;
                this.step = targetStep;
                const valid = this.validateCurrentStep();
                return valid;
            },
            scrollToFirstError() {
                this.$nextTick(() => {
                    const errorEl = document.querySelector('.text-red-500:not(:empty), [x-show*="errors."]');
                    if (errorEl) {
                        errorEl.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                });
            },
            toggleAll(section, parentId, childIds) {
                this.$nextTick(() => {
                    const isChecked = this.selectedValues[section].includes(Number(parentId));
                    const numericChildIds = childIds.map(id => Number(id));
                    numericChildIds.forEach(id => {
                        const index = this.selectedValues[section].indexOf(id);
                        if (isChecked) {
                            if (index === -1) this.selectedValues[section].push(id);
                        } else {
                            if (index !== -1) this.selectedValues[section].splice(index, 1);
                        }
                    });
                    if (this.step === 1) this.validateCurrentStep();
                });
            },
            sync(section, currentId, parentIds = [], childIds = [], siblingIds = []) {
                const numericId = Number(currentId);

                this.$nextTick(() => {
                    this.selectedValues[section] = this.selectedValues[section].map(Number);
                    const targetList = this.selectedValues[section];
                    const isChecked = targetList.includes(numericId);
                    if (childIds.length > 0) {
                        childIds.forEach(id => {
                            const nId = Number(id);
                            const idx = targetList.indexOf(nId);
                            if (isChecked && idx === -1) targetList.push(nId);
                            else if (!isChecked && idx !== -1) targetList.splice(idx, 1);
                        });
                    }
                    if (parentIds.length > 0) {
                        parentIds.forEach(pId => {
                            const nPId = Number(pId);
                            const pIdx = targetList.indexOf(nPId);

                            if (isChecked) {
                                if (pIdx === -1) targetList.push(nPId);
                            } else if (siblingIds.length > 0) {
                                const hasAnySibling = siblingIds.map(Number).some(sId => targetList.includes(sId));
                                if (!hasAnySibling && pIdx !== -1) {
                                    targetList.splice(pIdx, 1);
                                }
                            }
                        });
                    }
                    if (this.step === 1) this.validateCurrentStep();
                });
            }
        }
    }
</script>
<style>
    [x-cloak] {
        display: none !important;
    }

    input:focus,
    textarea:focus,
    select:focus {
        box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>
@endsection