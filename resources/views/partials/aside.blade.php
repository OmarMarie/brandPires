<style>
    .aside-menu .menu-nav .menu-item.menu-item-open > .menu-inner, .aside-menu .menu-nav .menu-item.menu-item-open > .menu-submenu {
        margin-left: 50px;
    }
</style>
<!--begin::Aside-->
<div class="aside aside-left  aside-fixed  d-flex flex-column flex-row-auto" id="kt_aside">
{{--  <!--begin::Brand-->
  <div class="brand flex-column-auto " id="kt_brand">
      <!--begin::Logo-->
      <a href="" class="brand-logo" style="padding: 17px 5px 0px 5px;">
          <h1 class="text-warning font-italic"> BrandPires</h1>
      </a>
      <!--end::Logo-->
      <!--begin::Toggle-->
      <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
              <span class="svg-icon svg-icon svg-icon-xl"><!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo1/dist/assets/media/svg/icons/Navigation/Angle-double-left.svg--><svg
                      xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                      height="24px" viewBox="0 0 24 24" version="1.1">
  <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
      <polygon points="0 0 24 0 24 24 0 24"/>
      <path
          d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
          fill="#000000" fill-rule="nonzero"
          transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) "/>
      <path
          d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
          fill="#000000" fill-rule="nonzero" opacity="0.3"
          transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) "/>
  </g>
</svg><!--end::Svg Icon--></span></button>
      <!--end::Toolbar-->
  </div>
  <!--end::Brand-->--}}

<!--begin::Aside Menu-->
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">

        <!--begin::Menu Container-->
        <div
            id="kt_aside_menu"
            class="aside-menu my-4 "
            data-menu-vertical="1"
            data-menu-scroll="1" data-menu-dropdown-timeout="500">
            <!--begin::Menu Nav-->
            <ul class="menu-nav ">
                @if(((Request::segment(2))== null ||(Request::segment(2))=='home'))
                    <?php $menu_item_active = 'menu-item-active' ?>
                @else
                    <?php $menu_item_active = null ?>
                @endif
                <li class="menu-item {{$menu_item_active}} " aria-haspopup="true"><a
                        href="{{ route('home', app()->getLocale()) }}" class="menu-link ">
                        <div class="icon-menu"><i class="fad fa-analytics left-icon-menu"></i></div>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>

                @can('company-list')
                    @if(((Request::segment(2))=='companies'||(Request::segment(3))=='contacts'||(Request::segment(2).'/'.Request::segment(3))=='company/attachments'))
                        <?php $menu_item_active = 'menu-item-active' ?>
                    @else
                        <?php $menu_item_active = null ?>
                    @endif
                    <li class="menu-item {{$menu_item_active}}" aria-haspopup="true">
                        <a href="{{ route('companies.index', app()->getLocale()) }}" class="menu-link ">
                            <div class="icon-menu"><i class="fad fa-city left-icon-menu"></i></div>
                            <span class="menu-text">Companies</span>
                        </a>
                    </li>
                @endcan
                @can('admin')
                    @if(((Request::segment(2))=='brands'||(Request::segment(3))=='packages' || (Request::segment(2).'/'.Request::segment(3))=='brand/attachments') )
                        <?php $menu_item_active = 'menu-item-active' ?>
                    @else
                        <?php $menu_item_active = null ?>
                    @endif
                    <li class="menu-item {{$menu_item_active}}" aria-haspopup="true">
                        <a href="{{ route('brands.index', app()->getLocale()) }}" class="menu-link ">
                            <div class="icon-menu"><i class="fad fa-tags left-icon-menu"></i></div>
                            <span class="menu-text">Brands</span>
                        </a>
                    </li>
                @endcan

                @can('admin')
                    @if(((Request::segment(2))=='packages'))
                        <?php $menu_item_active = 'menu-item-active' ?>
                    @else
                        <?php $menu_item_active = null ?>
                    @endif
                    <li class="menu-item {{$menu_item_active}}" aria-haspopup="true">
                        <a href="{{ route('packages.index', app()->getLocale()) }}" class="menu-link ">
                            <div class="icon-menu"><i class="fad fa-box-alt left-icon-menu"></i></div>
                            <span class="menu-text">Packages</span>
                        </a>
                    </li>
                @endcan

                @can('admin')
                    @if(((Request::segment(2))=='levels'))
                        <?php $menu_item_active = 'menu-item-active' ?>
                    @else
                        <?php $menu_item_active = null ?>
                    @endif
                    <li class="menu-item {{$menu_item_active}}" aria-haspopup="true">
                        <a href="{{ route('levels.index', app()->getLocale()) }}" class="menu-link ">
                            <div class="icon-menu"><i class="fad fa-signal-3 left-icon-menu"></i></div>
                            <span class="menu-text">levels</span>
                        </a>
                    </li>
                @endcan
                @can('admin')
                    @if(((Request::segment(2))=='tanks'))
                        <?php $menu_item_active = 'menu-item-active' ?>
                    @else
                        <?php $menu_item_active = null ?>
                    @endif
                    <li class="menu-item {{$menu_item_active}} " aria-haspopup="true">
                        <a href="{{ route('tanks.index', app()->getLocale()) }}" class="menu-link ">
                            <div class="icon-menu"><i class="fad fa-crosshairs left-icon-menu"></i></div>
                            <span class="menu-text">tanks </span>
                        </a>
                    </li>
                @endcan
                @can('admin')
                    @if(((Request::segment(2))=='bulks'))
                        <?php $menu_item_active = 'menu-item-active' ?>
                    @else
                        <?php $menu_item_active = null ?>
                    @endif
                    <li class="menu-item {{$menu_item_active}}" aria-haspopup="true">
                        <a href="{{ route('bulks.index', app()->getLocale()) }}" class="menu-link ">
                            <div class="icon-menu"><i class="fad fa-cubes left-icon-menu"></i></div>
                            <span class="menu-text">Bulks</span>
                        </a>
                    </li>
                @endcan
                @can('admin')
                    @if(((Request::segment(2))=='players'))
                        <?php $menu_item_active = 'menu-item-active' ?>
                    @else
                        <?php $menu_item_active = null ?>
                    @endif
                    <li class="menu-item {{$menu_item_active}}" aria-haspopup="true">
                        <a href="{{ route('players.index', app()->getLocale()) }}" class="menu-link ">
                            <div class="icon-menu"><i class="fad fa-gamepad left-icon-menu"></i></div>
                            <span class="menu-text">Players</span>
                        </a>
                    </li>
                @endcan
                {{--  @can('admin')
                       <li class="menu-item " aria-haspopup="true">
                           <a href="{{ route('employees.index', app()->getLocale()) }}" class="menu-link ">
                               <i class="fad fa-users-cog left-icon-menu"></i>
                               <span class="menu-text">Employee's</span>
                           </a>
                       </li>
                  @endcan--}}
                @can('admin')
                    @if(((Request::segment(2))=='users'))
                        <?php $menu_item_active = 'menu-item-active' ?>
                    @else
                        <?php $menu_item_active = null ?>
                    @endif
                    <li class="menu-item {{$menu_item_active}}" aria-haspopup="true">
                        <a href="{{ route('users.index', app()->getLocale()) }}" class="menu-link ">
                            <div class="icon-menu"><i class="fa fa-users left-icon-menu"></i></div>
                            <span class="menu-text">Users</span>
                        </a>
                    </li>
                @endcan

                @can('role-list')
                    @if(((Request::segment(2))=='roles'))
                        <?php $menu_item_active = 'menu-item-active' ?>
                    @else
                        <?php $menu_item_active = null ?>
                    @endif
                    <li class="menu-item {{$menu_item_active}}" aria-haspopup="true">
                        <a href="{{ route('roles.index', app()->getLocale()) }}" class="menu-link ">
                            <div class="icon-menu"><i class="fad fa-user-lock left-icon-menu"></i></div>
                            <span class="menu-text">Roles</span>
                        </a>
                    </li>
                @endcan
                @if(((Request::segment(2))=='bubblesProcesses'|| (Request::segment(2))=='logUsers'||(Request::segment(2))=='logCampaigns'))
                    <?php $menu_item_open = 'menu-item-open' ?>
                @else
                    <?php $menu_item_open = null ?>
                @endif
                <li class="menu-item  menu-item-submenu  {{$menu_item_open}}" aria-haspopup="true"
                    data-menu-toggle="hover">
                    <a href="javascript:;" class="menu-link menu-toggle">
                        <span class="svg-icon menu-icon">
                            <div class="icon-menu"><i class="fad fa-cabinet-filing left-icon-menu"></i></div>
                        </span>
                        <span class="menu-text">Logs</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="menu-submenu "><i class="menu-arrow"></i>
                        <ul class="menu-subnav">
                            @can('admin')
                                @if(((Request::segment(2))=='bubblesProcesses'))
                                    <?php $menu_item_active = 'menu-item-active' ?>
                                @else
                                    <?php $menu_item_active = null ?>
                                @endif
                                <li class="menu-item {{$menu_item_active}}" aria-haspopup="true">
                                    <a href="{{ route('bubblesProcesses.index', app()->getLocale()) }}"
                                       class="menu-link "><i class="menu-bullet menu-bullet-line"><span></span></i>
                                        <span class="menu-text">Bubbles Processes</span></a>
                                </li>
                            @endcan
                            {{--  @can('admin')
                                   <li class="menu-item " aria-haspopup="true"><a
                                               href="{{ route('bubblesTransferActions.index', app()->getLocale()) }}"
                                               class="menu-link "><i
                                                   class="menu-bullet menu-bullet-line"><span></span></i><span
                                                   class="menu-text">Bubbles Transfer Actions</span><span
                                                   class="menu-label">--}}{{--<span
                                                       class="label label-danger label-inline">new</span>--}}{{--</span></a>
                                   </li>
                              @endcan--}}
                            @can('admin')
                                @if(((Request::segment(2))=='logUsers'))
                                    <?php $menu_item_active = 'menu-item-active' ?>
                                @else
                                    <?php $menu_item_active = null ?>
                                @endif
                                <li class="menu-item {{$menu_item_active}}" aria-haspopup="true"><a
                                        href="{{ route('logUsers.index', app()->getLocale()) }}"
                                        class="menu-link "><i
                                            class="menu-bullet menu-bullet-line"><span></span></i><span
                                            class="menu-text">Users</span><span
                                            class="menu-label">{{--<span
                                                    class="label label-danger label-inline">new</span>--}}</span></a>
                                </li>
                            @endcan
                            @can('admin')
                                @if(((Request::segment(2))=='logCampaigns'))
                                    <?php $menu_item_active = 'menu-item-active' ?>
                                @else
                                    <?php $menu_item_active = null ?>
                                @endif
                                <li class="menu-item {{$menu_item_active}}" aria-haspopup="true"><a
                                        href="{{ route('logCampaigns.index', app()->getLocale()) }}"
                                        class="menu-link "><i
                                            class="menu-bullet menu-bullet-line"><span></span></i><span
                                            class="menu-text">Campaigns</span><span
                                            class="menu-label">{{--<span
                                                    class="label label-danger label-inline">new</span>--}}</span></a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>

                @can('admin')
                    @if(((Request::segment(2))=='countries'))
                        <?php $menu_item_active = 'menu-item-active' ?>
                    @else
                        <?php $menu_item_active = null ?>
                    @endif
                    <li class="menu-item {{$menu_item_active}}" aria-haspopup="true">
                        <a href="{{ route('countries.index', app()->getLocale()) }}" class="menu-link ">
                            <div class="icon-menu"><i class="fad fa-globe-asia left-icon-menu"></i></div>
                            <span class="menu-text">Countries</span>
                        </a>
                    </li>
                @endcan

            </ul>
            <!--end::Menu Nav-->
        </div>
        <!--end::Menu Container-->
    </div>
    <!--end::Aside Menu-->
</div>
<!--end::Aside-->
