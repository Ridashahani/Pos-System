<aside class="sidebar">

    {{-- Profile --}}
    <div class="logo-area">
        <div class="profile-info">
            <div class="profile-avatar">Pos</div>
            <div class="profile-details">
                <div class="profile-name">Pos</div>
                <div class="profile-role">System</div>
            </div>
        </div>
    </div>

   

    {{-- Navigation --}}
    <div class="nav-group">

        {{-- Dashboard --}}
        <a href="{{ url('/') }}" class="nav-link dashboard-link active">
            <span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 10l9-7 9 7"/><path d="M5 9v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V9"/></svg>
                Dashboard
            </span>
        </a>

        {{-- Inventory Dropdown --}}
        <div class="nav-parent" onclick="toggleMenu('inventory-menu', this)">
            <span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 8l-9-5-9 5 9 5 9-5z"/><path d="M3 8v8l9 5 9-5V8"/></svg>
                Inventory
            </span>
            <span class="arrow">&#9654;</span>
        </div>
        <div class="nav-children" id="inventory-menu">
            <a href="#" class="nav-link">Category</a>
            <a href="#" class="nav-link">Subcategory</a>
            <a href="#" class="nav-link">Products</a>
        </div>

        {{-- Stock Dropdown --}}
        <div class="nav-parent" onclick="toggleMenu('stock-menu', this)">
            <span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M8 7V5a4 4 0 018 0v2"/></svg>
                Stock
            </span>
            <span class="arrow">&#9654;</span>
        </div>
        <div class="nav-children" id="stock-menu">
            <a href="#" class="nav-link">Stock In</a>
            <a href="#" class="nav-link">Stock Out</a>
            <a href="#" class="nav-link">Stock Transfer</a>
        </div>

        {{-- Purchase Dropdown --}}
        <div class="nav-parent" onclick="toggleMenu('purchase-menu', this)">
            <span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 6h15l-1.5 9h-12z"/><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/><path d="M6 6L4 2H2"/></svg>
                Purchase
            </span>
            <span class="arrow">&#9654;</span>
        </div>
        <div class="nav-children" id="purchase-menu">
            <a href="#" class="nav-link">Purchase Invoice</a>
            <a href="#" class="nav-link">Suppliers</a>
            <a href="#" class="nav-link">Purchase Return</a>
            <a href="#" class="nav-link">Purchase Order</a>
        </div>

        {{-- Sale Dropdown --}}
        <div class="nav-parent" onclick="toggleMenu('sale-menu', this)">
            <span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M7 15l4-4 3 3 5-6"/></svg>
                Sale
            </span>
            <span class="arrow">&#9654;</span>
        </div>
        <div class="nav-children" id="sale-menu">
            <a href="#" class="nav-link">Sale Invoice</a>
            <a href="#" class="nav-link">Customers</a>
            <a href="#" class="nav-link">Installment</a>
            <a href="#" class="nav-link">Warranty</a>
        </div>

        {{-- Accounts Dropdown --}}
        <div class="nav-parent" onclick="toggleMenu('accounts-menu', this)">
            <span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                Accounts
            </span>
            <span class="arrow">&#9654;</span>
        </div>
        <div class="nav-children" id="accounts-menu">
            <a href="#" class="nav-link">Income</a>
            <a href="#" class="nav-link">Expense</a>
            <a href="#" class="nav-link">Payments</a>
        </div>

        {{-- Settings Dropdown --}}
        <div class="nav-parent settings-link" onclick="toggleMenu('settings-menu', this)">
            <span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 00.3 1.9l.1.1a2 2 0 11-2.8 2.8l-.1-.1a1.7 1.7 0 00-1.9-.3 1.7 1.7 0 00-1 1.5V21a2 2 0 11-4 0v-.1a1.7 1.7 0 00-1-1.6 1.7 1.7 0 00-1.9.3l-.1.1a2 2 0 11-2.8-2.8l.1-.1a1.7 1.7 0 00.3-1.9 1.7 1.7 0 00-1.5-1H3a2 2 0 110-4h.1a1.7 1.7 0 001.5-1 1.7 1.7 0 00-.3-1.9l-.1-.1a2 2 0 112.8-2.8l.1.1a1.7 1.7 0 001.9.3H9a1.7 1.7 0 001-1.5V3a2 2 0 114 0v.1a1.7 1.7 0 001 1.5 1.7 1.7 0 001.9-.3l.1-.1a2 2 0 112.8 2.8l-.1.1a1.7 1.7 0 00-.3 1.9V9a1.7 1.7 0 001.5 1H21a2 2 0 110 4h-.1a1.7 1.7 0 00-1.5 1z"/></svg>
                Settings
            </span>
            <span class="arrow">&#9654;</span>
        </div>
        <div class="nav-children" id="settings-menu">
            <a href="#" class="nav-link">Users/Roles</a>
            <a href="#" class="nav-link">Branches</a>
        </div>

    </div>

  

</aside>

<script>
    function toggleMenu(id, el) {
        const menu = document.getElementById(id);
        menu.classList.toggle('open');
        el.classList.toggle('active');
    }
</script>