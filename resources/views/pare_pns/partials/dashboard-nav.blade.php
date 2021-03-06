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
				@if (  \Auth::user()->pegawai->foto != null )
					<img style="width: 20px; height: 18px;" class="img-circle" src="data:image/png;base64,{{ chunk_split(base64_encode(\Auth::user()->pegawai->foto->isi)) }}" alt="User Avatar">
				@else
					@if ( \Auth::user()->pegawai->jenis_kelamin == 'Perempuan')
				 		<img style="width: 20px; height: 18px;" class="img-circle" src="{{asset('assets/images/form/female_icon.png')}}" alt="User Avatar">
					@else
						<img style="width: 20px; height: 18px;" class="img-circle" src="{{asset('assets/images/form/male_icon.png')}}" alt="User Avatar">
					@endif
				@endif

				
					{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}
				</span>
                </a>
					<ul class="dropdown-menu">
					  <!-- User image -->
					  <li class="user-header">
						@if (  \Auth::user()->pegawai->foto != null )
							<img style="border: 1px solid white; padding: 2px; width: 80px; height: 80px;" class="img-circle" src="data:image/png;base64,{{ chunk_split(base64_encode(\Auth::user()->pegawai->foto->isi)) }}" alt="User Avatar">
						@else
							@if ( \Auth::user()->pegawai->jenis_kelamin == 'Perempuan')
								<img style="border: 1px solid white; padding: 2px; width: 80px; height: 80px;" class="img-circle" src="{{asset('assets/images/form/female_icon.png')}}" alt="User Avatar">
							@else
								<img style="border: 1px solid white; padding: 2px; width: 80px; height: 80px;" class="img-circle" src="{{asset('assets/images/form/male_icon.png')}}" alt="User Avatar">
							@endif
						@endif	
						
						<p >
						  <font style="font-size:15px; color:#e0c200;">{{ Pustaka::nama_pegawai(\Auth::user()->pegawai->gelardpn , \Auth::user()->pegawai->nama , \Auth::user()->pegawai->gelarblk)  }}</font>
						  <small style="color:#d7dff9;">
						  {{-- @if (  \Auth::user()->pegawai->JabatanAktif->Jabatan != null )
						  	{{ Pustaka::capital_string(\Auth::user()->pegawai->JabatanAktif->Jabatan->skpd ) }}
						  @else
							<span class="text-danger">Tidak Ada Jabatan Aktif </span>
						  @endif --}}
						  
						
						
							</small>
						</p>
					  </li>
					  <!-- Menu Body -->

					  <!-- Menu Footer-->
					  <li class="user-footer">
						<!--
						<div class="pull-left">
						  <a href="/profile/{{Auth::user()->name}}" class="btn btn-default ">Profile</a>
						</div>
						-->
						<div class="pull-right">
						  <a href="./../logout" class="btn btn-default ">Sign out</a>
						</div>
					  </li>
					</ul>
            </li>
            
		</ul>
	</div>
</nav>