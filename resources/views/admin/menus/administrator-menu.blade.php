<li class="header">ADMINISTRATOR</li>

<li>
    {!! HTML::icon_link( "admin/pegawai", 'fa '.Lang::get('sidebar-nav.link_icon_users_view'), "<span>".Lang::get('sidebar-nav.link_title_users_view')."</span>", array('title' => Lang::get('sidebar-nav.link_title_users_view'))) !!}
</li>

<li>
    {!! HTML::icon_link( "admin/rencana-kerja", 'fa '.Lang::get('sidebar-nav.link_icon_renja'), "<span>".Lang::get('sidebar-nav.link_title_renja')."</span>", array('title' => Lang::get('sidebar-nav.link_title_renja'))) !!}
</li>

<li>
    {!! HTML::icon_link( "admin/peta-jabatan", 'fa '.Lang::get('sidebar-nav.link_icon_peta_jabatan'), "<span>".Lang::get('sidebar-nav.link_title_peta_jabatan')."</span>", array('title' => Lang::get('sidebar-nav.link_title_peta_jabatan'))) !!}
</li>
 
<li class="treeview">
    {!! HTML::icon_link( "admin/skp", 'fa '.Lang::get('sidebar-nav.link_icon_skp'), "<span>".Lang::get('sidebar-nav.link_title_skp')."</span><i class='fa ".Lang::get('sidebar-nav.caret_folded')." pull-right'></i>", array('title' => Lang::get('sidebar-nav.link_title_skp'))) !!}
    <ul class="treeview-menu">
        <li>
			{!! HTML::icon_link( "admin/skp-tahunan", 'fa '.Lang::get('sidebar-nav.link_icon_skp_tahunan'), Lang::get('sidebar-nav.link_title_skp_tahunan'), array('title' => Lang::get('sidebar-nav.link_title_skp_tahunan'))) !!}
		</li>
		<li>
			{!! HTML::icon_link( "admin/skp-bulanan", 'fa '.Lang::get('sidebar-nav.link_icon_skp_bulanan'), Lang::get('sidebar-nav.link_title_skp_bulanan'), array('title' => Lang::get('sidebar-nav.link_title_skp_bulanan'))) !!}
		</li>
	</ul>
</li>