<div class="box box-tugas_tambahan" id='kegiatan_tahunan'>
	<div class="box-header with-border">
		<h1 class="box-title">
			List Tugas Tambahan
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
			{!! Form::button('<i class="fa fa-question-circle "></i>', array('class' => 'btn btn-box-tool bantuan','data-id' => '1', 'title' => 'Bantuan', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive" style="min-height:330px;">
		<div class="toolbar"> 
			@if ( request()->segment(4) == 'edit' )
				<span><a class="btn btn-info btn-sm add_tugas_tambahan" ><i class="fa fa-plus" ></i> Add Tugas Tambahan</a></span>
			@endif
		</div>

		<table id="tugas_tambahan_table" class="table table-striped table-hover" >
			<thead>
				<tr>
					<th rowspan="2">No</th>
					<th rowspan="2">TUGAS TAMBAHAN</th>
					<th rowspan="2">AK</th>
					<th colspan="2">TARGET</th>
					<th rowspan="2"><i class="fa fa-cog"></i></th>
				</tr>
				<tr>
					<th>OUTPUT</th>
					<th>MUTU</th>
				</tr>
			</thead>
							
		</table>
	</div>
</div>


@include('pare_pns.modals.skp_tahunan_tugas_tambahan')

<script type="text/javascript">


	function LoadTugasTambahanTable(){
		$('#tugas_tambahan_table').DataTable({
					destroy			: true,
					processing      : true,
					serverSide      : true,
					searching      	: false,
					paging          : false,
					paging          : false,
					bInfo			: false,
					columnDefs		: [
										{ className: "text-center", targets: [ 0,2,3,4 ] },
										/* { className: "text-right", targets: [ 6 ] }, */
										{ "orderable": false, targets: [ 0,1,2,3,4,5 ]  },
										@if ( request()->segment(4) == 'edit' )
											{ "visible": true, "targets": [5]}
										@else
											{ "visible": false, "targets": [5]}
										@endif
									],
					ajax			: {
										url	: '{{ url("api_resource/tugas_tambahan_list") }}',
										data: 	{ 
													"skp_tahunan_id" : {!! $skp->id !!}
												},
									},
					columns			: [
										{ data: 'kegiatan_tahunan_id' ,
											"render": function ( data, type, row ,meta) {
												return meta.row + meta.settings._iDisplayStart + 1 ;
											}
										},
										{ data: "label", name:"label", width:"220px"},
										{ data: "angka_kredit", name:"angka_kredit" },
										{ data: "output", name:"output"},
										{ data: "mutu", name:"mutu"},
										{  data: 'action',width:"60px",
											"render": function ( data, type, row ) {
												return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_tugas_tambahan"  data-id="'+row.tugas_tambahan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
														'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_tugas_tambahan"  data-id="'+row.tugas_tambahan_id+'" data-label="'+row.label+'" ><i class="fa fa-close " ></i></a></span>';
												
											}
										},
									
									],
									initComplete: function(settings, json) {
									
								}
		});	
	}
	


	$(document).on('click','.add_tugas_tambahan',function(e){
	
		$('.modal-tugas_tambahan').find('h4').html('Add Tugas Tambahan');
		$('.modal-tugas_tambahan').find('[name=label],[name=angka_kredit],[name=target],[name=satuan],[name=target_waktu],[name=cost]').val("");
		$('.modal-tugas_tambahan').find('[name=quality]').val(100);
		$('.modal-tugas_tambahan').find('.btn-submit_tugas_tambahan').attr('id', 'submit-save_tugas_tambahan');
		$('.modal-tugas_tambahan').find('[name=text_button_submit]').html('Simpan Data');
		
		$('.modal-tugas_tambahan').modal('show');  
	});


	$(document).on('click','.edit_tugas_tambahan',function(e){
		var tugas_tambahan_id = $(this).data('id') ;
		
		$.ajax({
				url			: '{{ url("api_resource/tugas_tambahan_detail") }}',
				data 		: {tugas_tambahan_id : tugas_tambahan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-tugas_tambahan').find('h4').html('Edit Tugas Tambahan');
					$('.modal-tugas_tambahan').find('[name=tugas_tambahan_id]').val(data['id']);
					$('.modal-tugas_tambahan').find('[name=skp_tahunan_id]').val(data['skp_tahunan_id']);

					$('.modal-tugas_tambahan').find('[name=label]').val(data['label']);
					$('.modal-tugas_tambahan').find('[name=angka_kredit]').val(data['ak']);
					$('.modal-tugas_tambahan').find('[name=target]').val(data['target']);
					$('.modal-tugas_tambahan').find('[name=satuan]').val(data['satuan']);
					$('.modal-tugas_tambahan').find('[name=quality]').val(data['quality']);
					$('.modal-tugas_tambahan').find('[name=target_waktu]').val(data['target_waktu']);
					$('.modal-tugas_tambahan').find('[name=cost]').val(data['cost']);
					
					$('.modal-tugas_tambahan').find('.btn-submit_tugas_tambahan').attr('id', 'submit-update_tugas_tambahan');
					$('.modal-tugas_tambahan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-tugas_tambahan').modal('show');
				},
				error: function(data){
					
				}						
		});	 
	
	});

	$(document).on('click','.hapus_tugas_tambahan',function(e){
		var tugas_tambahan_id = $(this).data('id') ;
		Swal.fire({
			title: "Hapus  Tugas Tambahan",
			text:"Uraian tugas tambahan akan ikut terhapus",
			//type: "warning",
			type: "question",
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
					url		: '{{ url("api_resource/hapus_tugas_tambahan") }}',
					type	: 'POST',
					data    : { tugas_tambahan_id:tugas_tambahan_id },
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
										$('#tugas_tambahan_table').DataTable().ajax.reload(null,false);
										jQuery('#tugas_tambahan_tree').jstree(true).refresh(true);
										jQuery('#tugas_tambahan_tree').jstree().deselect_all(true);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#tugas_tambahan_table').DataTable().ajax.reload(null,false);
											jQuery('#tugas_tambahan_tree').jstree(true).refresh(true);
											jQuery('#tugas_tambahan_tree').jstree().deselect_all(true);
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