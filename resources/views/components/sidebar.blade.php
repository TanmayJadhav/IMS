<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon m-1">
            <img src="/images/Logo.jpeg" width="70" height="70" alt="">
        </div>
        <div class="sidebar-brand-text mx-3">IMS</div>
    </a>

    @if (auth()->user()->role == 1)
        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <li class="nav-item">
            <a class="nav-link" href="/">
                <i class="fas fa-fw fa-table"></i>
                <span>Dashboard</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/shopadmin">
                <i class="fas fa-fw fa-table"></i>
                <span>Shop Admin</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/shopcategory">
                <i class="fas fa-fw fa-table"></i>
                <span>Shop Category</span></a>
        </li>


    @elseif (auth()->user()->role == 2)
        <li class="nav-item">
            <a class="nav-link" href="/client">
                <i class="fas fa-fw fa-table"></i>
                <span>Customers</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/quotation">
                <i class="fas fa-fw fa-table"></i>
                <span>Generate Quotation</span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="/sellproduct">
                <i class="fas fa-fw fa-table"></i>
                <span>Sell Product</span></a>
        </li>



    @else

        @php
            $shopadmin = App\Models\Shopadmin::where('mobile', auth()->user()->username)->first();
            
            $permissions_arr = [];
            $permission_id = json_decode($shopadmin->permission);
            
            foreach ($permission_id as $permission) {
                array_push($permissions_arr, $permission);
            }
            
        @endphp

        <li class="nav-item">
            <a class="nav-link" href="/">
                <i class="fas fa-fw fa-table"></i>
                <span>Dashboard</span></a>
        </li>
        @if (in_array(1, $permissions_arr))
            <li class="nav-item">
                <a class="nav-link" href="/vendors">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Suppliers</span></a>
            </li>
        @endif

        {{-- <li class="nav-item ">
            <a class="nav-link" href="/vendors/addproductcategory">
                <i class="fas fa-fw fa-table"></i>
                <span>Supplier Product </span>
                <span class="ml-4">Categeory</span>
            </a>
        </li> --}}
        @if (in_array(1, $permissions_arr))
            <li class="nav-item">
                <a class="nav-link" href="/product">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Products</span></a>
            </li>
        @endif

        @if (in_array(2, $permissions_arr))
            <li class="nav-item">
                <a class="nav-link" href="/client">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Customers</span></a>
            </li>
        @endif

        @if (in_array(3, $permissions_arr))
            <li class="nav-item">
                <a class="nav-link" href="/quotation">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Generate Quotation</span></a>
            </li>
        @endif

        @if (in_array(4, $permissions_arr))
            <li class="nav-item">
                <a class="nav-link" href="/sellproduct">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Sell Product</span></a>
            </li>
        @endif

        @if (in_array(5, $permissions_arr))
            <li class="nav-item">
                <a class="nav-link" href="/report">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Generate Reports</span></a>
            </li>
        @endif

        @if (in_array(6, $permissions_arr))
            <li class="nav-item">
                <a class="nav-link" href="/employee">
                    <i class="fas fa-user"></i>
                    <span>Employees</span></a>
            </li>
        @endif

        @if (in_array(7, $permissions_arr))
            <li class="nav-item">
                <a class="nav-link" href="/operator">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Operators</span></a>
            </li>
        @endif

        @if (in_array(8, $permissions_arr))
            <li class="nav-item ">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-file-invoice"></i>Expense
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="/reason">Reason</a>
                    <a class="dropdown-item" href="/expense">Expense List</a>
                </div>
            </li>
        @endif


    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
