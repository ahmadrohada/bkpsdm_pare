<div class="box {{ $h_box }}">
	<div class="box-header with-border">
		<h1 class="box-title">
			Data TPP Report
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}

		</div>
	</div>
	<div class="box-body table-responsive">

		<div class="toolbar">
			<span data-toggle="tooltip" title="Create Report"><a class="btn btn-info btn-xs create_tpp_report "><i class="fa fa-plus"></i> Create TPP Report</a></span>
		</div>

		<table id="skpd_tpp_report_list_table" class="table table-striped table-hover table-condensed">
			<thead>
				<tr class="success">
					<th>NO</th>
					<th>PERIODE</th>
					<th>JUMLAH DATA</th>
					<th>REPORT</th>
				</tr>
			</thead>


		</table>

	</div>
</div>
@include('admin.modals.create-tpp_report')

<script type="text/javascript">


	/* $(document).on('click', '.create_tpp_report', function(e) {



    



		
		$('.nama_skpd').html('{!! $skpd->skpd !!}');
		$('.skpd_id').val('{!! $skpd->id !!}');
		$('.create-tpp_report_modal').find('[name=periode_tahun],[name=periode_bulan]').val(''); 


	}); */


	$(document).on('click','.create_tpp_report',function(e){
		
		$.ajax({
			url		: '{{ url("api_resource/create_tpp_report_confirm") }}',
			type	: 'GET',
			data	:  	{ 
							skpd_id : {{ $skpd->id }},
							admin_id : {{ $pegawai_id }}
						},
			success	: function(data) {

				if ( data['status']==='0' ){
					$('.skpd_id').val(data['skpd_id']); 
					$('.periode_id').val(data['periode_id']); 
					$('.bulan').val(data['bulan']); 
					$('.ka_skpd').val(data['ka_skpd']); 
					$('.admin_skpd').val(data['admin_skpd']); 


					$('.nama_skpd').html(data['nama_skpd']); 
					$('.jumlah_pegawai').html(data['jumlah_pegawai']);
					
					$('.create-tpp_report_modal').modal('show'); 
				}else if ( data['status'] === '1'){

					Swal.fire({
						title: "Create TPP Report",
						text:"TPP Report untuk bulan ini sudah dibuat",
						type: "warning",
						confirmButtonText: "Close",
						confirmButtonColor: "btn btn-success",
					});

					
				}else{
					Swal.fire({
						title: 'Error!',
						text: '',
						type: 'error',
						confirmButtonText: 'Tutup'
					})
				}
				
			},
			error: function(jqXHR , textStatus, errorThrown) {

					Swal.fire({
						title: 'Error!',
						text: '',
						type: 'error',
						confirmButtonText: 'Tutup'
					})
			}
			
		});
		
	});



	$('#skpd_tpp_report_list_table').DataTable({
		processing: true,
		serverSide: true,
		searching: false,
		paging: false,
		order: [2, 'desc'],
		//dom 			: '<"toolbar">frtip',
		lengthMenu: [50, 100],
		columnDefs: [{
				className: "text-center",
				targets: [0, 1, 2, 3]
			}
		],
		ajax: {
			url		: '{{ url("api_resource/skpd_tpp_report_list") }}',
			data	: { skpd_id : {{$skpd->id}} },

			delay	: 3000

		},


		columns: [{
				data: 'tpp_report_id',
				orderable: true,
				searchable: false,
				"render": function(data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}
			},

			{
				data: "periode",
				name: "periode",
				orderable: true,
				searchable: true
			},
			{
				data: "jumlah_data",
				name: "jumlah_data"
			},
			{
				data: "status",
				orderable: false,
				searchable: false,
				width: "120px",
				"render": function(data, type, row) {
					if (row.status == '1' ) {
						//close
						return '<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_tpp_report_data"  data-id="' + row.tpp_report_id + '"><i class="fa fa-eye" ></i></a></span>' +
							'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-default btn-xs"><i class="fa fa-close " ></i></a></span>';
					} else {
						//open
						return '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_tpp_report_data" data-id="' + row.tpp_report_id + '"><i class="fa fa-pencil" ></i></a></span>' +
							'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_tpp_report_data" data-id="' + row.tpp_report_id + '"><i class="fa fa-close " ></i></a></span>';
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
		window.location.assign("tpp/" + tpp_report_id);
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