<x-filament::page>
    <div x-data="{ 
        isOpen: false, 
        currentApp: null,
        openDrawer(app) {
            this.currentApp = app;
            this.isOpen = true;
            document.body.style.overflow = 'hidden';
        },
        closeDrawer() {
            this.isOpen = false;
            document.body.style.overflow = 'auto';
        }
    }" class="relative">

        <div class="mb-6">
            <form method="GET" class="flex flex-wrap items-center gap-3 p-4 bg-white border border-gray-300 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex-1 min-w-[240px]">
                    <input type="text" name="f_name" value="{{ request('f_name') }}" placeholder="Search candidate name..."
                        class="block w-full h-10 transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 border-gray-300 dark:border-gray-600 sm:text-sm">
                </div>
                <div class="flex items-center gap-2">
                    <x-filament::button type="submit" size="sm">Filter</x-filament::button>
                    <x-filament::button tag="a" href="{{ route('filament.pages.manage-applications') }}" color="secondary" outlined size="sm">Reset</x-filament::button>
                </div>
            </form>
        </div>

        <div class="overflow-hidden bg-white border border-gray-300 shadow-sm rounded-xl dark:bg-gray-800 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-left table-auto divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-900/50">
                            <th class="px-6 py-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest">Candidate</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest">Job ID</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest">Contact</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest">Applied At</th>
                            <th class="px-6 py-4 text-[10px] font-bold text-gray-500 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($applications['data'] ?? [] as $app)
                        @php
                        $user = $app['user'] ?? [];
                        $profile = $user['profile'] ?? [];
                        $userName = $profile['full_name'] ?? ($user['name'] ?? 'Anonymous');
                        $createdAt = isset($app['created_at']) ? \Carbon\Carbon::parse($app['created_at'])->format('M d, Y H:i') : 'N/A';
                        @endphp
                        <tr class="group hover:bg-gray-50 dark:hover:bg-gray-700/30 cursor-pointer transition-colors"
                            @click="openDrawer({{ json_encode($app) }})">

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $profile['avatar'] ?? 'https://ui-avatars.com/api/?background=random&name=' . urlencode($userName) }}"
                                        class="w-10 h-10 rounded-full object-cover border border-gray-200 dark:border-gray-600 shadow-sm">
                                    <div class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-primary-600 transition-colors">
                                        {{ $userName }}
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-xs font-mono font-medium text-primary-600 dark:text-primary-400">
                                {{ $app['job_id'] ?? 'N/A' }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-[11px] text-gray-600 dark:text-gray-400 font-medium">{{ $user['email'] }}</div>
                                <div class="text-[10px] text-gray-400">{{ $profile['phone'] ?? 'No Phone' }}</div>
                            </td>

                            <td class="px-6 py-4 text-xs font-medium text-gray-600 dark:text-gray-400">
                                {{ $createdAt }}
                            </td>

                            <td class="px-6 py-4 text-right" @click.stop>
                                <x-filament::button tag="a"
                                    href="{{ ($app['cv_url'] === 'profile_only') ? '#' : $app['cv_url'] }}"
                                    target="{{ ($app['cv_url'] === 'profile_only') ? '_self' : '_blank' }}"
                                    size="sm" outlined
                                    color="{{ ($app['cv_url'] === 'profile_only') ? 'secondary' : 'primary' }}">
                                    {{ ($app['cv_url'] === 'profile_only') ? 'No PDF' : 'View CV' }}
                                </x-filament::button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400 font-medium">No candidates found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($this->getPaginator())
            <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                {{ $this->getPaginator()->links() }}
            </div>
            @endif
        </div>

        <div x-cloak x-show="isOpen" class="fixed inset-0 z-[999]" role="dialog" aria-modal="true">
            <div x-show="isOpen" x-transition:enter="ease-in duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-out duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="closeDrawer()"></div>

            <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div x-show="isOpen" x-transition:enter="transform transition ease-in-out duration-500" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                    class="w-screen max-w-md md:max-w-2xl bg-white dark:bg-gray-900 shadow-2xl flex flex-col border-l dark:border-gray-800">

                    <div class="px-6 py-5 border-b dark:border-gray-800 flex items-center justify-between bg-gray-50/50 dark:bg-gray-800/50">
                        <div>
                            <h2 class="text-lg font-bold dark:text-white">Candidate Details</h2>
                            <p class="text-[10px] text-gray-400 font-medium uppercase tracking-tighter"
                                x-text="'Job ID: ' + (currentApp?.job_id || 'N/A')"></p>
                        </div>
                        <button @click="closeDrawer()" class="text-gray-400 hover:text-gray-600 dark:hover:text-white text-3xl font-light leading-none">&times;</button>
                    </div>

                    <div class="flex-1 overflow-y-auto custom-scrollbar p-8">
                        <template x-if="currentApp">
                            <div class="space-y-8">
                                <div class="flex items-center gap-6">
                                    <img :src="currentApp?.user?.profile?.avatar || 'https://ui-avatars.com/api/?background=6366f1&color=fff&name=' + (currentApp?.user?.profile?.full_name || 'User')"
                                        class="w-24 h-24 rounded-2xl shadow-md border-2 border-white dark:border-gray-700 object-cover">
                                    <div>
                                        <h3 class="text-2xl font-black dark:text-white leading-tight" x-text="currentApp?.user?.profile?.full_name || currentApp?.user?.name"></h3>
                                        <p class="text-primary-600 font-bold text-sm uppercase tracking-wide" x-text="currentApp?.user?.profile?.current_job_title || 'Candidate'"></p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-800/50 border dark:border-gray-700">
                                        <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Email Address</span>
                                        <span class="text-xs font-semibold dark:text-gray-300 break-all" x-text="currentApp?.user?.email"></span>
                                    </div>
                                    <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-800/50 border dark:border-gray-700">
                                        <span class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Phone Number</span>
                                        <span class="text-xs font-semibold dark:text-gray-300" x-text="currentApp?.user?.profile?.phone || 'N/A'"></span>
                                    </div>
                                </div>

                                <section>
                                    <h4 class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em] border-b dark:border-gray-800 pb-2 mb-3 italic">Professional Summary</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed font-medium whitespace-pre-line" x-text="currentApp?.user?.profile?.summary || 'No summary provided.'"></p>
                                </section>

                                <section x-show="currentApp?.user?.profile?.experiences?.length > 0">
                                    <h4 class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em] border-b dark:border-gray-800 pb-2 mb-4 italic text-primary-600">Work Experience</h4>
                                    <div class="space-y-6">
                                        <template x-for="exp in currentApp?.user?.profile?.experiences" :key="exp.id">
                                            <div class="border-l-2 border-gray-200 dark:border-gray-700 pl-4 py-1">
                                                <div class="text-sm font-bold dark:text-white" x-text="exp.position"></div>
                                                <div class="text-xs text-gray-500 font-medium" x-text="exp.company_name"></div>
                                                <div class="text-[10px] text-gray-400" x-text="exp.start_date + ' - ' + (exp.is_current ? 'Present' : exp.end_date)"></div>
                                            </div>
                                        </template>
                                    </div>
                                </section>
                            </div>
                        </template>
                    </div>

                    <div class="p-6 border-t dark:border-gray-800 bg-gray-50/30 dark:bg-gray-900">
                        <template x-if="currentApp?.cv_url && currentApp.cv_url !== 'profile_only'">
                            <a :href="currentApp.cv_url" target="_blank"
                                class="flex items-center justify-center w-full px-6 py-3 text-sm font-bold tracking-widest text-white uppercase transition-colors duration-75 rounded-lg shadow-lg bg-primary-600 hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                Download PDF Resume
                            </a>
                        </template>
                        <p x-show="!currentApp?.cv_url || currentApp?.cv_url === 'profile_only'" class="text-center text-xs text-gray-400 italic">No resume file attached</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        [role="navigation"] p {
            margin-right: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
        }
    </style>
</x-filament::page>