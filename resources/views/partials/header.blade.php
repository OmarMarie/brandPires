<!--begin::Header-->
<div id="kt_header" class="header  header-fixed ">
    <!--begin::Container-->
    <div class=" container-fluid  d-flex align-items-stretch justify-content-between">
        <!--begin::Header Menu Wrapper-->
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">

        </div>
        <!--end::Header Menu Wrapper-->

        <!--begin::Topbar-->
        <div class="topbar">

            <!--begin::Languages-->
            <div class="dropdown">
                <!--begin::Toggle-->
                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                    <div class="btn btn-icon btn-clean btn-dropdown btn-lg btn-hover-dark mr-1">
                        <img class="h-20px w-20px rounded-sm"
                             @if (app()->getLocale() == 'en')
                             src="{{ asset('assets/media/svg/226-united-states.svg') }}"
                             @elseif(app()->getLocale() == 'ar')
                             src="{{ asset('assets/media/svg/saudi.svg') }}"
                             @endif alt=""/>
                    </div>
                </div>
                <!--end::Toggle-->

                <!--begin::Dropdown-->
                <div class="dropdown-menu p-0 m-0 dropdown-menu-anim-up dropdown-menu-sm dropdown-menu-right">
                    <!--begin::Nav-->
                    <ul class="navi navi-hover py-4">
                        <!--begin::Item-->
                        <li class="navi-item">
                            <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), 'en') }}"
                               class="navi-link">
                            <span class="symbol symbol-20 mr-3">
                <img src="{{ asset('assets/media/svg/226-united-states.svg') }}"
                     alt=""/>
            </span>
                                <span class="navi-text">English</span>
                            </a>
                        </li>
                        <!--end::Item-->

                        <!--begin::Item-->
                        <li class="navi-item active">
                            <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(), 'ar') }}"
                               class="navi-link">
            <span class="symbol symbol-20 mr-3">
                <img src="{{ asset('assets/media/svg/saudi.svg') }}"
                     alt=""/>
            </span>
                                <span class="navi-text">Arabic</span>
                            </a>
                        </li>
                        <!--end::Item-->


                    </ul>
                    <!--end::Nav-->
                </div>
                <!--end::Dropdown-->
            </div>
            <!--end::Languages-->

            <!--begin::User-->
            <div class="topbar-item">
                <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg btn-hover-dark px-2"
                     id="kt_quick_user_toggle">
                    <span
                        class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi, {{ auth()->user()->name }}</span>
                    <span
                        class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{-- auth()->user()->name --}}</span>
                    <span class="symbol symbol-35 symbol-danger">
		                        <span class="symbol-label font-size-h5 font-weight-bold "
                                      style="box-shadow: -5px -5px 9px 2px #b3b3b366">
                                    {{ucwords(substr(auth()->user()->name, 0, 1))}}
                                </span>
		                    </span>
                </div>
            </div>
            <!--end::User-->
        </div>
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>
<!--end::Header-->
