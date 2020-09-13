<li class="header"></li>

<li class="{{ (request()->segment(1) == 'puskesmas') ? 'active' : '' }}">
    {!! HTML::icon_link( "puskesmas/pegawai", 'fa '.Lang::get('sidebar-nav.link_icon_home'), "<span>ADMIN PUSKESMAS</span>", array('title' => Lang::get('sidebar-nav.link_title_home') , 'data-toggle' => 'tooltip')) !!}
</li>

 
<!--
<li>
    {!! HTML::icon_link( "puskesmas/report", 'fa '.Lang::get('sidebar-nav.link_icon_report'), "<span>".Lang::get('sidebar-nav.link_title_report')."</span>", array('title' => Lang::get('sidebar-nav.link_title_report'))) !!}
</li>
<li>
    {!! HTML::icon_link( "puskesmas/peta-jabatan", 'fa '.Lang::get('sidebar-nav.link_icon_peta_jabatan'), "<span>".Lang::get('sidebar-nav.link_title_peta_jabatan')."</span>", array('title' => Lang::get('sidebar-nav.link_title_peta_jabatan'))) !!}
</li>

<li>
    {!! HTML::icon_link( "puskesmas/distribusi-kegiatan", 'fa '.Lang::get('sidebar-nav.link_icon_distribusi_kegiatan'), "<span>".Lang::get('sidebar-nav.link_title_distribusi_kegiatan')."</span>", array('title' => Lang::get('sidebar-nav.link_title_distribusi_kagiatan'))) !!}
</li>

<li>
    {!! HTML::icon_link( "puskesmas/perjanjian_kinerja", 'fa '.Lang::get('sidebar-nav.link_icon_perjanjian_kinerja'), "<span>".Lang::get('sidebar-nav.link_title_perjanjian_kinerja')."</span>", array('title' => Lang::get('sidebar-nav.link_title_perjanjian_kinerja'))) !!}
</li>



<li class="treeview" hidden>
    {!! HTML::icon_link( "puskesmas/rencana-kerja", 'fa '.Lang::get('sidebar-nav.link_icon_renja'), "<span>".Lang::get('sidebar-nav.link_title_renja')."</span><i class='fa ".Lang::get('sidebar-nav.caret_folded')." pull-right'></i>", array('title' => Lang::get('sidebar-nav.link_title_renja'))) !!}
    <ul class="treeview-menu">
        <li>
			{!! HTML::icon_link( "puskesmas/skp_tahunan", 'fa '.Lang::get('sidebar-nav.link_icon_skp_tahunan'), Lang::get('sidebar-nav.link_title_skp_tahunan'), array('title' => Lang::get('sidebar-nav.link_title_skp_tahunan'))) !!}
		</li>
		<li>
			{!! HTML::icon_link( "puskesmas/skp_bulanan", 'fa '.Lang::get('sidebar-nav.link_icon_skp_bulanan'), Lang::get('sidebar-nav.link_title_skp_bulanan'), array('title' => Lang::get('sidebar-nav.link_title_skp_bulanan'))) !!}
		</li>
	</ul>
</li>



 
<li class="treeview">
    {!! HTML::icon_link( "puskesmas/skp", 'fa '.Lang::get('sidebar-nav.link_icon_skp'), "<span>".Lang::get('sidebar-nav.link_title_skp')."</span><i class='fa ".Lang::get('sidebar-nav.caret_folded')." pull-right'></i>", array('title' => Lang::get('sidebar-nav.link_title_skp'))) !!}
    <ul class="treeview-menu">
        <li>
			{!! HTML::icon_link( "puskesmas/skp_tahunan", 'fa '.Lang::get('sidebar-nav.link_icon_skp_tahunan'), Lang::get('sidebar-nav.link_title_skp_tahunan'), array('title' => Lang::get('sidebar-nav.link_title_skp_tahunan'))) !!}
		</li>
		<li>
			{!! HTML::icon_link( "puskesmas/skp_bulanan", 'fa '.Lang::get('sidebar-nav.link_icon_skp_bulanan'), Lang::get('sidebar-nav.link_title_skp_bulanan'), array('title' => Lang::get('sidebar-nav.link_title_skp_bulanan'))) !!}
		</li>
	</ul>
</li>



-->