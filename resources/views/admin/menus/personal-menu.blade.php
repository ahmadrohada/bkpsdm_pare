<li class="header">PERSONAL</li>

<li>
    {!! HTML::icon_link( "personal/skp-tahunan", 'fa '.Lang::get('sidebar-nav.link_icon_home'), "<span>".Lang::get('sidebar-nav.link_title_home')."</span>", array('title' => Lang::get('sidebar-nav.link_title_home'))) !!}
</li>


<!-- KAlo JFU/JFT , jangan tampilkan menu  ini -->
@if ( \Auth::user()->Pegawai->JabatanAktif->Eselon->id_jenis_jabatan  <= 3 )
	<li>
		{!! HTML::icon_link( "personal/renja_approval-request", 'fa '.Lang::get('sidebar-nav.link_icon_approval-request'), "<span>".Lang::get('sidebar-nav.link_title_approval-request')."</span>", array('title' => Lang::get('sidebar-nav.link_title_approval-request'))) !!}
	</li>
@endif


<!-- 
<li class="treeview">
    {!! HTML::icon_link( "personal/skp", 'fa '.Lang::get('sidebar-nav.link_icon_skp'), "<span>".Lang::get('sidebar-nav.link_title_skp')."</span><i class='fa ".Lang::get('sidebar-nav.caret_folded')." pull-right'></i>", array('title' => Lang::get('sidebar-nav.link_title_skp'))) !!}
    <ul class="treeview-menu">
        <li>
			{!! HTML::icon_link( "personal/skp-tahunan", 'fa '.Lang::get('sidebar-nav.link_icon_skp_tahunan'), Lang::get('sidebar-nav.link_title_skp_tahunan'), array('title' => Lang::get('sidebar-nav.link_title_skp_tahunan'))) !!}
		</li>
		<li>
			{!! HTML::icon_link( "personal/skp-bulanan", 'fa '.Lang::get('sidebar-nav.link_icon_skp_bulanan'), Lang::get('sidebar-nav.link_title_skp_bulanan'), array('title' => Lang::get('sidebar-nav.link_title_skp_bulanan'))) !!}
		</li>
	</ul>
</li> -->

