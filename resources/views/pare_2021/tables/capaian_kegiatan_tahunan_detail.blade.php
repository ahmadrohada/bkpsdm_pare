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

				<table id="realisasi_kegiatan_tahunan_table" class="table table-striped table-hover" style="width:100%">
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

@include('pare_pns.modals.realisasi_kegiatan_tahunan')


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
									{ "orderable": false, className: "text-center", targets: [ 0,3,4,5,7,8,10,11,12,13,14,15 ] },
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
				rowsGroup		: [ 0,1,4,5,6,8,9,10,11,12,13,14,15],
				columns			: [
									{ data: 'kegiatan_tahunan_id' ,width:"10px",
										"render": function ( data, type, row ,meta) {

											if ( row.kegiatan_tahunan_id )
											return  meta.row + 1;
											
											
										}
									},
									{ data: "kegiatan_label", name:"kegiatan_label",width:"30%",
										"render": function ( data, type, row ) {
											return row.kegiatan_label;
											
										}
									}, 
									{ data: "indikator_label", name:"indikator_label",width:"20%",
										"render": function ( data, type, row ) {
											return row.indikator_label;
											
										}
									}, 
									
								
									{ data: "target_quantity", name:"target_quantity",
										"render": function ( data, type, row ) {
											return row.target_quantity ;
										}
									},
									{ data: "target_quality", name:"target_quality", 
										"render": function ( data, type, row ) {
											return row.target_quality ;
										}
									},
									{ data: "target_waktu", name:"target_waktu", 
										"render": function ( data, type, row ) {
											return row.target_waktu ;
										}
									},
									{ data: "target_cost", name:"target_cost",
										"render": function ( data, type, row ) {
											return row.target_cost ;
										}
									},
									{ data: "realisasi_quantity", name:"realisasi_quantity",
										"render": function ( data, type, row ) {
											return  row.realisasi_quantity;
										}
									},
									{ data: "realisasi_waktu", name:"realisasi_waktu", 
										"render": function ( data, type, row ) {
											return row.realisasi_waktu ;
										}
									},
									{ data: "realisasi_cost", name:"realisasi_cost", 
										"render": function ( data, type, row ) {
											return row.realisasi_cost ;
										}
									},
									{ data: "hitung_quantity", name:"hitung_quantity", 
										"render": function ( data, type, row ) {
											if ( row.hitung_quality == 0 ){
												return "<span class='text-danger'> - </span>";
											}else{
												return row.hitung_quantity +" %";
											}
										}
									},
									{ data: "hitung_quality", name:"hitung_quality", 
										"render": function ( data, type, row ) {
											if ( row.hitung_quality == 0 ){
												return "<span class='text-danger'> - </span>";
											}else{
												return row.hitung_quality +" %";
											}
										}
									},
									{ data: "hitung_waktu", name:"hitung_waktu",
										"render": function ( data, type, row ) {
											if ( row.hitung_quality == 0 ){
												return "<span class='text-danger'> - </span>";
											}else{
												return row.hitung_waktu +" %";
											}
										}
									},
									{ data: "hitung_cost", name:"hitung_cost", 
										"render": function ( data, type, row ) {
											if ( row.hitung_quality == 0 ){
												return "<span class='text-danger'> - </span>";
											}else{
												return row.hitung_cost +" %";
											}
										}
									},
									{ data: "jumlah", name:"jumlah", 
										"render": function ( data, type, row ) {
											if ( row.hitung_quality == 0 ){
												return "<span class='text-danger'> - </span>";
											}else{
												return row.jumlah ;
											}
										}
									},
									{ data: "capaian_skp", name:"capaian_skp",
										"render": function ( data, type, row ) {
											if ( row.hitung_quality == 0 ){
												return "<span class='text-danger'> - </span>";
											}else{
												return row.capaian_skp ;
											}
										}
									},
									
								],
								initComplete: function(settings, json) {
								
							}
		});	


		
		
	}

	

	$(document).on('click','.create_realisasi_tahunan',function(e){
	
		
		var indikator_kegiatan_id = $(this).data('indikator_id');
		$('.modal-realisasi_tahunan').find('h4').html('Add Realisasi Kegiatan Tahunan');
		$('.modal-realisasi_tahunan').find('.btn-submit').attr('id', 'submit-save');
		$('.modal-realisasi_tahunan').find('[name=text_button_submit]').html('Simpan Data');
		show_modal_create(indikator_kegiatan_id);
		
	});

	function show_modal_create(indikator_kegiatan_id){
		$.ajax({
				url			  	: '{{ url("api/add_realisasi_kegiatan_tahunan") }}',
				data 		  	: { 
									indikator_kegiatan_id : indikator_kegiatan_id ,
									capaian_id : {!! $capaian->id !!} },
				method			: "GET",
				dataType		: "json",
				success	: function(data) {
					
					$('.modal-realisasi_tahunan').find('[name=capaian_id]').val({!! $capaian->id !!});
					$('.modal-realisasi_tahunan').find('[name=ind_kegiatan_id]').val(data['ind_kegiatan_id']);
					$('.modal-realisasi_tahunan').find('[name=kegiatan_tahunan_id]').val(data['kegiatan_tahunan_id']);
					$('.modal-realisasi_tahunan').find('[name=realisasi_indikator_kegiatan_tahunan_id]').val(data['realisasi_indikator_id']);
					$('.modal-realisasi_tahunan').find('[name=realisasi_kegiatan_tahunan_id]').val(data['realisasi_kegiatan_id']);
					$('.modal-realisasi_tahunan').find('[name=jumlah_indikator]').val(data['jumlah_indikator']);
					
					$('.modal-realisasi_tahunan').find('[name=target_quantity]').val(data['target_quantity']);
					$('.modal-realisasi_tahunan').find('[name=target_quality]').val(data['target_quality']);
					$('.modal-realisasi_tahunan').find('[name=target_waktu]').val(data['target_waktu']);
					$('.modal-realisasi_tahunan').find('[name=target_cost]').val(data['target_cost']);
					$('.modal-realisasi_tahunan').find('[name=satuan]').val(data['satuan']);

					$('.modal-realisasi_tahunan').find('.kegiatan_tahunan_label').html(data['kegiatan_tahunan_label']);
					$('.modal-realisasi_tahunan').find('.indikator_label').html(data['indikator_label']);
					


					$('.modal-realisasi_tahunan').find('.target_quantity').html(data['target_quantity']);
					$('.modal-realisasi_tahunan').find('.target_quality').html(data['target_quality']);
					$('.modal-realisasi_tahunan').find('.target_waktu').html(data['target_waktu']);
					$('.modal-realisasi_tahunan').find('.target_cost').html(data['target_cost']);
					$('.modal-realisasi_tahunan').find('.satuan').html(data['satuan']);

					$('.modal-realisasi_tahunan').find('.realisasi_quantity').val(data['realisasi_quantity']);
					$('.modal-realisasi_tahunan').find('.realisasi_quality').val(data['realisasi_quality']);
					$('.modal-realisasi_tahunan').find('.realisasi_waktu').val(data['realisasi_waktu']);
					$('.modal-realisasi_tahunan').find('.realisasi_cost').val(data['realisasi_cost']);
					
					

					
					$('.modal-realisasi_tahunan').modal('show');  
				},
				error: function(data){
					
				}						
		});	

		
	}

	$(document).on('click','.edit_realisasi_tahunan',function(e){
	
		
		var indikator_kegiatan_id = $(this).data('indikator_id');
		$('.modal-realisasi_tahunan').find('h4').html('Edit Realisasi Kegiatan Tahunan');
		$('.modal-realisasi_tahunan').find('.btn-submit').attr('id', 'submit-update');
		$('.modal-realisasi_tahunan').find('[name=text_button_submit]').html('Update Data');
		show_modal_create(indikator_kegiatan_id);
		
	});

	$(document).on('click','.hapus_realisasi_tahunan',function(e){
		var realisasi_indikator_kegiatan_id = $(this).data('realisasi_indikator_kegiatan_id') ;
		var kegiatan_id = $(this).data('kegiatan_id') ;
		var realisasi_kegiatan_id = $(this).data('realisasi_kegiatan_id') ;

		Swal.fire({
			title: "Hapus  realisasi Kegiatan",
			text:$(this).data('label'),
			type: "warning",
			//type: "question",
			showCancelButton: true,
			cancelButtonText: "Batal",
			confirmButtonText: "Hapus",
			confirmButtonClass: "btn btn-success",
			cancelButtonColor: "btn btn-danger",
			cancelButtonColor: "#d33",
			closeOnConfirm: false,
			closeOnCancel:false
		}).then ((result) => {
			if (result.value){
				$.ajax({
					url		: '{{ url("api/hapus_realisasi_kegiatan_tahunan") }}',
					type	: 'POST',
					data    : { kegiatan_id:kegiatan_id,
								realisasi_indikator_kegiatan_id:realisasi_indikator_kegiatan_id,
								realisasi_kegiatan_id:realisasi_kegiatan_id
								},
					cache   : false,
					success:function(data){
							Swal.fire({
									title: "",
									text: "Sukses",
									type: "success",
									width: "200px",
									showConfirmButton: false,
									allowOutsideClick : false,
									timer: 900
									}).then(function () {
										$('#realisasi_kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#realisasi_kegiatan_tahunan_table').DataTable().ajax.reload(null,false);
											
											
										}
									}
								)
								
							
					},
					error: function(e) {
							Swal.fire({
									title: "Gagal",
									text: "",
									type: "warning"
								}).then (function(){
										
								});
							}
					});	
			}
		});
	});

	

</script>
