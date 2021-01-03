@if ( request()->segment(4) == 'edit' )
	<span><a class="btn btn-info btn-sm add_uraian_tugas_tambahan" ><i class="fa fa-plus" ></i> Add Uraian Tugas Tambahan</a></span>
@endif

<div class="box-body table-responsive" style="min-height:330px;">
	<div class="toolbar" style="margin-top:-30px;"> 
			
	</div>
	<table id="uraian_tugas_tambahan_table" class="table table-striped table-hover" >
		<thead>
			<tr>
				<th >No</th>
				
				<th >URAIAN TUGAS TAMBAHAN</th>
				<th >TUGAS TAMBAHAN</th>
				<th >TARGET OUTPUT</th>
				<th ><i class="fa fa-cog"></i></th>
			</tr>
		</thead>
							
	</table>
</div>



@include('pare_pns.modals.skp_bulanan_uraian_tugas_tambahan')

<script type="text/javascript">

	function LoadUraianTugasTambahanTable(){
		$('#uraian_tugas_tambahan_table').DataTable({
					destroy			: true,
					processing      : true,
					serverSide      : true,
					searching      	: true,
					paging          : true,
					autoWidth		: false,
					bInfo			: true,
					bSort			: false,
					lengthChange	: false,
					//order 		: [ 0 , 'asc' ],
					lengthMenu		: [20,50,100,200],
					columnDefs		: [
										{ className: "text-center", targets: [ 0,3,4 ] },
										/* { className: "text-right", targets: [ 6 ] }, */
										{ "orderable": false, targets: [ 2,3,4 ]  },
										@if ( request()->segment(4) != 'edit' )
											{ "visible": false, "targets": [4]}
										@else
											{ "visible": true, "targets": [4]}
										@endif
									],
					ajax			: {
										url		: '{{ url("api/uraian_tugas_tambahan_list") }}',
										data	: { 
													"skp_bulanan_id" : {!! $skp->id !!}
												  },
										cache : false,
										quietMillis: 500,
									},
					rowsGroup		: [2],
					columns			: [
										{ data: 'kegiatan_tahunan_id',width:"30px",
											"render": function ( data, type, row ,meta) {
												return meta.row + meta.settings._iDisplayStart + 1 ;
											}
										},
										
										{ data: "label", name:"uraian_tugas_tambahan_label"},
										{ data: "tugas_tambahan_label", name:"tugas_tambahan_label", width:"320px"},
										{ data: "output", name:"output",width:"140px",},
										{  data: 'action',width:"60px",
											"render": function ( data, type, row ) {
												return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_uraian_tugas_tambahan"  data-id="'+row.uraian_tugas_tambahan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
														'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_uraian_tugas_tambahan"  data-id="'+row.uraian_tugas_tambahan_id+'" data-label="'+row.label+'" ><i class="fa fa-close " ></i></a></span>';
												
											}
										},
									
									],
									initComplete: function(settings, json) {
									
								}
		});	
	}
	


	$(document).on('click','.add_uraian_tugas_tambahan',function(e){
	
		$('.modal-uraian_tugas_tambahan').find('h4').html('Add Uraian Tugas Tambahan');
		$('.modal-uraian_tugas_tambahan').find('[name=label],[name=angka_kredit],[name=target],[name=satuan],[name=target_waktu],[name=cost]').val("");
		$('.modal-uraian_tugas_tambahan').find('[name=quality]').val(100);
		$('.modal-uraian_tugas_tambahan').find('.btn-submit_uraian_tugas_tambahan').attr('id', 'submit-save_uraian_tugas_tambahan');
		$('.modal-uraian_tugas_tambahan').find('[name=text_button_submit]').html('Simpan Data');
		
		$('.modal-uraian_tugas_tambahan').modal('show');  
	});


	$(document).on('click','.edit_uraian_tugas_tambahan',function(e){
		var uraian_tugas_tambahan_id = $(this).data('id') ;
		
		$.ajax({
				url			: '{{ url("api/uraian_tugas_tambahan_detail") }}',
				data 		: {uraian_tugas_tambahan_id : uraian_tugas_tambahan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					$('.modal-uraian_tugas_tambahan').find('h4').html('Edit Uraian Tugas Tambahan');
					$('.modal-uraian_tugas_tambahan').find('[name=uraian_tugas_tambahan_id]').val(data['id']);
					$('.modal-uraian_tugas_tambahan').find('[name=skp_bulanan_id]').val(data['skp_bulanan_id']);

					var option = new Option(data['tugas_tambahan_label'],data['tugas_tambahan_id'],true,true);
					$('.modal-uraian_tugas_tambahan').find('[name=tugas_tambahan_id]').append(option).trigger('change');

					$('.modal-uraian_tugas_tambahan').find('[name=label]').val(data['label']);
					$('.modal-uraian_tugas_tambahan').find('[name=target]').val(data['target']);
					$('.modal-uraian_tugas_tambahan').find('[name=satuan]').val(data['satuan']);
					
					$('.modal-uraian_tugas_tambahan').find('.btn-submit_uraian_tugas_tambahan').attr('id', 'submit-update_uraian_tugas_tambahan');
					$('.modal-uraian_tugas_tambahan').find('[name=text_button_submit]').html('Update Data');
					$('.modal-uraian_tugas_tambahan').modal('show');
				},
				error: function(data){
					
				}						
		});	 
	
	});

	$(document).on('click','.hapus_uraian_tugas_tambahan',function(e){
		var uraian_tugas_tambahan_id = $(this).data('id') ;
		Swal.fire({
			title: "Hapus Uraian  Tugas Tambahan",
			text:"",
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
					url		: '{{ url("api/hapus_uraian_tugas_tambahan") }}',
					type	: 'POST',
					data    : { uraian_tugas_tambahan_id:uraian_tugas_tambahan_id },
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
										$('#uraian_tugas_tambahan_table').DataTable().ajax.reload(null,false);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#uraian_tugas_tambahan_table').DataTable().ajax.reload(null,false);
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