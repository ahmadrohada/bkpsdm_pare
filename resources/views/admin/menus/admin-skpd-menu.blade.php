<li class="header">ADMIN SKPD</li>

<li>
    {!! HTML::icon_link( "skpd/pegawai", 'fa '.Lang::get('sidebar-nav.link_icon_home'), "<span>".Lang::get('sidebar-nav.link_title_home')."</span>", array('title' => Lang::get('sidebar-nav.link_title_home'))) !!}
</li>

<li>
    {!! HTML::icon_link( "skpd/peta-jabatan", 'fa '.Lang::get('sidebar-nav.link_icon_peta_jabatan'), "<span>".Lang::get('sidebar-nav.link_title_peta_jabatan')."</span>", array('title' => Lang::get('sidebar-nav.link_title_peta_jabatan'))) !!}
</li>

<li>
    {!! HTML::icon_link( "skpd/distribusi-kegiatan", 'fa '.Lang::get('sidebar-nav.link_icon_distribusi_kegiatan'), "<span>".Lang::get('sidebar-nav.link_title_distribusi_kegiatan')."</span>", array('title' => Lang::get('sidebar-nav.link_title_distribusi_kagiatan'))) !!}
</li>

<li>
    {!! HTML::icon_link( "skpd/perjanjian-kinerja", 'fa '.Lang::get('sidebar-nav.link_icon_perjanjian_kinerja'), "<span>".Lang::get('sidebar-nav.link_title_perjanjian_kinerja')."</span>", array('title' => Lang::get('sidebar-nav.link_title_perjanjian_kinerja'))) !!}
</li>



<li class="treeview" hidden>
    {!! HTML::icon_link( "skpd/rencana-kerja", 'fa '.Lang::get('sidebar-nav.link_icon_renja'), "<span>".Lang::get('sidebar-nav.link_title_renja')."</span><i class='fa ".Lang::get('sidebar-nav.caret_folded')." pull-right'></i>", array('title' => Lang::get('sidebar-nav.link_title_renja'))) !!}
    <ul class="treeview-menu">
        <li>
			{!! HTML::icon_link( "skpd/skp-tahunan", 'fa '.Lang::get('sidebar-nav.link_icon_skp_tahunan'), Lang::get('sidebar-nav.link_title_skp_tahunan'), array('title' => Lang::get('sidebar-nav.link_title_skp_tahunan'))) !!}
		</li>
		<li>
			{!! HTML::icon_link( "skpd/skp-bulanan", 'fa '.Lang::get('sidebar-nav.link_icon_skp_bulanan'), Lang::get('sidebar-nav.link_title_skp_bulanan'), array('title' => Lang::get('sidebar-nav.link_title_skp_bulanan'))) !!}
		</li>
	</ul>
</li>


 
<li class="treeview">
    {!! HTML::icon_link( "skpd/skp", 'fa '.Lang::get('sidebar-nav.link_icon_skp'), "<span>".Lang::get('sidebar-nav.link_title_skp')."</span><i class='fa ".Lang::get('sidebar-nav.caret_folded')." pull-right'></i>", array('title' => Lang::get('sidebar-nav.link_title_skp'))) !!}
    <ul class="treeview-menu">
        <li>
			{!! HTML::icon_link( "skpd/skp-tahunan", 'fa '.Lang::get('sidebar-nav.link_icon_skp_tahunan'), Lang::get('sidebar-nav.link_title_skp_tahunan'), array('title' => Lang::get('sidebar-nav.link_title_skp_tahunan'))) !!}
		</li>
		<li>
			{!! HTML::icon_link( "skpd/skp-bulanan", 'fa '.Lang::get('sidebar-nav.link_icon_skp_bulanan'), Lang::get('sidebar-nav.link_title_skp_bulanan'), array('title' => Lang::get('sidebar-nav.link_title_skp_bulanan'))) !!}
		</li>
	</ul>
</li>