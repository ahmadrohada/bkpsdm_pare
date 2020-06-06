<div class="box {{ $h_box }}">
	<div class="box-header with-border">
		<h1 class="box-title">
			Data TPP Report 
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}

		</div>
	</div>
	<div class="row" style="padding:5px 30px; min-height:200px;">
		<div class="box-body table-responsive">
			<span data-toggle="tooltip" title="Create Report"><a class="btn btn-info btn-xs create_tpp_report "><i class="fa fa-plus"></i> Create TPP Report</a></span>
			<div class="toolbar">
				
			</div>
			<table id="skpd_tpp_report_list_table" class="table table-striped table-hover table-condensed">
				<thead>
					<tr class="success">
						<th>NO</th>
						<th>PERIODE</th>
						<th>NAMA ADMIN</th>
						<th>JUMLAH DATA</th>
						<th>CREATED AT</th>
						<th>STATUS</th>
						<th><i class="fa fa-cog"></i></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
@include('pare_pns.modals.create-tpp_report')
@include('pare_pns.modals.cetak-tpp_report')

<script type="text/javascript">

	$(document).on('click','.create_tpp_report',function(e){
		$.ajax({
				url		: 		'{{ url("api_resource/create_tpp_report_confirm") }}',
				type	: 'GET',
				data	:  	{ 
								skpd_id : {{ $skpd->id }},
								admin_id : {{ $pegawai_id }}
							},
				success	: function(data) {
							$('.skpd_id').val(data['skpd_id']); 
							$('.periode_id').val(data['periode_id']); 
							$('.ka_skpd').val(data['ka_skpd']); 
							$('.admin_skpd').val(data['admin_skpd']); 
							$('.formula_hitung_id').val("1"); 
							
							$('.nama_skpd').html(data['nama_skpd']); 
							$('.jumlah_pegawai').html(data['jumlah_pegawai']);
							$('.tahun').html(data['tahun']); 
							
							$('.create-tpp_report_modal').modal('show'); 
				
				},
				error: function(jqXHR , textStatus, errorThrown) {
						Swal.fire({
							title: 'Error!',
							text: 'Terjadi kesalahan saat pengambilan data',
							type: 'error',
							confirmButtonText: 'Tutup'
						})
				}
			
		});
		
	});



	$('#skpd_tpp_report_list_table').DataTable({
					destroy			: true,
					processing      : true,
					serverSide      : true,
					searching      	: true,
					paging          : true,
					autoWidth		: false,
					deferRender		: true,
					bInfo			: false,
					bSort			: true,
					lengthChange	: false,
					order 			: [ 2 , 'desc' ],
					lengthMenu		: [10,25,50],
					columnDefs: [
									{className: "text-center",targets: [0,1,2,3,4,5,6]}
								],
					ajax: {
						url		: '{{ url("api_resource/skpd_tpp_report_list") }}',
						data	: { skpd_id : {{$skpd->id}} },
						delay	: 3000

					},
		columns: [ { data: 'tpp_report_id',orderable: true,searchable: false,
						"render": function(data, type, row, meta) {
							return meta.row + meta.settings._iDisplayStart + 1;
						}
					},
					{data: "periode",name: "periode",orderable: true,searchable: true},
					{data: "nama_admin",name: "nama_admin"},
					{data: "jumlah_data",name: "jumlah_data"},
					{data: "created_at",name: "created_at"},
					{data: "status",orderable: true,searchable: false,width: "80px",
									"render": function(data, type, row) {
											if (row.status == '1' ) {
												return 	'[ close ]';
											} else {
												return 	'<span style="color:red; margin:2px;" >[ open ]</span>';
											}
									}
								},
					{data: "status",orderable: false,searchable: false,width: "120px",
						"render": function(data, type, row) {
								if (row.status == '1' ) {
									//close
									return 	'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_tpp_report_data"  data-id="' + row.tpp_report_id + '"><i class="fa fa-eye" ></i></a></span>' +
											'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-default btn-xs"><i class="fa fa-close " ></i></a></span>'+
											'<span  data-toggle="tooltip" title="Cetak" style="margin:2px;" ><a class="btn btn-warning btn-xs cetak_tpp_report_data" data-id="' + row.tpp_report_id + '"><i class="fa fa-print" ></i></a></span>';
								} else {
									//open
									return 	'<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_tpp_report_data" data-id="' + row.tpp_report_id + '"><i class="fa fa-pencil" ></i></a></span>' +
											'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_tpp_report_data" data-id="' + row.tpp_report_id + '"><i class="fa fa-close " ></i></a></span>'+
											'<span  data-toggle="tooltip" title="Cetak" style="margin:2px;" ><a class="btn btn-warning btn-xs cetak_tpp_report_data" data-id="' + row.tpp_report_id + '"><i class="fa fa-print" ></i></a></span>';
								}
						}
					},

				]

	});


	$(document).on('click', '.edit_tpp_report_data', function(e) {
		var tpp_report_id = $(this).data('id');
		window.location.assign("report/tpp/" + tpp_report_id + "/edit");
	});

	

	$(document).on('click', '.lihat_tpp_report_data', function(e) {
		var tpp_report_id = $(this).data('id');
		window.location.assign("report/tpp/" + tpp_report_id);
	});

	$(document).on('click', '.cetak_tpp_report_data', function(e) {
		var tpp_report_id = $(this).data('id');
		$.ajax({
				url		: '{{ url("api_resource/tpp_report_detail") }}',
				type	: 'GET',
				data	:  	{ tpp_report_id : tpp_report_id },
				success	: function(data) {
							
							$('.tpp_report_id').val(tpp_report_id); 
							$('.nama_skpd').html(data['nama_skpd']); 
							$('.jumlah_pegawai').html(data['jm_data_pegawai']);
							$('.periode').html(data['periode']); 
							
							$('.cetak-tpp_report_modal').modal('show'); 
				
				},
				error: function(jqXHR , textStatus, errorThrown) {
						Swal.fire({
							title: 'Error!',
							text: 'Terjadi kesalahan saat pengambilan data',
							type: 'error',
							confirmButtonText: 'Tutup'
						})
				}
			
		});
		
	});

	

	$(document).on('click', '.hapus_tpp_report_data', function(e) {
		var tpp_report_id = $(this).data('id');

		Swal.fire({
			title: "Hapus TPP Report",
			text: "",
			type: "warning",
			//type: "question",
			showCancelButton: true,
			cancelButtonText: "Batal",
			confirmButtonText: "Hapus",
			confirmButtonClass: "btn btn-success",
			cancelButtonColor: "btn btn-danger",
			cancelButtonColor: "#d33",
			closeOnConfirm: false,
			closeOnCancel: false
		}).then((result) => {
			if (result.value) {
				$.ajax({
					url: '{{ url("api_resource/hapus_tpp_report") }}',
					type: 'POST',
					data: {
						tpp_report_id: tpp_report_id
					},
					cache: false,
					success: function(data) {
						Swal.fire({
							title: "",
							text: "Sukses",
							type: "success",
							width: "200px",
							showConfirmButton: false,
							allowOutsideClick: false,
							timer: 900
						}).then(function() {
								$('#skpd_tpp_report_list_table').DataTable().ajax.reload(null, false);

							},
							function(dismiss) {
								if (dismiss === 'timer') {
									$('#skpd_tpp_report_list_table').DataTable().ajax.reload(null, false);


								}
							}
						)


					},
					error: function(e) {
						Swal.fire({
							title: "Gagal",
							text: "",
							type: "warning"
						}).then(function() {

						});
					}
				});
			}
		});
	});
</script>