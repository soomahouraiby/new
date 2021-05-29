<!-- Sidebar-->
<?php
$active_sidebar = isset($active_sidebar)? $active_sidebar : 'home';

?>
<div class="  bg-second" id="sidebar-wrapper">
    <div class="sidebar-heading border-bottom bg-second">نــظـــام إدارة الــبــلاغــات   </div>
    <div class="list-group list-group-flush">
        @if(auth()->user())
        <a class="list-group-item list-group-item-action p-3 {{$active_sidebar == 'home'? 'active': ''}} " href="{{ url('/') }}">
            <div><i class="bx bx-grid-alt nav_icon"></i>
                <span class="nav_name">لوحة التحكم</span></div>
        </a>
        @if(auth()->user()->hasRole('مدير العمليات'))

        <div class="nav-item dropdown">
            <a id="gh-toggler" href="#" class="nav-link   list-group-item list-group-item-action p-3" id="navbarDropdown"
             data-bs-toggle="collapse" data-bs-target="#ghsdfd" aria-controls="ghsdfd" aria-expanded="{{$active_sidebar == 'newReports'? 'true': 'false'}}" aria-label="Toggle navigation"
            >
            <div class="cof">
                <i class='bx bx-cctv nav_icon'></i>
                <span class="nav_name">  بلاغات وارده</span>
            </div>
            <i class='bx bxs-chevron-left nav_icon left-dor'></i>
            </a>
            <div  class="collapse navbar-collapse {{$active_sidebar == 'newReports'? 'show': ''}}" id="ghsdfd"  >
                <a class="dropdown-item {{$active_sidebar == 'newReports'? 'active': ''}}" href="{{route('OP_newReports')}}">
                        <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name">جميع البلاغات</span>
                </a>
                <a class="dropdown-item  {{$active_sidebar == 'newReports'? 'active': ''}}" href="{{route('OP_newSmuggledReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> مهرب</span>
                </a>
                <a class="dropdown-item" href="{{route('OP_newDrownReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> مسحوب</span>
                </a>
                <a class="dropdown-item" href="{{route('OP_newDiffrentReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> غير مطابق</span>
                </a>
                <a class="dropdown-item" href="{{route('OP_newExceptionReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> مستثناء </span>
                </a>
            </div>

        </div>
        <a class="list-group-item list-group-item-action p-3  " href="{{ url('OP_addReport') }}">
            <div>
                <i class='bx bxs-bookmark-alt-plus nav_icon'></i>
                <span class="nav_name">إضافة بلاغ جديد </span></div>
        </a>
        <div class="nav-item dropdown">
            <a id="gh-toggler" href="#" class="nav-link   list-group-item list-group-item-action p-3" id="navbarDropdown"
             data-bs-toggle="collapse" data-bs-target="#OP_followReports" aria-controls="OP_followReports" aria-expanded="{{$active_sidebar == 'newReports'? 'true': 'false'}}" aria-label="Toggle navigation"
            >
            <div class="cof">
                <i class='bx bxs-binoculars nav_icon'></i>
                <span class="nav_name"> إدارة ومتابعه</span>
            </div>
            <i class='bx bxs-chevron-left nav_icon left-dor'></i>
            </a>
            <div  class="collapse navbar-collapse" id="OP_followReports"  >
                <a class="dropdown-item " href="{{route('OP_followReports')}}">
                        <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> الجميع</span>
                </a>
                <a class="dropdown-item  "  href="{{route('OP_transferFollowingReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> محول للمتابعة</span>
                </a>
                <a class="dropdown-item" href="{{route('OP_followingReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> قيد المتابعة</span>
                </a>
                <a class="dropdown-item" href="{{route('OP_followDoneReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name">  تم متابعتها</span>
                </a>
                <a class="dropdown-item" href="{{route('OP_doneReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> تم انهائها </span>
                </a>
            </div>

        </div>
        <a class="list-group-item list-group-item-action p-3  " href="{{route('OP_Reports')}}">
            <div>
                <i class='bx bxs-detail nav_icon'></i>
                <span class="nav_name">  التقارير </span></div>
        </a>
        @elseif(auth()->user()->hasRole('مدير الصيدلة'))
        <div class="nav-item dropdown">
            <a id="gh-toggler" href="#" class="nav-link   list-group-item list-group-item-action p-3" id="navbarDropdown"
             data-bs-toggle="collapse" data-bs-target="#PM_newReports" aria-controls="PM_newReports" aria-expanded="false" aria-label="Toggle navigation"
            >
            <div class="cof">
                <i class='bx bx-cctv nav_icon'></i>
                <span class="nav_name">  بلاغات وارده</span>
            </div>
            <i class='bx bxs-chevron-left nav_icon left-dor'></i>
            </a>
            <div  class="collapse navbar-collapse" id="PM_newReports"  >
                <a class="dropdown-item " href="{{route('PM_newReports')}}">
                        <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name">جميع البلاغات</span>
                </a>
                <a class="dropdown-item  " href="{{route('PM_newSmuggledReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> مهرب</span>
                </a>
                <a class="dropdown-item" href="{{route('PM_newDrownReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> مسحوب</span>
                </a>
                <a class="dropdown-item" href="{{route('PM_newDifferentReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> غير مطابق</span>
                </a>
                <a class="dropdown-item" href="{{route('PM_newExceptionReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> مستثناء </span>
                </a>
            </div>
        </div>
        <a class="list-group-item list-group-item-action p-3  " href="{{route('PM_drug')}}">
            <div>
                <i class='bx bx-capsule nav_icon'></i>
                <span class="nav_name">  ادارة الادوية </span></div>
        </a>

        <div class="nav-item dropdown">
            <a id="gh-toggler" href="#" class="nav-link   list-group-item list-group-item-action p-3" id="navbarDropdown"
             data-bs-toggle="collapse" data-bs-target="#PM_followReports" aria-controls="PM_followReports" aria-expanded="false" aria-label="Toggle navigation"
            >
            <div class="cof">
                <i class='bx bx-cctv nav_icon'></i>
                <span class="nav_name">   متابعة البلاغات</span>
            </div>
            <i class='bx bxs-chevron-left nav_icon left-dor'></i>
            </a>
            <div  class="collapse navbar-collapse" id="PM_followReports"  >
                <a class="dropdown-item " href="{{route('PM_followReports')}}">
                        <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name">الجميع </span>
                </a>
                <a class="dropdown-item" href="{{route('PM_followingReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> قيد المتابعة</span>
                </a>
                <a class="dropdown-item" href="{{route('PM_followDoneReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name">  تم متابعتها</span>
                </a>
            </div>
        </div>
        <a class="list-group-item list-group-item-action p-3  " href="#">
            <div>
                <i class='bx bxs-detail nav_icon'></i>
                <span class="nav_name">  التقارير </span></div>
        </a>

        @elseif(auth()->user()->hasRole('مدير التيقظ الدوائي'))
        <div class="nav-item dropdown">
            <a id="gh-toggler" href="#" class="nav-link   list-group-item list-group-item-action p-3" id="navbarDropdown"
             data-bs-toggle="collapse" data-bs-target="#PHC_newReports" aria-controls="PHC_newReports" aria-expanded="false" aria-label="Toggle navigation"
            >
            <div class="cof">
                <i class='bx bx-cctv nav_icon'></i>
                <span class="nav_name">  بلاغات وارده</span>
            </div>
            <i class='bx bxs-chevron-left nav_icon left-dor'></i>
            </a>
            <div  class="collapse navbar-collapse" id="PHC_newReports"  >
                <a class="dropdown-item " href="{{route('PHC_newReports')}}">
                        <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name">جميع البلاغات</span>
                </a>
                <a class="dropdown-item  " href="{{route('PHC_newEffectReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> اعراض جانبية</span>
                </a>
                <a class="dropdown-item" href="{{route('PHC_newQualityReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> جودة</span>
                </a>
            </div>
        </div>

        <div class="nav-item dropdown">
            <a id="gh-toggler" href="#" class="nav-link   list-group-item list-group-item-action p-3" id="navbarDropdown"
             data-bs-toggle="collapse" data-bs-target="#PHC_followReports" aria-controls="PHC_followReports" aria-expanded="false" aria-label="Toggle navigation"
            >
            <div class="cof">
                <i class='bx bxs-binoculars nav_icon'></i>
                <span class="nav_name"> إدارة ومتابعه</span>
            </div>
            <i class='bx bxs-chevron-left nav_icon left-dor'></i>
            </a>
            <div  class="collapse navbar-collapse" id="PHC_followReports"  >
                <a class="dropdown-item " href="{{route('PHC_followReports')}}">
                        <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> الجميع</span>
                </a>

                <a class="dropdown-item" href="{{route('PHC_followingReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> قيد المتابعة</span>
                </a>

                <a class="dropdown-item" href="{{route('PHC_doneReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> تم انهائها </span>
                </a>
            </div>

        </div>
        <a class="list-group-item list-group-item-action p-3  " href="{{route('PHC_Reports')}}">
            <div>
                <i class='bx bxs-detail nav_icon'></i>
                <span class="nav_name">  التقارير </span></div>
        </a>

        @elseif(auth()->user()->hasRole('المدير العام'))
        <div class="nav-item dropdown">
            <a id="gh-toggler" href="#" class="nav-link   list-group-item list-group-item-action p-3" id="navbarDropdown"
             data-bs-toggle="collapse" data-bs-target="#showReports" aria-controls="showReports" aria-expanded="false" aria-label="Toggle navigation"
            >
            <div class="cof">
                <i class='bx bxs-binoculars nav_icon'></i>
                <span class="nav_name"> إدارة ومتابعه</span>
            </div>
            <i class='bx bxs-chevron-left nav_icon left-dor'></i>
            </a>
            <div  class="collapse navbar-collapse" id="showReports"  >
                <a class="dropdown-item " href="{{route('showReports')}}">
                        <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> الجميع</span>
                </a>
                <a class="dropdown-item  "  href="{{route('showNewReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name">  واردة</span>
                </a>
                <a class="dropdown-item  "  href="{{route('showTransferReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> محول للمتابعة</span>
                </a>
                <a class="dropdown-item" href="{{route('showFollowingReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> قيد المتابعة</span>
                </a>
                <a class="dropdown-item" href="{{route('showFollowDoneReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name">  تم متابعتها</span>
                </a>
                <a class="dropdown-item" href="{{route('showDoneReports')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name"> تم انهائها </span>
                </a>
            </div>
        </div>
        <a class="list-group-item list-group-item-action p-3  " href="{{route('users.index')}}">
            <div>
                <i class='bx bxs-group nav_icon'></i>
                <span class="nav_name">   إدارة المستخدمين </span></div>
        </a>

        <div class="nav-item dropdown">
            <a id="gh-toggler" href="#" class="nav-link   list-group-item list-group-item-action p-3" id="navbarDropdown"
             data-bs-toggle="collapse" data-bs-target="#all_drugs" aria-controls="all_drugs" aria-expanded="false" aria-label="Toggle navigation"
            >
            <div class="cof">
                <i class='bx bx-capsule nav_icon'></i>
                <span class="nav_name">  ادارة الادوية</span>
            </div>
            <i class='bx bxs-chevron-left nav_icon left-dor'></i>
            </a>
            <div  class="collapse navbar-collapse" id="all_drugs"  >
                <a class="dropdown-item " href="{{route('all_drugs')}}">
                        <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name">  جميع الادوية</span>
                </a>
                <a class="dropdown-item  "  href="{{route('all_companies')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name">  الشركات</span>
                </a>
                <a class="dropdown-item  "  href="{{route('all_agents')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name">  الوكلاء</span>
                </a>
                <a class="dropdown-item" href="{{route('all_effective_materials')}}">
                    <i class='bx bx-grid-small nav_icon'></i>
                        <span class="nav_name">  المواد الفعالة</span>
                </a>

            </div>
        </div>

        <a class="list-group-item list-group-item-action p-3  " href="{{route('batch_numbers')}}">
            <div>
                <i class='bx bxs-ambulance nav_icon'></i>
                <span class="nav_name">  ادارة الدفعات </span></div>
        </a>

        <a class="list-group-item list-group-item-action p-3  " href="#">
            <div>
                <i class='bx bxs-detail nav_icon'></i>
                <span class="nav_name">  التقارير </span></div>
        </a>
        @endif
        @endif
    </div>
</div>
