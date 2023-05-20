<?php
    $settings = get_setting();
    if(isset($settings['admin_light_logo']))
    $admin_logo = asset('storage/site/'.$settings['admin_light_logo']);
    else
    $admin_logo =  asset('img/logo_white.png');
?>
<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{route('dashboard')}}">
            <div class="logo-img">
               <img height="30" src="{{$admin_logo}}" class="header-brand-img" title="{{$settings['title']}}"> 
            </div>
        </a>
        <div class="sidebar-action"><i class="ik ik-arrow-left-circle"></i></div>
        <button id="sidebarClose" class="nav-close"><i class="ik ik-x"></i></button>
    </div>

    @php
         $segment1 = request()->segment(1);
         $segment2 = request()->segment(2);
         $segment3 = request()->segment(3);

    @endphp
    
    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-item {{ ($segment1 == 'dashboard') ? 'active' : '' }}">
                    <a href="{{route('dashboard')}}"><i class="ik ik-bar-chart-2"></i><span>{{ __('Dashboard')}}</span></a>
                </div>
                <div class="nav-lavel">{{ __('Admin Area')}} </div>
                <!-- <div class="nav-item {{ ($segment1 == 'pos') ? 'active' : '' }}">
                    <a href="{{url('inventory')}}"><i class="ik ik-shopping-cart"></i><span>{{ __('Inventory')}}</span> <span class=" badge badge-success badge-right">{{ __('New')}}</span></a>
                </div>
                <div class="nav-item {{ ($segment1 == 'pos') ? 'active' : '' }}">
                    <a href="{{url('pos')}}"><i class="ik ik-printer"></i><span>{{ __('POS')}}</span> <span class=" badge badge-success badge-right">{{ __('New')}}</span></a>
                </div> -->
                <div class="nav-item {{ ($segment1 == 'users' || $segment1 == 'roles'||$segment1 == 'permission' ||$segment1 == 'user') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-user"></i><span>{{ __('Adminstrator')}}</span></a>
                    <div class="submenu-content">
                        <!-- only those have manage_user permission will get access -->
                        @can('manage_user')
                        <a href="{{url('users')}}" class="menu-item {{ ($segment1 == 'users') ? 'active' : '' }}">{{ __('Users')}}</a>
                        <a href="{{url('user/create')}}" class="menu-item {{ ($segment1 == 'user' && $segment2 == 'create') ? 'active' : '' }}">{{ __('Add User')}}</a>
                         @endcan
                         <!-- only those have manage_role permission will get access -->
                        @can('manage_roles')
                        <a href="{{url('roles')}}" class="menu-item {{ ($segment1 == 'roles') ? 'active' : '' }}">{{ __('Roles')}}</a>
                        @endcan
                        <!-- only those have manage_permission permission will get access -->
                        @can('manage_permission')
                        <a href="{{url('permission')}}" class="menu-item {{ ($segment1 == 'permission') ? 'active' : '' }}">{{ __('Permission')}}</a>
                        @endcan
                    </div>
                </div>


                <div class="nav-lavel">{{ __('Publisher Tools')}} </div>
    
                <div class="nav-item {{ ($segment1 == 'servers') ? 'active open' : '' }} has-sub">
            <a href="#"><i class="ik ik-user"></i><span>{{ __('Servers')}}</span></a>
                <div class="submenu-content">
                    @can('manage_user')
                    <a href="{{url('servers/add')}}" class="menu-item {{ ($segment2 == 'add' && $segment1 == 'servers' ) ? 'active' : '' }}">{{ __('Add Servers')}}</a>
                    @endcan
                    @can('manage_roles')
                    <a href="{{url('servers/list')}}" class="menu-item {{ ($segment1 == 'servers' && $segment2 == 'list') ? 'active' : '' }}">{{ __('View Servers')}}</a>
                    @endcan
                </div>
        </div>


                <div class="nav-item {{ ($segment1 == 'drama') ? 'active open' : '' }} has-sub">
                    <a href="#"><i class="ik ik-user"></i><span>{{ __('Dramas')}}</span></a>
                    <div class="submenu-content">
                        <!-- only those have manage_user permission will get access -->
                        @can('manage_user')
                        <a href="{{url('drama/add')}}" class="menu-item {{ ($segment1 == 'drama' && $segment2 == 'add') ? 'active' : '' }}">{{ __('Add Drama')}}</a>
                         @endcan
                         <!-- only those have manage_role permission will get access -->
                        @can('manage_roles')
                        <a href="{{url('drama/list')}}" class="menu-item {{ ($segment1 == 'drama' && $segment2 == 'list') ? 'active' : '' }}">{{ __('View Dramas')}}</a>
                        @endcan
                        <!-- only those have manage_permission permission will get access -->

                        @can('manage_roles')
                        <a href="{{url('drama/fetch')}}" class="menu-item {{ ($segment1 == 'drama' && $segment2 == 'fetch' && $segment3 == '') ? 'active' : '' }}">{{ __('Fetch Dramas')}}</a>
                        @endcan
                        <!-- only those have manage_permission permission will get access -->


                        @can('manage_roles')
                        <a href="{{url('drama/fetch/episodes')}}" class="menu-item {{ ($segment3 == 'episodes') ? 'active' : '' }}">{{ __('Fetch Episode')}}</a>
                        @endcan
                        <!-- only those have manage_permission permission will get access -->
                    </div>
                </div>

     <div class="nav-item {{ ($segment1 == 'movies') ? 'active open' : '' }} has-sub">
            <a href="#"><i class="ik ik-user"></i><span>{{ __('Movies')}}</span></a>
                <div class="submenu-content">
                    @can('manage_user')
                    <a href="{{url('movies/add')}}" class="menu-item {{ ($segment1 == 'movies' && $segment2 == 'add') ? 'active' : '' }}">{{ __('Add Movie')}}</a>
                    @endcan
                    @can('manage_roles')
                    <a href="{{url('movies/list')}}" class="menu-item {{ ($segment1 == 'movies' && $segment2 == 'list') ? 'active' : '' }}">{{ __('View Movies')}}</a>
                    @endcan
                    @can('manage_roles')
                    <a href="{{url('movies/fetch')}}" class="menu-item {{ ($segment2 == 'fetch' && $segment3 == '') ? 'active' : '' }}">{{ __('Fetch Movie')}}</a>
                    @endcan
                    @can('manage_roles')
                    <a href="{{url('movies/fetch/video')}}" class="menu-item {{ ($segment3 == 'video') ? 'active' : '' }}">{{ __('Fetch Videos')}}</a>
                    @endcan
                </div>
        </div>

        <div class="nav-item {{ ($segment1 == 'tags') ? 'active open' : '' }} has-sub">
                <a href="#"><i class="ik ik-user"></i><span>{{ __('Tags')}}</span></a>
                <div class="submenu-content">
                    @can('manage_user')
                    <a href="{{url('tags/add')}}" class="menu-item {{ ($segment2 == 'add' && $segment1 == 'tags' ) ? 'active' : '' }}">{{ __('Add Tags')}}</a>
                    @endcan
                    @can('manage_roles')
                    <a href="{{url('tags/list')}}" class="menu-item {{ ($segment1 == 'tags' && $segment2 == 'list') ? 'active' : '' }}">{{ __('View Tags')}}</a>
                    @endcan
                </div>
        </div>
    
    <div class="nav-item {{ ($segment1 == 'countries') ? 'active open' : '' }} has-sub">
            <a href="#"><i class="ik ik-user"></i><span>{{ __('Country')}}</span></a>
                <div class="submenu-content">
                    @can('manage_user')
                    <a href="{{url('countries/add')}}" class="menu-item {{ ($segment2 == 'add' && $segment1 == 'countries' ) ? 'active' : '' }}">{{ __('Add Country')}}</a>
                    @endcan
                    @can('manage_roles')
                    <a href="{{url('countries/list')}}" class="menu-item {{ ($segment1 == 'countries' && $segment2 == 'list') ? 'active' : '' }}">{{ __('View Country')}}</a>
                    @endcan
                </div>
        </div>

        <div class="nav-item {{ ($segment1 == 'genre') ? 'active open' : '' }} has-sub">
            <a href="#"><i class="ik ik-user"></i><span>{{ __('Genre')}}</span></a>
                <div class="submenu-content">
                    @can('manage_user')
                    <a href="{{url('genre/add')}}" class="menu-item {{ ($segment2 == 'add' && $segment1 == 'genre' ) ? 'active' : '' }}">{{ __('Add Genre')}}</a>
                    @endcan
                    @can('manage_roles')
                    <a href="{{url('genre/list')}}" class="menu-item {{ ($segment1 == 'genre' && $segment2 == 'list') ? 'active' : '' }}">{{ __('View Genre')}}</a>
                    @endcan
                </div>
        </div>

        <div class="nav-item {{ ($segment1 == 'cms-pages') ? 'active open' : '' }} has-sub">
            <a href="#"><i class="ik ik-user"></i><span>{{ __('CMS Pages')}}</span></a>
                <div class="submenu-content">
                    @can('manage_user')
                    <a href="{{url('cms-pages/add')}}" class="menu-item {{ ($segment2 == 'add' && $segment1 == 'cms-pages' ) ? 'active' : '' }}">{{ __('Add CMS Pages')}}</a>
                    @endcan
                    @can('manage_roles')
                    <a href="{{url('cms-pages/list')}}" class="menu-item {{ ($segment1 == 'cms-pages' && $segment2 == 'list') ? 'active' : '' }}">{{ __('View CMS Pages')}}</a>
                    @endcan
                </div>
        </div>

        <!-- <div class="nav-item {{ ($segment1 == 'menus') ? 'active open' : '' }} has-sub">
            <a href="#"><i class="ik ik-user"></i><span>{{ __('Menu Links')}}</span></a>
                <div class="submenu-content">
                    @can('manage_user')
                    <a href="{{url('menus/add')}}" class="menu-item {{ ($segment2 == 'add' && $segment1 == 'menus' ) ? 'active' : '' }}">{{ __('Add Menu Links')}}</a>
                    @endcan
                    @can('manage_roles')
                    <a href="{{url('menus/list')}}" class="menu-item {{ ($segment1 == 'menus' && $segment2 == 'list') ? 'active' : '' }}">{{ __('View Menu Links')}}</a>
                    @endcan
                </div>
        </div> -->

         <div class="nav-item {{ ($segment1 == 'slider') ? 'active open' : '' }} has-sub">
            <a href="#"><i class="ik ik-user"></i><span>{{ __('Home Page Slider')}}</span></a>
                <div class="submenu-content">
                    @can('manage_user')
                    <a href="{{url('slider/add')}}" class="menu-item {{ ($segment2 == 'add' && $segment1 == 'slider' ) ? 'active' : '' }}">{{ __('Add Slide')}}</a>
                    @endcan
                    @can('manage_roles')
                    <a href="{{url('slider/list')}}" class="menu-item {{ ($segment1 == 'slider' && $segment2 == 'list') ? 'active' : '' }}">{{ __('View Slide')}}</a>
                    @endcan
                </div>
        </div>

             <div class="nav-item {{ ($segment1 == 'publisher') ? 'active open' : '' }} has-sub">
            <a href="#"><i class="ik ik-user"></i><span>{{ __('Publisher')}}</span></a>
                <div class="submenu-content">
                    @can('manage_user')
                    <a href="{{url('publisher/add')}}" class="menu-item {{ ($segment2 == 'add' && $segment1 == 'publisher' ) ? 'active' : '' }}">{{ __('Add Publisher')}}</a>
                    @endcan
                    @can('manage_roles')
                    <a href="{{url('publisher/list')}}" class="menu-item {{ ($segment1 == 'publisher' && $segment2 == 'list') ? 'active' : '' }}">{{ __('View Publisher')}}</a>
                    @endcan
                </div>
        </div>
        <div class="nav-item {{ ($segment1 == 'site-setting') ? 'active open' : '' }}">
                <a href="{{url('site-setting/add')}}"><i class="ik ik-user"></i><span>{{ __('Site Setting')}}</span></a>
                
        </div>

        <div class="nav-item {{ ($segment1 == 'site_pages_meta') ? 'active open' : '' }}">
                <a href="{{url('site_pages_meta/')}}"><i class="ik ik-user"></i><span>{{ __('Site Pages Meta')}}</span></a>
                
        </div>

                

        </div>
    </div>
</div>