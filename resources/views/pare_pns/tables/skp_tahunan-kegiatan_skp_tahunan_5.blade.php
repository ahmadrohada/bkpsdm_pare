<div class="box-body table-responsive" style="min-height:330px;">
	<div class="toolbar"> 
		@if ( ( request()->segment(4) == 'edit' ) | ( request()->segment(4) == 'ralat' ) )
			<span  data-toggle="tooltip" title="Tambah Kegiatan"><a class="btn btn-info btn-sm create_kegiatan" ><i class="fa fa-plus" ></i> Tambah Kegiatan</a></span>
		@endif
	</div>
	<table id="kegiatan_skp_tahunan_5_table" class="table table-striped table-hover" >
		<thead>
			<tr>
				<th rowspan="2">No</th>
				<th rowspan="2" style="white-space: nowrap; padding: 3px 120px;">KEGIATAN TAHUNAN</th>
				<th colspan="4">TARGET</th>
				<th rowspan="2"><i class="fa fa-cog"></i></th>
			</tr>
			<tr>
				<th style="padding: 3px 25px;">AK</th>
				<th style="padding: 3px 20px;">QUANTITY</th>
				<th>WAKTU</th>
				<th style="padding: 3px 30px;">ANGGARAN</th>

			</tr>
		</thead>
						
	</table>
</div>

@include('pare_pns.modals.kegiatan_tahunan_jft')


@include('pare_pns.modals.kegiatan_skp_tahunan-add')

<script type="text/javascript">

	$('#kegiatan_skp_tahunan_5_table').DataTable({ 
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				bInfo			: false,
				bSort			: false,
				lengthChange	: false,
				lengthMenu		: [25,50,100], 
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3,4,6 ] },
									{ className: "text-right", targets: [ 5 ] },
									@if ( ( request()->segment(4) != 'edit' ) & ( request()->segment(4) != 'ralat' ) )
											{ "visible": false, "targets": [6]}
									@else
											{ "visible": true, "targets": [6]}
									@endif
								],
				ajax			: {
									url	: '{{ url("api/kegiatan_skp_tahunan_5") }}',
									data: { "skp_tahunan_id" : {!! $skp->id !!} },
								},
				columns			: [
									{ data: 'kegiatan_skp_tahunan_id' ,
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
									{ data: "kegiatan_skp_tahunan_label", name:"kegiatan_skp_tahunan_label"}, 
									{ data: "target_ak", name:"target_ak" },
									{ data: "target_quantity", name:"target_quantity"},
									{ data: "target_waktu", name:"target_waktu"},
									{ data: "target_cost", name:"target_cost"},
									{  data: 'kegiatan_skp_bulanan_count',width:"60px",
										"render": function ( data, type, row ) {
											if ( row.kegiatan_skp_bulanan_count >= 1 ){
												return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_kegiatan_tahunan"  data-id="'+row.kegiatan_skp_tahunan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
														'<span  style="margin:2px;" ><a class="btn btn-default btn-xs" disabled><i class="fa fa-close " ></i></a></span>';
											
											}else{
												return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_kegiatan_tahunan"  data-id="'+row.kegiatan_skp_tahunan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
														'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_kegiatan_tahunan"  data-id="'+row.kegiatan_skp_tahunan_id+'" data-label="'+row.kegiatan_skp_tahunan_label+'" ><i class="fa fa-close " ></i></a></span>';
											
											}
											
										}
									},
								],
								initComplete: function(settings, json) {
								
							}
	});	

	$(document).on('click','.create_kegiatan',function(e){
		show_modal_kegiatan(0);
	});

	

	$(document).on('click','.edit_kegiatan_tahunan',function(e){
		var kegiatan_tahunan_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api/kegiatan_tahunan_detail_jft") }}',
				data 		: {kegiatan_tahunan_id : kegiatan_tahunan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {

					//Add data sasaran to select2
					var option = new Option(data['sasaran_label'],data['sasaran_id'],true,true);
					$('.modal-kegiatan_tahunan_jft').find('[name=sasaran_id]').append(option).trigger('change');

					$('.modal-kegiatan_tahunan_jft').find('[name=label]').val(data['label']);
					$('.modal-kegiatan_tahunan_jft').find('[name=angka_kredit]').val(data['ak']);
					$('.modal-kegiatan_tahunan_jft').find('[name=target]').val(data['target']);
					$('.modal-kegiatan_tahunan_jft').find('[name=quality]').val(data['quality']);
					$('.modal-kegiatan_tahunan_jft').find('[name=satuan]').val(data['satuan']);
					$('.modal-kegiatan_tahunan_jft').find('[name=target_waktu]').val(data['target_waktu']);
					$('.modal-kegiatan_tahunan_jft').find('[name=cost]').val(data['cost']);

					$('.modal-kegiatan_tahunan_jft').find('[name=kegiatan_tahunan_id]').val(data['id']);
					$('.modal-kegiatan_tahunan_jft').find('h4').html('Edit Kegiatan Tahunan');
					$('.modal-kegiatan_tahunan_jft').find('.btn-submit').attr('id', 'submit-update');
					$('.modal-kegiatan_tahunan_jft').find('[name=text_button_submit]').html('Update Data');
					$('.modal-kegiatan_tahunan_jft').modal('show');
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
					url		: '{{ url("api/hapus_kegiatan_tahunan_jft") }}',
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
										$('#kegiatan_skp_tahunan_5_table').DataTable().ajax.reload(null,false);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#kegiatan_skp_tahunan_5_table').DataTable().ajax.reload(null,false);
											
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