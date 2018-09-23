<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle buttonLara -->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
          
	<div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            
			<!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  
                
				<span class="hidden-xs">
				<img style="width: 20px; height: 18px;" class="img-circle" src="data:image/png;base64,{{ chunk_split(base64_encode(\Auth::user()->pegawai->foto->isi)) }}" alt="User Avatar">
					{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
				</span>
                </a>
					<ul class="dropdown-menu">
					  <!-- User image -->
					  <li class="user-header">
						<img style="border: 1px solid white; padding: 2px; width: 80px; height: 80px;" class="img-circle" src="data:image/png;base64,{{ chunk_split(base64_encode(\Auth::user()->pegawai->foto->isi)) }}" alt="User Avatar">
						<p >
						  <font style="font-size:15px; color:#e0c200;">{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}</font>
						  <small style="color:#d7dff9;">{{ \Auth::user()->pegawai->history_jabatan->where('status','active')->first()->jabatan }}</small>
						</p>
					  </li>
					  <!-- Menu Body -->

					  <!-- Menu Footer-->
					  <li class="user-footer">
						<!--
						<div class="pull-left">
						  <a href="/profile/{{Auth::user()->name}}" class="btn btn-default btn-flat">Profile</a>
						</div>
						-->
						<div class="pull-right">
						  <a href="/bkpsdm_pare/public/logout" class="btn btn-default btn-flat">Sign out</a>
						</div>
					  </li>
					</ul>
            </li>
            
		</ul>
	</div>
</nav>