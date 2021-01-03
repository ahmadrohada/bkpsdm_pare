<div class="row">
	<div class="col-md-12">

<!--====================== KEGIATAN BULANAN LIST =========================================== -->
		<div class="box box-primary" id='kegiatan_tahunan'>
			<div class="box-header with-border">
				<h1 class="box-title">
					List Realisasi Kegiatan Tahunan  / {!! $capaian->PegawaiYangDinilai->Eselon->eselon !!}
				</h1>

				<div class="box-tools pull-right">
				
				</div>
			</div>
			<div class="box-body table-responsive">

				<div class="toolbar"> 

				</div>

				<table id="realisasi_kegiatan_tahunan_table" class="table table-striped table-hover display" style="">
					<thead>
						<tr>
							<th rowspan="2">No</th>
							<th rowspan="2">KEGIATAN TAHUNAN</th>
							<th rowspan="2">INDIKATOR</th>
							<th colspan="4" >TARGET</th>
							<th colspan="3">REALISASI</th>
							<th rowspan="2" >HITUNG <br>QUANTITY</th>
							<th rowspan="2">HITUNG <br>QUALITY</th>
							<th rowspan="2">HITUNG <br>WAKTU</th>
							<th rowspan="2">HITUNG <br>ANGGARAN</th>
							<th rowspan="2">JUMLAH</th>
							<th rowspan="2">CAPAIAN <br>SKP</th>
							<th rowspan="2"><i class="fa fa-cog"></i></th>
						</tr>
						<tr>
							<th>QUANTITY</th>
							<th>QUALITY</th>
							<th>WAKTU</th>
							<th>ANGGARAN</th>
							<th>QUANTITY</th>
							<th>WAKTU</th>
							<th>ANGGARAN</th>
						</tr>
					</thead>
							
				</table>

			</div>
		</div>

	</div>

	
</div>
<style>
table.dataTable tbody td {
  vertical-align: middle;
}
</style>

@include('pare_pns.modals.penilaian_kualitas_kerja')


<script src="{{asset('assets/js/dataTables.rowsGroup.js')}}"></script>


<script type="text/javascript">

		
	
  	function load_kegiatan_tahunan(){
		
		var table_kegiatan_tahunan = $('#realisasi_kegiatan_tahunan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				bInfo			: false,
				//fixedColumns	: true,
				//order 			: [0 , 'asc' ],
				columnDefs		: [
									{ "orderable": false, className: "text-center", targets: [ 0,3,4,5,7,8,10,11,12,13,14,15,16 ] },
									{ className: "text-right", targets: [ 6,9] },
									@if ( $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan  == '5')
										{ className: "hide", targets: [ 2 ] },
									@endif
									
								],
				ajax			: {
									url	: '{{ url("api/realisasi_kegiatan_tahunan") }}',
									data: { 
										
											"renja_id" 				: {!! $capaian->SKPTahunan->Renja->id !!} , 
											"jabatan_id" 			: {!! $capaian->PegawaiYangDinilai->Jabatan->id !!},
											"capaian_id" 			: {!! $capaian->id !!},
											"jenis_jabatan"			: {!! $capaian->PegawaiYangDinilai->Eselon->id_jenis_jabatan !!},
									 },
								},
				targets			: 'no-sort',
				bSort			: false,
				rowsGroup		: [ 0,1,4,5,6,8,9,10,11,12,13,14,15,16],
				columns			: [
									{ data: 'kegiatan_tahunan_id' ,width:"10px",
										"render": function ( data, type, row ,meta) {

											if ( row.kegiatan_tahunan_id )
											return  meta.row + 1;
											
											
										}
									},
									{ data: "kegiatan_label", name:"kegiatan_label",width:"100px",
										"render": function ( data, type, row ) {
											return row.kegiatan_label;
											
										}
									}, 
									{ data: "indikator_label", name:"indikator_label",
										"render": function ( data, type, row ) {
											return row.indikator_label;
											
										}
									}, 
									
								
									{ data: "target_quantity", name:"target_quantity", width:"100px",
										"render": function ( data, type, row ) {
											return row.target_quantity ;
										}
									},
									{ data: "target_quality", name:"target_quality", width:"100px",
										"render": function ( data, type, row ) {
											return row.target_quality ;
										}
									},
									{ data: "target_waktu", name:"target_waktu", width:"100px",
										"render": function ( data, type, row ) {
											return row.target_waktu ;
										}
									},
									{ data: "target_cost", name:"target_cost", width:"100px",
										"render": function ( data, type, row ) {
											return row.target_cost ;
										}
									},
									{ data: "realisasi_quantity", name:"realisasi_quantity", width:"100px",
										"render": function ( data, type, row ) {
											return  row.realisasi_quantity;
										}
									},
									{ data: "realisasi_waktu", name:"realisasi_waktu", width:"50px",
										"render": function ( data, type, row ) {
											return row.realisasi_waktu ;
										}
									},
									{ data: "realisasi_cost", name:"realisasi_cost", width:"50px",
										"render": function ( data, type, row ) {
											return row.realisasi_cost ;
										}
									},
									{ data: "hitung_quantity", name:"hitung_quantity", width:"50px",
										"render": function ( data, type, row ) {
											if ( row.hitung_quantity == 0 ){
												return "<span class='text-danger'> - </span>";
											}else{
												return row.hitung_quantity +" %";
											}

											
										}
									},
									{ data: "hitung_quality", name:"hitung_quality", width:"50px",
										"render": function ( data, type, row ) {
											if ( row.hitung_quality == 0 ){
												return "<span class='text-danger'> - </span>";
											}else{
												return row.hitung_quality +" %";
											}
										}
									},
									{ data: "hitung_waktu", name:"hitung_waktu", width:"50px",
										"render": function ( data, type, row ) {
											if ( row.hitung_quality == 0 ){
												return "<span class='text-danger'> - </span>";
											}else{
												return row.hitung_waktu +" %";
											}
										}
									},
									{ data: "hitung_cost", name:"hitung_cost", width:"50px",
										"render": function ( data, type, row ) {
											if ( row.hitung_quality == 0 ){
												return "<span class='text-danger'> - </span>";
											}else{
												return row.hitung_cost +" %";
											}
										}
									},
									{ data: "jumlah", name:"jumlah", width:"50px",
										"render": function ( data, type, row ) {
											if ( row.hitung_quality == 0 ){
												return "<span class='text-danger'> - </span>";
											}else{
												return row.jumlah ;
											}
										}
									},
									{ data: "capaian_skp", name:"capaian_skp", width:"50px",
										"render": function ( data, type, row ) {
											if ( row.hitung_quality == 0 ){
												return "<span class='text-danger'> - </span>";
											}else{
												return row.capaian_skp ;
											}
										}
									},
									{  data: 'realisasi_kegiatan_id',name:'realisasi_kegiatan_id',width:"60px",
										"render": function ( data, type, row ) {
											
											if ( (row.penilaian) >= 1 ){
												return  '<span data-toggle="tooltip" title="Ubah data penilaian" style="margin:2px;" ><a class="btn btn-success btn-xs penilaian_kualitas_kerja"  data-realisasi_kegiatan_id="'+row.realisasi_kegiatan_id+'"><i class="fa fa-pencil" ></i></a></span>';	
											}else{
												return  '<span data-toggle="tooltip" title="Berikan Penilaian Kualitas Kerja"  style="margin:2px;" ><a class="btn btn-info btn-xs penilaian_kualitas_kerja"  data-realisasi_kegiatan_id="'+row.realisasi_kegiatan_id+'"><i class="fa fa-pagelines" ></i></a></span>';
											} 
											
										}
									},
									
								
								],
								initComplete: function(settings, json) {
								
							}
		});	


		
		
	}

	

	$(document).on('click','.penilaian_kualitas_kerja',function(e){
	
		
		var realisasi_kegiatan_id = $(this).data('realisasi_kegiatan_id');

		$.ajax({
				url			  	: '{{ url("api/penilaian_kualitas_kerja_detail") }}',
				data 		  	: { 
									realisasi_kegiatan_id : realisasi_kegiatan_id ,
								  },
				method			: "GET",
				dataType		: "json",
				success	: function(data) {
					
					$('.modal-penilaian_kualitas_kerja').find('[class=realisasi_kegiatan_tahunan_id]').val(data['realisasi_kegiatan_tahunan_id']);
					$('.modal-penilaian_kualitas_kerja').find('h4').html('Penilaian Kualitas Kerja');
					
					$('.akurasi').rating('update',data['akurasi']);
					$('.ketelitian').rating('update',data['ketelitian']);
					$('.kerapihan').rating('update',data['kerapihan']);
					$('.keterampilan').rating('update',data['keterampilan']);
				
					hitung_penilaian_kualitas_kerja();


					$('.modal-penilaian_kualitas_kerja').modal('show');  
				},
				error: function(data){
					
				}						
		});	

	});



</script>
