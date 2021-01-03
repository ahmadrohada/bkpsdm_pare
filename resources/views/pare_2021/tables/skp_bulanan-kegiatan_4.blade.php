<div class="box-body table-responsive">
	<div class="toolbar">
	</div>
	<table id="kegiatan_bulanan_table" class="table table-striped table-hover" >
		<thead>
			<tr>
				<th>No</th>
				<th>KEGIATAN BULANAN</th>
				<th>TARGET</th>
				<th><i class="fa fa-cog"></i></th>
			</tr>
		</thead>
	</table>
</div>

@include('pare_pns.modals.kegiatan_bulanan')

<script type="text/javascript">

  function LoadKegiatanBulananTable(){
		var table_skp_bulanan = $('#kegiatan_bulanan_table').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				autoWidth		: false,
				bInfo			: false,
				bSort			: false,
				lengthChange	: false,
				deferRender		: true,
				order 			: [ 0 , 'asc' ],
				//lengthMenu		: [10,25,50],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3 ] },
									@if  ( request()->segment(4) == 'edit' )
										{ "visible": true, "targets": [3]}
									@else
										{ "visible": false, "targets": [3]}
									@endif 
								],
				ajax			: {
									url	: '{{ url("api/kegiatan_bulanan_4") }}',
									data: { 
										
											"renja_id" 		 : {!! $skp->SKPTahunan->Renja->id !!} , 
											"jabatan_id" 	 : {!! $skp->PegawaiYangDinilai->Jabatan->id !!},
											"skp_bulanan_id" : {!! $skp->id !!}
									 },
								},
				columns			: [
									{ data: 'rencana_aksi_id' ,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
									}
									},
									{ data: "label", name:"label",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_bulanan_id) <= 0 ){
												return "<span class='text-danger'>"+row.rencana_aksi_label+' / '+row.kegiatan_tahunan_label+"</span>";
											}else{
												return row.kegiatan_bulanan_label+' / '+row.kegiatan_tahunan_label;
											}
										}
									},
									{ data: "target", name:"target", width:"140px",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_bulanan_id) <= 0 ){
												return "<span class='text-danger'>"+row.target+"</span>";
											}else{
												return row.target;
											}
										}
									},
									{  data: 'action',width:"60px",
											"render": function ( data, type, row ) {

											if ( row.status_skp != 1 ){
												if ( (row.kegiatan_bulanan_id) >= 1 ){
													return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_kegiatan_bulanan"  data-id="'+row.kegiatan_bulanan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
														    '<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_kegiatan_bulanan"  data-id="'+row.kegiatan_bulanan_id+'" data-label="'+row.kegiatan_bulanan_label+'" ><i class="fa fa-close " ></i></a></span>';
												}else{

													if (row.rencana_aksi_target != "" ){
														return  '<span  data-toggle="tooltip" title="Add" style="margin:2px;" ><a class="btn btn-info btn-xs create_kegiatan_bulanan"  data-id="'+row.rencana_aksi_id+'" data-skp_bulanan_id="'+row.skp_bulanan_id+'"><i class="fa fa-plus" ></i></a></span>';
													}else{
														return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-plus" ></i></a></span>';
													}
													
															
												
												}
											}else{ //SUDAH ADA CAPAIAN NYA
												return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs " disabled><i class="fa fa-pencil " ></i></a></span>'+
														'<span style="margin:2px;" ><a class="btn btn-default btn-xs " disabled><i class="fa fa-close " ></i></a></span>';
												
											}		
											
										
										}
									}, 
									
								
								],
								initComplete: function(settings, json) {
								
							}
		});	
	}

	$(document).on('click','.create_kegiatan_bulanan',function(e){
		var id = $(this).data('id');
		var skp_bulanan_id = $(this).data('skp_bulanan_id');
		show_modal_create(id,skp_bulanan_id);
	});



	$(document).on('click','.edit_kegiatan_bulanan',function(e){
		var id = $(this).data('id');
		
		$.ajax({
				url			  	: '{{ url("api/kegiatan_bulanan_detail") }}',
				data 		  	: {kegiatan_bulanan_id : id},
				method			: "GET",
				dataType		: "json",
				success	: function(data) {
					$('.modal-kegiatan_bulanan').find('[name=kegiatan_bulanan_id]').val(data['id']);
					//$('.modal-kegiatan_bulanan').find('[name=rencana_aksi_label]').val(data['kegiatan_bulanan_label']);
					$('.modal-kegiatan_bulanan').find('[name=target]').val(data['kegiatan_bulanan_target']);
					$('.modal-kegiatan_bulanan').find('[name=satuan]').val(data['kegiatan_bulanan_satuan']);
					$('.modal-kegiatan_bulanan').find('.rencana_aksi_label').html(data['kegiatan_bulanan_label']); 

					$('.modal-kegiatan_bulanan').find('.kegiatan_tahunan_label').html(data['kegiatan_tahunan_label']);
					$('.modal-kegiatan_bulanan').find('.kegiatan_tahunan_output').html(data['kegiatan_tahunan_output']);
					$('.modal-kegiatan_bulanan').find('.kegiatan_tahunan_waktu').html(data['kegiatan_tahunan_waktu']+' bulan');
					$('.modal-kegiatan_bulanan').find('.kegiatan_tahunan_cost').html('Rp. '+data['kegiatan_tahunan_cost']);


					$('.modal-kegiatan_bulanan').find('h4').html('Edit Kegiatan Bulanan');
					$('.modal-kegiatan_bulanan').find('.btn-submit').attr('id', 'submit-update');
					$('.modal-kegiatan_bulanan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-kegiatan_bulanan').modal('show'); 
					
				},
				error: function(data){
					
				}						
		});	

	});


	function show_modal_create(rencana_aksi_id,skp_bulanan_id){
		$.ajax({
				url			  : '{{ url("api/rencana_aksi_detail_4") }}',
				data 		  : {rencana_aksi_id : rencana_aksi_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-kegiatan_bulanan').find('[name=rencana_aksi_id]').val(data['id']);
					$('.modal-kegiatan_bulanan').find('[name=skp_bulanan_id]').val(skp_bulanan_id);
					$('.modal-kegiatan_bulanan').find('[name=rencana_aksi_label]').val(data['label']);
					$('.modal-kegiatan_bulanan').find('[name=target]').val(data['target_rencana_aksi']);
					$('.modal-kegiatan_bulanan').find('[name=satuan]').val(data['satuan_target_rencana_aksi']);
					$('.modal-kegiatan_bulanan').find('.rencana_aksi_label').html(data['label']);

					$('.modal-kegiatan_bulanan').find('.kegiatan_tahunan_label').html(data['kegiatan_tahunan_label']);
					$('.modal-kegiatan_bulanan').find('.kegiatan_tahunan_output').html(data['kegiatan_tahunan_output']);
					$('.modal-kegiatan_bulanan').find('.kegiatan_tahunan_waktu').html(data['kegiatan_tahunan_waktu']+' bulan');
					$('.modal-kegiatan_bulanan').find('.kegiatan_tahunan_cost').html('Rp. '+data['kegiatan_tahunan_cost']);


					$('.modal-kegiatan_bulanan').find('h4').html('Create Kegiatan Bulanan');
					$('.modal-kegiatan_bulanan').find('.btn-submit').attr('id', 'submit-save');
					$('.modal-kegiatan_bulanan').find('[name=text_button_submit]').html('Simpan Data');
					$('.modal-kegiatan_bulanan').modal('show'); 
				},
				error: function(data){
					
				}						
		});	
	}

	$(document).on('click','.hapus_kegiatan_bulanan',function(e){
		var kegiatan_bulanan_id = $(this).data('id') ;
		//alert(kegiatan_bulanan_id);

		Swal.fire({
			title: "Hapus  Kegiatan Bulanan",
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
					url		: '{{ url("api/hapus_kegiatan_bulanan") }}',
					type	: 'POST',
					data    : {kegiatan_bulanan_id:kegiatan_bulanan_id},
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
										$('#kegiatan_bulanan_table').DataTable().ajax.reload(null,false);
										jQuery('#skp_bulanan_tree').jstree(true).refresh(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#kegiatan_bulanan_table').DataTable().ajax.reload(null,false);
											jQuery('#skp_bulanan_tree').jstree(true).refresh(true);
											
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
