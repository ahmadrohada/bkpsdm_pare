<style>
	td.dt-nowrap { white-space: nowrap }
	.no-sort::after { display: none!important; }
	.no-sort { pointer-events: none!important; cursor: default!important; }
	table{
	  margin: 0 auto;
	 
	  clear: both;
	  border-collapse: collapse;
	  table-layout: fixed; 
	  word-wrap:break-word;
	 /*  white-space: nowrap; */
	  text-overflow: ellipsis;
	  overflow: hidden;
	}
	
</style>

<div class="box-body table-responsive">
	<table id="tpp_report_table" class="table table-striped table-hover">
		<thead>
			<tr>
				<th rowspan="2" class="no-sort" width="23px;">NO</th>
				<th rowspan="2" width="200px;">NAMA</th>
				<th rowspan="2" width="145px;">NIP</th>
				<th rowspan="2" width="60px;">GOL</th>
				<th rowspan="2" width="250px;">JABATAN</th>
				<th rowspan="2" width="60px;">ESELON</th>
				<th rowspan="2" width="105px;">TPP</th>
				<th colspan="5" width="560px;">KINERJA ( {{ $kinerja }} % )</th>
				<th colspan="4" width="440px;">KEHADIRAN ( {{ $kehadiran }} % )</th>
				<th rowspan="2" width="105px;">TOTAL</th>
				<th rowspan="2" width="40px;"><i class="fa fa-cog"></i></th>
			</tr>
			<tr>
				<th>TPP x {{ $kinerja }} %</th>
				<th>CAPAIAN</th>
				<th>SKOR (%)</th>
				<th>POT (%)</th>
				<th>JM TPP ( Rp. )</th>

				<th>TPP x {{ $kehadiran }} %</th>
				<th>SKOR (%)</th>
				<th>POT (%)</th>
				<th>JM TPP ( Rp. )</th>
			</tr>
		</thead>
	</table>
</div>


@include('pare_pns.modals.tpp_report_data')


<script type="text/javascript">
	$('#tpp_report_table').DataTable({
		destroy: true,
	});


	function load_table_tpp() {
		$('#tpp_report_table').DataTable({
						destroy			: true,
						processing      : true,
						serverSide      : true,
						searching      	: true,
						paging          : true,
						autoWidth		: false,
						bInfo			: false,
						bSort			: true,
						lengthChange	: true,
						//order 			: [ 0 , 'desc' ],
						lengthMenu		: [10,25,50,100],
						columnDefs	: [	{ className: "text-center",targets: [0, 2,3,5,8,9,10,13,14,17]},
										{className: "text-right",targets: [6,7,11,12,15,16]},
										{ className: "dt-nowrap", "targets": [6,7,11,12,15,16 ] },
										@if ( request()->segment(5) == 'edit' )
											{ "visible": true, "targets": [17]}
										@else
											{ "visible": false, "targets": [17]}
										@endif

									],
						ajax		: {
										url: '{{ url("api_resource/skpd_tpp_report_data_list") }}',
										data: { tpp_report_id: {{ $tpp_report->id }}},

										},


						columns		: [{
											data: 'tpp_report_data_id',
											orderable: false,
											searchable: false,
											"render": function(data, type, row, meta) {
												return meta.row + meta.settings._iDisplayStart + 1;
											}
									}, 
									{
										data: "nama_pegawai",
										name: "nama_pegawai",
										orderable: false,
										searchable: true,
									},
									{
										data: "nip_pegawai",
										name: "nip_pegawai",
										orderable: false,
										searchable: false
									},
									{
										data: "gol",
										name: "gol",
										orderable: false,
										searchable: false
									},
									
									{
										data: "jabatan",
										name: "jabatan",
										orderable: false,
										searchable: false
									},
									
									{
										data: "eselon",
										name: "eselon",
										orderable: false,
										searchable: false
									},
									{
										data: "tunjangan",
										name: "tunjangan",
										orderable: false,
										searchable: false,
										
									},
									{
										data: "tpp_kinerja",
										name: "tpp_kinerja",
										orderable: false,
										searchable: false,
									},
									{
										data: "capaian",
										name: "capaian",
										orderable: false,
										searchable: false,
										width: "120px"
									},
									{
										data: "skor",
										name: "skor",
										orderable: false,
										searchable: false,
									},
									{
										data: "potongan_kinerja",
										name: "potongan_kinerja",
										orderable: false,
										searchable: false,
									},
									{
										data: "jm_tpp_kinerja",
										name: "jm_tpp_kinerja",
										orderable: false,
										searchable: false,
									},
									{
										data: "tpp_kehadiran",
										name: "tpp_kehadiran",
										orderable: false,
										searchable: false,
									},
									{
										data: "skor_kehadiran",
										name: "skor_kehadiran",
										orderable: false,
										searchable: false
									},
									{
										data: "potongan_kehadiran",
										name: "potongan_kehadiran",
										orderable: false,
										searchable: false
									},
									{
										data: "jm_tpp_kehadiran",
										name: "jm_tpp_kehadiran",
										orderable: false,
										searchable: false
									},
									{
										data: "total_tpp",
										name: "total_tpp",
										orderable: false,
										searchable: false
									},

									{
										data: "status",
										orderable: false,
										searchable: false,
										"render": function(data, type, row) {
										
												return '<span  data-toggle="tooltip" title="Ubah Data" style="margin:1px;" ><a class="btn btn-info btn-xs ubah_tpp_report_data_id"  data-id="' + row.tpp_report_data_id + '"><i class="fa fa-edit" ></i></a></span>';
											

										}
									}

						]

		});
	};



	$(document).on('click','.ubah_tpp_report_data_id',function(e){
		var tpp_report_data_id = $(this).data('id');
		show_loader();
		$.ajax({
			url		: '{{ url("api_resource/tpp_report_data_edit") }}',
			type	: 'GET',
			data	:  	{ 
							tpp_report_data_id : tpp_report_data_id
						},
			success	: function(data) {

					
					$('.nama_pegawai').html(data['nama_pegawai']); 
					$('.jabatan').html(data['jabatan']+' [ '+data['eselon']+' ]'); 
					$('.tpp_rupiah').html(data['tpp_rupiah']); 

					$('.persen_kinerja').html(data['persen_kinerja']); 
					$('.tpp_kinerja').html(data['tpp_kinerja']); 
					$('.capaian_kinerja').html(data['capaian']); 
					$('.skor_capaian').html(data['skor_capaian']); 
					$('.potongan_kinerja').html(data['pot_kinerja']); 
					$('.jm_tpp_kinerja').html(data['jm_tpp_kinerja']); 

					$('.persen_kehadiran').html(data['persen_kehadiran']); 
					$('.tpp_kehadiran').html(data['tpp_kehadiran']); 
					$('.skor_kehadiran').html(data['skor_kehadiran']); 
					$('.pot_kehadiran').html(data['pot_kehadiran']); 
					$('.jm_tpp_kehadiran').html(data['jm_tpp_kehadiran']); 

					//DATA BARU
					$('.new_tpp_rupiah').html(data['data_baru'].tpp_rupiah); 

					$('.new_persen_kinerja').html(data['data_baru'].persen_kinerja); 
					$('.new_tpp_kinerja').html(data['data_baru'].tpp_kinerja); 
					$('.new_capaian_kinerja').html(data['data_baru'].capaian); 
					$('.new_skor_capaian').html(data['data_baru'].skor_capaian); 
					$('.new_potongan_kinerja').html(data['data_baru'].pot_kinerja); 
					$('.new_jm_tpp_kinerja').html(data['data_baru'].jm_tpp_kinerja); 

					$('.new_persen_kehadiran').html(data['data_baru'].persen_kehadiran); 
					$('.new_tpp_kehadiran').html(data['data_baru'].tpp_kehadiran); 
					$('.new_skor_kehadiran').html(data['data_baru'].skor_kehadiran); 
					$('.new_pot_kehadiran').html(data['data_baru'].pot_kehadiran); 
					$('.new_jm_tpp_kehadiran').html(data['data_baru'].jm_tpp_kehadiran); 

					$('.tpp_report_data_id').val(data['tpp_report_data_id']); 
					$('.new_capaian_bulanan_id').val(data['data_baru'].capaian_bulanan_id); 
					$('.new_tpp_rupiah').val(data['data_baru'].ntpp_rupiah); 
					$('.new_tpp_kinerja').val(data['data_baru'].ntpp_kinerja); 
					$('.new_capaian_kinerja').val(data['data_baru'].capaian); 
					$('.new_skor_capaian').val(data['data_baru'].nskor_capaian); 
					$('.new_potongan_kinerja').val(data['data_baru'].pot_kinerja); 

					$('.new_tpp_kehadiran').val(data['data_baru'].ntpp_kehadiran); 
					$('.new_skor_kehadiran').val(data['data_baru'].nskor_kehadiran); 
					$('.new_pot_kehadiran').val(data['data_baru'].pot_kehadiran); 

					if ( ( ( data['tpp_rupiah'] != data['data_baru'].tpp_rupiah )|( data['capaian'] != data['data_baru'].capaian ) ) && ( data['data_baru'].capaian_bulanan_id != null ) ){
						$('.data_baru').removeClass('hidden');
					}else{
						$('.data_baru').addClass('hidden');
					}
					
					
					
					
					$('.modal-tpp_report_data').modal('show'); 
					swal.close();
				
			},
			error: function(jqXHR , textStatus, errorThrown) {
					swal.close();
					Swal.fire({
						title: 'Error!',
						text: '',
						type: 'error',
						confirmButtonText: 'Tutup'
					})
			}
			
		});
		
	});
	
</script>