<div class="row">
	<div class="col-md-12">

		<!-- 2 KAUBID -->
		@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '2')
			@include('admin.tables.skp_tahunan-rencana_aksi_time_table_2')
		@endif

		<!-- 3 KASUBID -->
		@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '3')
			@include('admin.tables.skp_tahunan-rencana_aksi_time_table_3')
		@endif

		<!-- 4. PELAKSANA -->
		@if ( $skp->PejabatYangDinilai->Eselon->id_jenis_jabatan  == '4')
			@include('admin.tables.skp_tahunan-rencana_aksi_time_table_4')
		@endif

	</div>
</div>

<script type="text/javascript">
	


</script>
