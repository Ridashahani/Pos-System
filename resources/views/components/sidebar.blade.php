<aside
    class="w-[280px] bg-white text-[#1e1b2e] pt-5 pb-6 fixed top-0 left-0 h-screen overflow-y-auto shadow-[4px_0_20px_rgba(0,0,0,0.05)] border-r border-[#edebf3] transition-all duration-200">

    {{-- Profile --}}
    <div class="px-[30px] pb-[30px] pt-[5px] border-b border-[#edebf3] mb-4 text-lg flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div
                class="w-[42px] h-[42px] rounded-xl bg-[#6c63ff] text-white flex items-center justify-center font-bold text-[15px]">
                Pos</div>
            <div class="flex items-center gap-[5px]">
                <div class="text-[30px] font-medium text-[#1e1b2e]">Pos</div>
                <div class="text-[25px] text-[#363638] px-[10px] py-[3px] [transform:skew(-20deg)]">System</div>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <div class="px-4 flex flex-col gap-[3px]">

        {{-- Dashboard --}}
        <a href="{{ url('/') }}"
            class="dashboard-link {{ request()->is('/') ? 'active' : '' }} min-h-[46px] flex items-center justify-between px-4 text-[#8a8698] no-underline text-[14.5px] font-medium rounded-xl cursor-pointer transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff] [&.active]:bg-[#6c63ff] [&.active]:text-white [&.active]:shadow-[0_8px_16px_rgba(108,99,255,0.28)]">
            <span class="flex items-center gap-3">
                <svg class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M3 10l9-7 9 7" />
                    <path d="M5 9v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V9" />
                </svg>
                Dashboard
            </span>
        </a>

        @php $inventoryActive = request()->is('categories*', 'subcategories*', 'products*'); @endphp
        {{-- Inventory Dropdown --}}
        <div class="nav-parent {{ $inventoryActive ? 'active' : '' }} min-h-[46px] flex items-center justify-between px-4 text-[#8a8698] text-[14.5px] font-medium rounded-xl cursor-pointer transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff] [&.active]:bg-[#6c63ff] [&.active]:text-white [&.active]:shadow-[0_8px_16px_rgba(108,99,255,0.28)]"
            onclick="toggleMenu('inventory-menu', this)">
            <span class="flex items-center gap-3">
                <svg class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M21 8l-9-5-9 5 9 5 9-5z" />
                    <path d="M3 8v8l9 5 9-5V8" />
                </svg>
                Inventory
            </span>
            <span class="arrow text-[11px] transition-transform duration-[250ms] text-[#8a8698]" {{ $inventoryActive ? 'style=transform:rotate(90deg)' : '' }}>&#9654;</span>
        </div>
        <div class="{{ $inventoryActive ? 'flex' : 'hidden' }} flex-col pl-[30px] mt-[2px] mb-[6px] gap-[2px]" id="inventory-menu">
            <a href="/categories"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff] {{ request()->is('categories*') ? 'bg-[#efedff] text-[#6c63ff] font-semibold' : 'text-[#8a8698]' }}">Category</a>
            <a href="/subcategories"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff] {{ request()->is('subcategories*') ? 'bg-[#efedff] text-[#6c63ff] font-semibold' : 'text-[#8a8698]' }}">Subcategory</a>
            <a href="/products"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff] {{ request()->is('products*') ? 'bg-[#efedff] text-[#6c63ff] font-semibold' : 'text-[#8a8698]' }}">Products</a>
        </div>

        {{-- Stock Dropdown --}}
        <div class="nav-parent min-h-[46px] flex items-center justify-between px-4 text-[#8a8698] text-[14.5px] font-medium rounded-xl cursor-pointer transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff] [&.active]:bg-[#6c63ff] [&.active]:text-white [&.active]:shadow-[0_8px_16px_rgba(108,99,255,0.28)]"
            onclick="toggleMenu('stock-menu', this)">
            <span class="flex items-center gap-3">
                <svg class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect x="3" y="7" width="18" height="13" rx="2" />
                    <path d="M8 7V5a4 4 0 018 0v2" />
                </svg>
                Stock
            </span>
            <span class="arrow text-[11px] transition-transform duration-[250ms] text-[#8a8698]">&#9654;</span>
        </div>
        <div class="hidden flex-col pl-[30px] mt-[2px] mb-[6px] gap-[2px]" id="stock-menu">
            <a href="#"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg text-[#8a8698] no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff]">Stock
                In</a>
            <a href="#"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg text-[#8a8698] no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff]">Stock
                Out</a>
            <a href="#"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg text-[#8a8698] no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff]">Stock
                Transfer</a>
        </div>

        {{-- Purchase Dropdown --}}
        <div class="nav-parent min-h-[46px] flex items-center justify-between px-4 text-[#8a8698] text-[14.5px] font-medium rounded-xl cursor-pointer transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff] [&.active]:bg-[#6c63ff] [&.active]:text-white [&.active]:shadow-[0_8px_16px_rgba(108,99,255,0.28)]"
            onclick="toggleMenu('purchase-menu', this)">
            <span class="flex items-center gap-3">
                <svg class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M6 6h15l-1.5 9h-12z" />
                    <circle cx="9" cy="20" r="1" />
                    <circle cx="18" cy="20" r="1" />
                    <path d="M6 6L4 2H2" />
                </svg>
                Purchase
            </span>
            <span class="arrow text-[11px] transition-transform duration-[250ms] text-[#8a8698]">&#9654;</span>
        </div>
        <div class="hidden flex-col pl-[30px] mt-[2px] mb-[6px] gap-[2px]" id="purchase-menu">
            <a href="#"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg text-[#8a8698] no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff]">Purchase
                Invoice</a>
            <a href="#"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg text-[#8a8698] no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff]">Suppliers</a>
            <a href="#"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg text-[#8a8698] no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff]">Purchase
                Return</a>
            <a href="#"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg text-[#8a8698] no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff]">Purchase
                Order</a>
        </div>

        {{-- Sale Dropdown --}}
        <div class="nav-parent min-h-[46px] flex items-center justify-between px-4 text-[#8a8698] text-[14.5px] font-medium rounded-xl cursor-pointer transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff] [&.active]:bg-[#6c63ff] [&.active]:text-white [&.active]:shadow-[0_8px_16px_rgba(108,99,255,0.28)]"
            onclick="toggleMenu('sale-menu', this)">
            <span class="flex items-center gap-3">
                <svg class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path d="M3 3v18h18" />
                    <path d="M7 15l4-4 3 3 5-6" />
                </svg>
                Sale
            </span>
            <span class="arrow text-[11px] transition-transform duration-[250ms] text-[#8a8698]">&#9654;</span>
        </div>
        <div class="hidden flex-col pl-[30px] mt-[2px] mb-[6px] gap-[2px]" id="sale-menu">
            <a href="#"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg text-[#8a8698] no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff]">Sale
                Invoice</a>
            <a href="#"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg text-[#8a8698] no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff]">Customers</a>
            <a href="#"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg text-[#8a8698] no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff]">Installment</a>
            <a href="#"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg text-[#8a8698] no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff]">Warranty</a>
        </div>

        {{-- Accounts Dropdown --}}
        <div class="nav-parent min-h-[46px] flex items-center justify-between px-4 text-[#8a8698] text-[14.5px] font-medium rounded-xl cursor-pointer transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff] [&.active]:bg-[#6c63ff] [&.active]:text-white [&.active]:shadow-[0_8px_16px_rgba(108,99,255,0.28)]"
            onclick="toggleMenu('accounts-menu', this)">
            <span class="flex items-center gap-3">
                <svg class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="12" cy="12" r="9" />
                    <path d="M12 7v5l3 3" />
                </svg>
                Accounts
            </span>
            <span class="arrow text-[11px] transition-transform duration-[250ms] text-[#8a8698]">&#9654;</span>
        </div>
        <div class="hidden flex-col pl-[30px] mt-[2px] mb-[6px] gap-[2px]" id="accounts-menu">
            <a href="#"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg text-[#8a8698] no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff]">Income</a>
            <a href="#"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg text-[#8a8698] no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff]">Expense</a>
            <a href="#"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg text-[#8a8698] no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff]">Payments</a>
        </div>

        {{-- Settings Dropdown --}}
        <div class="nav-parent min-h-[46px] flex items-center justify-between px-4 text-[#8a8698] text-[14.5px] font-medium rounded-xl cursor-pointer transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff] [&.active]:bg-[#6c63ff] [&.active]:text-white [&.active]:shadow-[0_8px_16px_rgba(108,99,255,0.28)]"
            onclick="toggleMenu('settings-menu', this)">
            <span class="flex items-center gap-3">
                <svg class="w-[18px] h-[18px] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="12" cy="12" r="3" />
                    <path
                        d="M19.4 15a1.7 1.7 0 00.3 1.9l.1.1a2 2 0 11-2.8 2.8l-.1-.1a1.7 1.7 0 00-1.9-.3 1.7 1.7 0 00-1 1.5V21a2 2 0 11-4 0v-.1a1.7 1.7 0 00-1-1.6 1.7 1.7 0 00-1.9.3l-.1.1a2 2 0 11-2.8-2.8l.1-.1a1.7 1.7 0 00.3-1.9 1.7 1.7 0 00-1.5-1H3a2 2 0 110-4h.1a1.7 1.7 0 001.5-1 1.7 1.7 0 00-.3-1.9l-.1-.1a2 2 0 112.8-2.8l.1.1a1.7 1.7 0 001.9.3H9a1.7 1.7 0 001-1.5V3a2 2 0 114 0v.1a1.7 1.7 0 001 1.5 1.7 1.7 0 001.9-.3l.1-.1a2 2 0 112.8 2.8l-.1.1a1.7 1.7 0 00-.3 1.9V9a1.7 1.7 0 001.5 1H21a2 2 0 110 4h-.1a1.7 1.7 0 00-1.5 1z" />
                </svg>
                Settings
            </span>
            <span class="arrow text-[11px] transition-transform duration-[250ms] text-[#8a8698]">&#9654;</span>
        </div>
        <div class="hidden flex-col pl-[30px] mt-[2px] mb-[6px] gap-[2px]" id="settings-menu">
            <a href="#"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg text-[#8a8698] no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff]">Users/Roles</a>
            <a href="#"
                class="min-h-[36px] flex items-center px-3 text-[13.5px] font-normal rounded-lg text-[#8a8698] no-underline transition-all duration-150 hover:bg-[#efedff] hover:text-[#6c63ff]">Branches</a>
        </div>

    </div>

</aside>

<script>
    function toggleMenu(id, el) {
        const menu = document.getElementById(id);
        menu.classList.toggle('hidden');
        menu.classList.toggle('flex');
        el.classList.toggle('active');
        const arrow = el.querySelector('.arrow');
        if (arrow) arrow.style.transform = el.classList.contains('active') ? 'rotate(90deg)' : '';
    }
</script>
