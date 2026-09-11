<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-10">
    <div class="flex items-center gap-[5px]">
        @php
            $parts = explode(' ', trim(View::yieldContent('page-title', 'Pos System')), 2);
        @endphp
        <div class="text-[30px] font-medium text-[#1e1b2e]">{{ $parts[0] }}</div>
        <div class="text-[25px] text-[#363638] px-[10px] py-[3px] [transform:skew(-20deg)]">{{ $parts[1] ?? '' }}</div>
    </div>

    <div class="flex items-center gap-4">


        <button class="relative p-2 rounded-full hover:bg-gray-100">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path
                    d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
        </button>

        <div class="flex items-center gap-2 cursor-pointer">
            <div
                class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-semibold">
                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
            </div>
            <span class="text-sm text-gray-700">{{ auth()->user()->name ?? 'Admin' }}</span>
        </div>
    </div>
</header>
