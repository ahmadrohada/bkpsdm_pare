<div class="box box-kegiatan_tahunan" id='kegiatan_tahunan'>
	<div class="box-header with-border">
		<h1 class="box-title">
			List Kegiatan SKP Tahunan 
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">
		<div class="toolbar"> 

		</div>

		<table id="kegiatan_tahunan_3_table" class="table table-striped table-hover" >
			<thead>
				<tr>
					<th rowspan="2">No</th>
					<th rowspan="2">KEGIATAN TAHUNAN</th>
					<th rowspan="2">AK</th>
					<th colspan="3">TARGET</th>
				</tr>
				<tr>
					<!-- <th>OUTPUT</th> -->
					<th>MUTU</th>
					<th>WAKTU</th>
					<th>ANGGARAN</th>
				</tr>
			</thead>
							
		</table>
	</div>
</div>



<script type="text/javascript">

	$('#kegiatan_tahunan_3_table').DataTable({
				destroy					: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3,4 ] },
									{ className: "text-right", targets: [ 5 ] },
									{ "orderable": false, targets: [ 0,1,2,3,4,5 ]  }
								],
				ajax			: {
									url	: '{{ url("api_resource/kegiatan_tahunan_3") }}',
									data: { 
										
											"renja_id" : {!! $skp->Renja->id !!} , 
											"jabatan_id" : {!! $skp->PejabatYangDinilai->Jabatan->id !!},
											"skp_tahunan_id" : {!! $skp->id !!}
									 },
								},
				columns			: [
									{ data: 'kegiatan_tahunan_id' ,
										"render": function ( data, type, row ,meta) {
											if ( (row.kegiatan_tahunan_id) <= 0 ){
												return "<p class='text-danger'>"+(meta.row + meta.settings._iDisplayStart + 1 )+"</p>" ;
											}else{
												return meta.row + meta.settings._iDisplayStart + 1 ;
											}
											
									}
									},
									{ data: "label", name:"label", width:"220px",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_tahunan_id) <= 0 ){
												return "<p class='text-danger'>"+row.kegiatan_label+"</p>";
											}else{
												return row.kegiatan_tahunan_label;
											}
										}
									},
									{ data: "angka_kredit", name:"angka_kredit" },
									{ data: "mutu", name:"mutu",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_tahunan_id) <= 0 ){
												return "<p class='text-danger'>-</p>";									
											}else{
												return row.mutu+" %";									
											}
										}
									},
									{ data: "waktu", name:"waktu",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_tahunan_id) <= 0 ){
												return "<p class='text-danger'>-</p>";									
											}else{
												return row.waktu+" bln";									
											}
										}
									},
									{ data: "biaya", name:"biaya",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_tahunan_id) <= 0 ){
												return "<p class='text-danger'>Rp. "+row.renja_biaya+"</p>";									
											}else{

												return "Rp. "+row.biaya;									
											}
										}
									},
									
								
								],
								initComplete: function(settings, json) {
								
							}
	});	



</script>