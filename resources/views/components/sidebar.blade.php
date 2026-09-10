<aside class="sidebar">

    {{-- Logo --}}
    <div class="logo-area">
        <div class="logo-text">
            <span>POS</span>
            <b>System</b>
        </div>
    </div>

    {{-- Dashboard --}}
    <div class="nav-group">

        <a href="{{ url('/') }}" class="nav-link dashboard-link active">
            🏠 <span>DASHBOARD</span>
        </a>

       

        {{-- Inventory Dropdown --}}
        <div class="nav-parent" onclick="toggleMenu('inventory-menu', this)">
            <span>📦 &nbsp; INVENTORY</span>
            <span class="arrow">⌄</span>
        </div>

        <div class="nav-children" id="inventory-menu">
            <a href="#" class="nav-link">Category</a>
            <a href="#" class="nav-link">Subcategory</a>
            <a href="#" class="nav-link">Products</a>
        </div>

        <div class="nav-parent" onclick="toggleMenu('stock-menu', this)">
            <span>📦 &nbsp; Stock</span>
            <span class="arrow">⌄</span>
        </div>

        <div class="nav-children" id="stock-menu">
            <a href="#" class="nav-link">Stock In</a>
            <a href="#" class="nav-link">Stock Out</a>
            <a href="#" class="nav-link">Stock Transfer</a>
        </div>


        {{-- Purchase Dropdown --}}
        <div class="nav-parent" onclick="toggleMenu('purchase-menu', this)">
            <span>⊞ &nbsp; PURCHASE</span>
            <span class="arrow">⌄</span>
        </div>

        <div class="nav-children" id="purchase-menu">
            <a href="#" class="nav-link">Purchase Invoice</a>
            <a href="#" class="nav-link">Suppliers</a>
            <a href="#" class="nav-link">Purchase Return</a>
            <a href="#" class="nav-link">Purchase Order</a>
        </div>


        {{-- Sale Dropdown --}}
        <div class="nav-parent" onclick="toggleMenu('sale-menu', this)">
            <span>⊟ &nbsp; SALE</span>
            <span class="arrow">⌄</span>
        </div>

        <div class="nav-children" id="sale-menu">
            <a href="#" class="nav-link">Sale Invoice</a>
            <a href="#" class="nav-link">Customers</a>
            <a href="#" class="nav-link">Installment</a>
            <a href="#" class="nav-link">Warranty</a>
        </div>


        {{-- Accounts Dropdown --}}
        <div class="nav-parent" onclick="toggleMenu('accounts-menu', this)">
            <span>▣ &nbsp; ACCOUNTS</span>
            <span class="arrow">⌄</span>
        </div>

        <div class="nav-children" id="accounts-menu">
            <a href="#" class="nav-link">Income</a>
            <a href="#" class="nav-link">Expense</a>
            <a href="#" class="nav-link">Payments</a>
        </div>


        {{-- Report Dropdown --}}
        {{-- <div class="nav-parent" onclick="toggleMenu('report-menu', this)">
            <span>▤ &nbsp; REPORT</span>
            <span class="arrow">⌄</span>
        </div>

        <div class="nav-children" id="report-menu">
            <a href="#" class="nav-link">Sales Report</a>
            <a href="#" class="nav-link">Purchase Report</a>
            <a href="#" class="nav-link">Stock Report</a>
            <a href="#" class="nav-link">Payment Report</a>
        </div> --}}


        {{-- Settings --}}
        <div class="nav-parent settings-link" onclick="toggleMenu('settings-menu', this)">
            <span>⚙ &nbsp; SETTINGS</span>
            <span class="arrow">⌄</span>
        </div>
        <div class="nav-children" id="settings-menu">
            <a href="#" class="nav-link">Users/Roles</a>
          
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