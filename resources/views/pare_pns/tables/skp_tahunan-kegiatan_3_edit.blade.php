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
					<th rowspan="2">AK</th>
					<th colspan="3">TARGET</th>
					<th rowspan="2"><i class="fa fa-cog"></i></th>
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
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				paging          : false,
				bInfo			: false,
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3,4,6 ] },
									{ className: "text-right", targets: [ 5 ] },
									{ "orderable": false, targets: [ 0,1,2,3,4,5,6 ]  }
								],
				ajax			: {
									url	: '{{ url("api/kegiatan_skp_tahunan_3") }}',
									data: { 
										
											"renja_id" : {!! $skp->Renja->id !!} , 
											"jabatan_id" : {!! $skp->PegawaiYangDinilai->Jabatan->id !!},
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
									{  data: 'action',width:"60px",
											"render": function ( data, type, row ) {

											if ( (row.kegiatan_tahunan_id) >= 1 ){
												return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_kegiatan_tahunan"  data-id="'+row.kegiatan_tahunan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_kegiatan_tahunan"  data-id="'+row.kegiatan_tahunan_id+'" data-label="'+row.label+'" ><i class="fa fa-close " ></i></a></span>';
											}else{
												return  '<span  data-toggle="tooltip" title="Add" style="margin:2px;" ><a class="btn btn-warning btn-xs create_kegiatan_tahunan"  data-id="'+row.kegiatan_id+'" data-label="'+row.kegiatan_label+'"><i class="fa fa-plus faa-tada animated" ></i></a></span>'+
																'<span  style="margin:2px;" disabled><a class="btn btn-default btn-xs "  ><i class="fa fa-close " ></i></a></span>';
											
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
				url			: '{{ url("api/kegiatan_detail") }}',
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
				url			: '{{ url("api/kegiatan_tahunan_detail") }}',
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
					url		: '{{ url("api/hapus_kegiatan_tahunan") }}',
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
										$('#skp_bulanan_table').DataTable().ajax.reload(null,false);
										jQuery('#kegiatan_tahunan_3').jstree(true).refresh(true);
										jQuery('#skp_bulanan_tree').jstree(true).refresh(true);

										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											
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