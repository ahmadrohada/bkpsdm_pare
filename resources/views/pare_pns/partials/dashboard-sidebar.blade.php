{{--  LEFT SIDEBAR WITH NAVIGATION AND LOGO --}}
<aside class="main-sidebar ">

    {{--  SIDEBAR: style can be found in sidebar.less --}}
    <section class="sidebar">

        
		
        {{-- SIDEBAR NAVIGATION: style sidebar.less --}}
        <ul class="sidebar-menu">

            

            <li class="{{ (request()->segment(1) == 'dashboard') ? 'active' : '' }}">
                {!! HTML::icon_link( "/dashboard", 'fa '.Lang::get('sidebar-nav.link_icon_dashboard'), "<span>".Lang::get('sidebar-nav.link_title_dashboard')."</span>", array('title' => Lang::get('sidebar-nav.link_title_dashboard'))) !!}
            </li>

			
			
          @if (Auth::user()->hasRole('administrator'))
			      @include('pare_pns.menus.administrator-menu')
          @endif
		  
		      
		  
          @if (Auth::user()->hasRole('admin_skpd'))
            @include('pare_pns.menus.admin-skpd-menu')
			    @endif
		  
          @if (Auth::user()->hasRole('personal'))
			      @include('pare_pns.menus.personal-menu')
			    @endif
		   

            <li class="header"></li>

            <li>
                {!! HTML::icon_link( "/logout", 'fa '.Lang::get('sidebar-nav.link_icon_logout'), "<span>".Lang::get('sidebar-nav.link_title_logout')."</span>", array('title' => Lang::get('sidebar-nav.link_title_logout'))) !!}
            </li>
          
          
        </ul>
    </section>
</aside>