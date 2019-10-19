{{--  LEFT SIDEBAR WITH NAVIGATION AND LOGO --}}
<aside class="main-sidebar ">

    {{--  SIDEBAR: style can be found in sidebar.less --}}
    <section class="sidebar">

        
		
        {{-- SIDEBAR NAVIGATION: style sidebar.less --}}
        <ul class="sidebar-menu">

            

            <li class="active">
                {!! HTML::icon_link( "/dashboard", 'fa '.Lang::get('sidebar-nav.link_icon_dashboard'), "<span>".Lang::get('sidebar-nav.link_title_dashboard')."</span>", array('title' => Lang::get('sidebar-nav.link_title_dashboard'))) !!}
            </li>

			
			
          @if (Auth::user()->hasRole('administrator'))
			      @include('admin.menus.administrator-menu')
          @endif
		  
		      
		  
          @if (Auth::user()->hasRole('admin_skpd'))
            @include('admin.menus.admin-skpd-menu')
			    @endif
		  
          @if (Auth::user()->hasRole('personal'))
			      @include('admin.menus.personal-menu')
			    @endif
		   

            <li class="header"></li>

            <li>
                {!! HTML::icon_link( "/logout", 'fa '.Lang::get('sidebar-nav.link_icon_logout'), "<span>".Lang::get('sidebar-nav.link_title_logout')."</span>", array('title' => Lang::get('sidebar-nav.link_title_logout'))) !!}
            </li>
          
          
        </ul>
    </section>
</aside>