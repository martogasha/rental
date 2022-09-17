
<li class="nav-item dropdown header-profile">
    <a class="nav-link" href="#" role="button" data-toggle="dropdown">
        <div class="header-info">
            <span class="text-black">{{\Illuminate\Support\Facades\Auth::user()->name}}</span>
            @if(\Illuminate\Support\Facades\Auth::user()->role==0)
                <p class="fs-12 mb-0">Super Admin</p>

            @else
                <p class="fs-12 mb-0">Admin</p>

            @endif
        </div>
        <img  src="{{asset('public/images/profile/17.jpg')}}" width="20" alt=""/>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <a href="{{url('profile')}}" class="dropdown-item ai-icon">
            <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            <span class="ml-2">Profile </span>
        </a>
        <form action="{{route('logout')}}" method="post" id="logout">
            @csrf
            <a href="javascript:document.getElementById('logout').submit();" class="dropdown-item ai-icon">
                <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                <span class="ml-2">Logout </span>
            </a>
        </form>

    </div>
</li>
</ul>
</div>
</nav>
</div>
</div>

<!--**********************************
    Header end ti-comment-alt
***********************************-->

<!--**********************************
    Sidebar start
***********************************-->
<div class="deznav">
<div class="deznav-scroll">
    <ul class="metismenu" id="menu">
        @if(\Illuminate\Support\Facades\Auth::user()->check_one=='dash')
            <li><a class="has-arrow ai-icon" href="{{url('Dashboard')}}" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user()->check_two=='property')
            <li><a class="has-arrow ai-icon" href="{{url('property')}}" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Properties</span>
                </a>
            </li>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user()->check_three=='lease')
            <li><a class="has-arrow ai-icon" href="{{url('lease')}}" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Customer Lease</span>
                </a>
            </li>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user()->check_four=='transaction')

            <li><a class="has-arrow ai-icon" href="{{url('mpesaTransaction')}}" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Mpesa</span>
                </a>
            </li>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user()->check_four=='transaction')

            <li><a class="has-arrow ai-icon" href="{{url('bankTransaction')}}" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Bank</span>
                </a>
            </li>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user()->check_six=='role')

            <li><a class="has-arrow ai-icon" href="{{url('role')}}" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">User Roles</span>
                </a>
            </li>
        @endif
        @if(\Illuminate\Support\Facades\Auth::user()->check_seven=='terminated')
            <li><a class="has-arrow ai-icon" href="{{url('terminated')}}" aria-expanded="false">
                    <i class="flaticon-381-networking"></i>
                    <span class="nav-text">Terminated Lease</span>
                </a>
            </li>
        @endif

    </ul>

    <div class="copyright">
        <p>©All Rights Reserved</p>
        <p>by Icons Tech</p>
    </div>
</div>
