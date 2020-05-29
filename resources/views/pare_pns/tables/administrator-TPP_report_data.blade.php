<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Data TPP Report [ Administrator ]
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body table-responsive">

		<table id="tpp_data_table" class="table table-striped table-hover table-condensed">
			<thead>
				<tr class="success">
					<th>NO</th>
					<th>PERIODE</th>
					<th>SKPD</th>
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


@include('pare_pns.modals.cetak-tpp_report')
<script type="text/javascript">

	$('#tpp_data_table').DataTable({
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				order 			: [ 5 , 'desc' ],
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,4,5,6,7 ] }/* ,
									//{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api_resource/administrator_tpp_report_list") }}',
									
									delay:3000
								},
				

				columns	:[
								{ data: 'skp_tahunan_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "periode" ,  name:"bulan", orderable: true, searchable: true},
								{ data: "skpd" ,  name:"skpd", orderable: true, searchable: true},
								{data: "nama_admin",name: "nama_admin"},
								{data: "jumlah_data",name: "jumlah_data"},
								{ data: "created_at" ,  name:"created_at", orderable: true, searchable: true},
								{data: "status",orderable: true,searchable: false,width: "80px",
									"render": function(data, type, row) {
											if (row.status == '1' ) {
												return 	'[ close ]';
											} else {
												return 	'<span style="color:red; margin:2px;" >[ open ]</span>';
											}
									}
								},
								{data: "status",orderable: true,searchable: false,width: "80px",
									"render": function(data, type, row) {
											return 	'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_tpp_report_data"  data-id="' + row.tpp_report_id + '"><i class="fa fa-eye" ></i></a></span>' +
													'<span  data-toggle="tooltip" title="Cetak" style="margin:2px;" ><a class="btn btn-warning btn-xs cetak_tpp_report_data" data-id="' + row.tpp_report_id + '"><i class="fa fa-print" ></i></a></span>';
											
									}
								},
								
							]
			
	});
	
	
	$(document).on('click', '.lihat_tpp_report_data', function(e) {
		var tpp_report_id = $(this).data('id');
		window.location.assign("tpp_report/" + tpp_report_id);
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
</script>
