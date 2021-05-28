  <!-- Top navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark   " >
    <div class="container-fluid">
        <button class=" header_toggle  " id="sidebarToggle"><i class="bx bx-menu" id="header-toggle"></i></button>
        <button class="navbar-toggler rounded-navbar" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class='bx bx-dots-vertical-rounded'></i></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                <!-- <li class="nav-item active"><a class="nav-link" href="#!">Home</a></li> -->
                <!-- <li class="nav-item"><a class="nav-link" href="#!">Link</a></li> -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">تسجيل الدخول</a>
                </li>
                @else
                <li class="nav-item dropdown">


                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='bx bx-user'></i>  {{ Auth::user()->name }}</a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">الملف الشخصي</a>
                        <a class="dropdown-item" href="#">تعديل</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                               تسجيل الخروج
                            </a>
                    </div>
                </li>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                @endguest
                @auth
                @if(auth()->user()->hasRole('مدير الصيدلة'))
                    <li class="dropdown dropdown-notification nav-item  dropdown-notifications" >
                        <a class="nav-link nav-link-label" href="{{url('PM_newReports')}}" data-toggle="dropdown" >
                            <i class="fa fa-bell" style="color: white"> </i>
                            <span
                                class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow
                                 notif-count" data-count="0" style="background-color: white ; color: #0F122D">0</span>
                        </a>
                               <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right" style="background-color: white ; color: #0F122D">
                                                    <li class="scrollable-container ps-container ps-active-y media-list w-100" style="background-color: white ; color: #0F122D">
                                                        <a href="{{route('PM_newReports')}}">
                                                            <div class="media" style="background-color: white ; color: #0F122D">
                                                                <div class="media-body" style="background-color: white ; color: #0F122D">
                                                                    <h6 class="media-heading text-right " style="background-color: white ; color: #0F122D; margin-left: 30%">اطلاع </h6>
                                                                </div>
                                                            </div>
                                                        </a>

                                                    </li>
                                                </ul>
                    </li>

                    @endif
                    @endauth

            </ul>
        </div>
    </div>
</nav>
