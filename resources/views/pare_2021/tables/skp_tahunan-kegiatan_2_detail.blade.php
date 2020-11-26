<div class="box box-kegiatan_tahunan" id='kegiatan_tahunan'>
	<div class="box-header with-border">
		<h1 class="box-title">
			List Kegiatan SKP Tahunan 
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
			{!! Form::button('<i class="fa fa-question-circle "></i>', array('class' => 'btn btn-box-tool bantuan','data-id' => '1', 'title' => 'Bantuan', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive" style="min-height:330px;">
		<div class="toolbar"> 

		</div>

		<table id="kegiatan_tahunan_3_table" class="table table-striped table-hover" >
			<thead>
				<tr>
					<th rowspan="2">No</th>
					<th rowspan="2">KEGIATAN TAHUNAN</th>
					<th rowspan="2">PENGAWAS</th>
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


@include('pare_pns.modals.kegiatan_tahunan')

<script type="text/javascript">

	$('#kegiatan_tahunan_3_table').DataTable({
				destroy					: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				paging          : false,
				bInfo			: false,
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3,4,5 ] },
									{ className: "text-right", targets: [ 6 ] },
									{ "orderable": false, targets: [ 0,1,3,4,5,6 ]  }
								],
				ajax			: {
									url	: '{{ url("api_resource/kegiatan_tahunan_2") }}',
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
									{ data: "penanggung_jawab", name:"penanggung_jawab" },
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

	$(document).on('click','.create_kegiatan_tahunan',function(e){
	
    var kegiatan_id = $(this).data('id');
		show_modal_create(kegiatan_id);

	});

	function show_modal_create(kegiatan_id){
		$.ajax({
				url			: '{{ url("api_resource/kegiatan_detail") }}',
				data 		: {kegiatan_id : kegiatan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-kegiatan_tahunan').find('[name=kegiatan_id]').val(data['kegiatan_id']);
					$('.modal-kegiatan_tahunan').find('[name=label]').val(data['label']);
					$('.modal-kegiatan_tahunan').find('[name=target]').val(data['target']);
					$('.modal-kegiatan_tahunan').find('[name=satuan]').val(data['satuan']);
					$('.modal-kegiatan_tahunan').find('[name=cost]').val(data['cost']);

					$('.modal-kegiatan_tahunan').find('[name=quality]').val(100);
					$('.modal-kegiatan_tahunan').find('h4').html('Add Kegiatan Tahunan');
					$('.modal-kegiatan_tahunan').find('.btn-submit').attr('id', 'submit-save');
					$('.modal-kegiatan_tahunan').find('[name=text_button_submit]').html('Simpan Data');
					$('.modal-kegiatan_tahunan').modal('show');
				},
				error: function(data){
					
				}						
		});	
	}

	$(document).on('click','.edit_kegiatan_tahunan',function(e){
		var kegiatan_tahunan_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api_resource/kegiatan_tahunan_detail") }}',
				data 		: {kegiatan_tahunan_id : kegiatan_tahunan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-kegiatan_tahunan').find('[name=label]').val(data['label']);
					$('.modal-kegiatan_tahunan').find('[name=angka_kredit]').val(data['ak']);
					$('.modal-kegiatan_tahunan').find('[name=target]').val(data['target']);
					$('.modal-kegiatan_tahunan').find('[name=quality]').val(data['quality']);
					$('.modal-kegiatan_tahunan').find('[name=satuan]').val(data['satuan']);
					$('.modal-kegiatan_tahunan').find('[name=target_waktu]').val(data['target_waktu']);
					$('.modal-kegiatan_tahunan').find('[name=cost]').val(data['cost']);

				

					$('.modal-kegiatan_tahunan').find('[name=kegiatan_tahunan_id]').val(data['id']);
					$('.modal-kegiatan_tahunan').find('h4').html('Edit Kegiatan Tahunan');
					$('.modal-kegiatan_tahunan').find('.btn-submit').attr('id', 'submit-update');
					$('.modal-kegiatan_tahunan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-kegiatan_tahunan').modal('show');
				},
				error: function(data){
					
				}						
		});	
	});



	$(document).on('click','.hapus_kegiatan_tahunan',function(e){
		var kegiatan_tahunan_id = $(this).data('id') ;
		//alert(kegiatan_tahunan_id);

		Swal.fire({
			title: "Hapus  Kegiatan Tahunan",
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
					url		: '{{ url("api_resource/hapus_kegiatan_tahunan") }}',
					type	: 'POST',
					data    : {kegiatan_tahunan_id:kegiatan_tahunan_id},
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
										$('#kegiatan_tahunan_3_table').DataTable().ajax.reload(null,false);
										jQuery('#keg_tahunan_3_tree').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#kegiatan_tahunan_3_table').DataTable().ajax.reload(null,false);
											jQuery('#keg_tahunan_3_tree').jstree(true).refresh(true);
											
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