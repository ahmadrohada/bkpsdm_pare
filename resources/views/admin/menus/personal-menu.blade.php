



<!-- KAlo gak ada jabatan aktif ,menu jangan ditampilkan -->
@if (  \Auth::user()->pegawai->JabatanAktif != null )
	<li class="header">PERSONAL</li>

	<li>
		{!! HTML::icon_link( "personal", 'fa '.Lang::get('sidebar-nav.link_icon_home'), "<span>".Lang::get('sidebar-nav.link_title_home')."</span>", array('title' => Lang::get('sidebar-nav.link_title_home'))) !!}
	</li>


<!-- KAlo JFU/JFT , jangan tampilkan menu  ini -->
	@if ( \Auth::user()->Pegawai->JabatanAktif->Eselon->id_jenis_jabatan  <= 3 )
		<li>
			{!! HTML::icon_link( "personal/renja_approval-request", 'fa '.Lang::get('sidebar-nav.link_icon_approval-request'), "<span>".Lang::get('sidebar-nav.link_title_approval-request')."</span>", array('title' => Lang::get('sidebar-nav.link_title_approval-request'))) !!}
		</li>
	@endif					
@endif
						  



