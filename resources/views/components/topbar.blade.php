@inject('getCurrentCategory', 'App\Http\Controllers\Controller')

<form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
    <div class="input-group">
        @if (auth()->user()->role == 1)
            <h3 class="text-primary"></h3>

        @elseif (auth()->user()->role == 2)

            @php
                $operator = DB::table('operators')
                    ->where('mobile', auth()->user()->username)
                    ->get();
                
                $shopadmin = DB::table('shopadmins')
                    ->where('id', $operator[0]->shopadmin_id)
                    ->get();
                
                $shop = DB::table('shops')
                    ->where('id', $shopadmin[0]->shop_id)
                    ->get();
            @endphp
            <h3 class="text-primary">{{ $shop[0]->name ?? '' }} </h3>

        @else

            @php
                $shopadmin = DB::table('shopadmins')
                    ->where('mobile', auth()->user()->username)
                    ->get();
                
                $shop = DB::table('shops')
                    ->where('id', $shopadmin[0]->shop_id)
                    ->get();
            @endphp
            <h3 class="text-primary">{{ $shop[0]->name ?? '' }} (Category =
                {{ App\Http\Controllers\Controller::getCurrentCategory() }}) </h3>
        @endif

    </div>
</form>

<ul class="navbar-nav ml-auto">


    <!-- Nav Item - Messages -->
    <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <h6 style="color: black; margin-top: 10px ; font-size: 17px"><i class="fas  fa-list-alt fa-fw"></i> Shop
                Category</h6>
            <!-- Counter - Messages -->

        </a>
        <!-- Dropdown - Messages -->
        @if (auth()->user()->role != 1)
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                    Choose Shop Category
                </h6>
                @php
                    $shopadmin = App\Models\Shopadmin::where('mobile', auth()->user()->username)->first();
                    
                    $permissions_arr = [];
                    $permission_id = json_decode($shopadmin->shopcategory);
                    
                    if (empty($permission_id)) {
                        array_push($permissions_arr, 'No Category Available');
                        session(['currentCategory' => 'No Category Available']);
                    } else {
                        foreach ($permission_id as $permission) {
                            array_push($permissions_arr, $permission);
                        }
                    }
                    
                @endphp

                @foreach ($permissions_arr as $item)
                    @if (App\Http\Controllers\Controller::getCurrentCategory() == $item)
                        <a class="dropdown-item bg-secondary d-flex align-items-center"
                            href="/set-category/{{ $item }}">
                            <div class="font-weight-bold">
                                <div class="text-truncate">{{ $item }}</div>
                            </div>
                        </a>
                    @elseif (App\Http\Controllers\Controller::getCurrentCategory() == 'No Category Available')
                        <div class="font-weight-bold">
                            <div class="text-truncate">No Category Available</div>
                        </div>
                    @else
                        <a class="dropdown-item  d-flex align-items-center" href="/set-category/{{ $item }}">
                            <div class="font-weight-bold">
                                <div class="text-truncate">{{ $item }}</div>
                            </div>
                        </a>
                    @endif

                @endforeach

            </div>
        @endif    
    </li>


    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">

        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            @if (auth()->user()->role == 1)
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Super Admin</span>

            @elseif (auth()->user()->role == 2)

                @php
                    $operator = DB::table('operators')
                        ->where('mobile', auth()->user()->username)
                        ->get();
                @endphp

                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $operator[0]->name }}</span>

            @else
                @php
                    $shopadmin = DB::table('shopadmins')
                        ->where('mobile', auth()->user()->username)
                        ->get();
                @endphp
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $shopadmin[0]->ownername }}</span>
                <img class="img-profile rounded-circle"
                    src="/uploads/profile/{{ $shopadmin[0]->id }}.{{ $shopadmin[0]->image_ext }}" height="120"
                    width="140" alt="">
            @endif
            {{-- <img class="img-profile rounded-circle" src="img/undraw_profile.svg"> --}}
        </a>
        <!-- Dropdown - User Information -->
        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            @if (auth()->user()->role == 1)
                @php
                    $user = DB::table('users')
                        ->select('id')
                        ->where('username', auth()->user()->username)
                        ->get();
                @endphp
                <a class="dropdown-item" href="/profile/{{ $user[0]->id }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
            @elseif (auth()->user()->role == 2)
            @else
                @php
                    $shopadmin = DB::table('shopadmins')
                        ->where('mobile', auth()->user()->username)
                        ->get();
                @endphp
                <a class="dropdown-item" href="/profile/{{ $shopadmin[0]->id }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
            @endif


            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
            </a>
        </div>
    </li>

</ul>
