@if (  \Auth::user()->pegawai->JabatanAktif != null )
	<li class="header"></li>
	<li class="treeview {{ (request()->segment(1) == 'personal') ? 'active' : '' }} ">
    	{!! HTML::icon_link( "", 'fa '.Lang::get('sidebar-nav.link_icon_home'), "<span>PERSONAL</span><i class='fa ".Lang::get('sidebar-nav.caret_folded')." pull-right'></i>", array('title' => Lang::get('sidebar-nav.link_title_home'),'data-toggle' => 'disabled')) !!}
		<ul class="treeview-menu">
			<li>
				{!! HTML::icon_link( "personal/skp", 'fa '.Lang::get('sidebar-nav.link_icon_skp'), Lang::get('sidebar-nav.link_title_skp'), array('title' => Lang::get('sidebar-nav.link_title_skp'),'data-toggle' => 'tooltip')) !!}
			</li>
			<li>
				{!! HTML::icon_link( "personal/capaian", 'fa '.Lang::get('sidebar-nav.link_icon_capaian'), Lang::get('sidebar-nav.link_title_capaian'), array('title' => Lang::get('sidebar-nav.link_title_capaian'),'data-toggle' => 'tooltip')) !!}
			</li>
			@if ( \Auth::user()->Pegawai->JabatanAktif->Eselon->id_jenis_jabatan  <= 3 )
				<li>
					{!! HTML::icon_link( "personal/approval", 'fa '.Lang::get('sidebar-nav.link_icon_approval-request'), "<span>".Lang::get('sidebar-nav.link_title_approval-request')."</span>", array('title' => Lang::get('sidebar-nav.link_title_approval-request'), 'data-toggle' => 'tooltip')) !!}
				</li>
			@endif
		</ul>
	</li>				
@endif
						  



