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


<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Data TPP 
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
	</div>
	<div class="row" style="padding:5px 30px; min-height:200px;">
		<div class="box-body table-responsive">
			<table id="skp_bulanan_table" class="table table-striped table-hover">
				<thead>
					<tr class="success">
						<th rowspan="2" class="no-sort" width="23px;">NO</th>
						<th rowspan="2" class="no-sort" width="120px;">PERIODE</th> 
						<th rowspan="2" width="115px;">TPP</th>
						<th colspan="5" width="560px;">KINERJA</th>
						<th colspan="4" width="440px;">KEHADIRAN</th>
						<th rowspan="2" width="115px;">TOTAL</th>
					</tr>
					<tr>
						<th>TPP</th>
						<th>CAPAIAN</th>
						<th>SKOR (%)</th>
						<th>POT (%)</th>
						<th>JM TPP ( Rp. )</th>
		
						<th>TPP</th>
						<th>SKOR (%)</th>
						<th>POT (%)</th>
						<th>JM TPP ( Rp. )</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

@include('pare_pns.modals.create_capaian_bulanan_confirm')

<script type="text/javascript">
	$('#skp_bulanan_table').DataTable({
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				bInfo			: false,
				bSort			: false,
				//order 			: [ 1, 'desc' ],
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [12,24,48],
				columnDefs		: [
										{ className: "text-center",targets: [0,1,4,5,6,9]},
										{className: "text-right",targets: [2,3,7,8,11,12]},
										//{ className: "dt-nowrap", "targets": [2] },
								],
				ajax			: {
									url	: '{{ url("api_resource/personal_tpp_report_data_list") }}',
									data: { pegawai_id : {!! $pegawai->id !!} },
									delay:3000

								},
				
				//rowsGroup		: [1],
				columns			:[
								{ data: 'capaian_id',searchable:false,width:"35px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "periode" , name:"periode",searchable: true},
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
								
							]
			
	});


	$(document).on('click','.edit_capaian_bulanan',function(e){
		var capaian_id = $(this).data('id') ;
		window.location.assign("capaian-bulanan/"+capaian_id+"/edit");
	});

	$(document).on('click','.ralat_capaian_bulanan',function(e){
		var capaian_id = $(this).data('id') ;
		window.location.assign("capaian-bulanan/"+capaian_id+"/ralat");
	});

	$(document).on('click','.lihat_capaian_bulanan',function(e){
		var capaian_id = $(this).data('id') ;
		window.location.assign("capaian-bulanan/"+capaian_id);
	});
	
	$(document).on('click','.create_capaian_bulanan',function(e){
		show_loader();
		var skp_bulanan_id = $(this).data('skp_bulanan_id') ;
		

		$.ajax({
			url		: '{{ url("api_resource/create_capaian_bulanan_confirm") }}',
			type	: 'GET',
			data	:  	{ 
							skp_bulanan_id : skp_bulanan_id
						},
			success	: function(data) {
				
				if (data['status']==='pass'){

					$('#periode_label').html(data['periode_label']); 
					$('.mulai').val(data['tgl_mulai']); 
					$('.selesai').val(data['tgl_selesai']); 
					//$('#jm_kegiatan_bulanan').html(data['jm_kegiatan_bulanan']);
					if ( data['jenis_jabatan'] == 4 ){
						$('.label_bawahan').hide();
					}


					var kegiatan_list = document.getElementById('list_bawahan');
					for(var i = 0 ; i < data['list_bawahan'].length; i++ ){
						$('.header_list').show(); 
						if ( data['list_bawahan'][i].jabatan == 'Dilaksanakan Sendiri'){
							$("<li class='list-group-item' style='padding:1px 4px 1px 4px;;'>&nbsp;<a class='pull-right'></a> </li>").appendTo(kegiatan_list);
							$("<li class='list-group-item' style='padding:3px 4px 3px 4px;;'>"+data['list_bawahan'][i].jabatan+" <a class='pull-right'>"+data['list_bawahan'][i].t_kegiatan+"</a> </li>").appendTo(kegiatan_list);
						}else{
							$("<li class='list-group-item' style='padding:3px 4px 3px 4px;;'>"+data['list_bawahan'][i].jabatan+" <a class='pull-right'>"+data['list_bawahan'][i].t_kegiatan+"</a> </li>").appendTo(kegiatan_list);
						}
					
					}
						$("<li class='list-group-item' style='padding:3px 4px 3px 4px;;'>Uraian Tugas Tambahan <a class='pull-right'>"+data['jm_uraian_tugas_tambahan']+"</a> </li>").appendTo(kegiatan_list);
						$("<li class='list-group-item' style='background:#ededed; border-top:solid #3d3d3d 2px; padding:5px 4px 5px 4px;'><b>Total Kegiatan </b><a class='pull-right'>"+data['jm_kegiatan_bulanan']+"</a> </li>").appendTo(kegiatan_list);
						
						
					$('#u_nip').html(data['u_nip']); 
					$('#u_nama').html(data['u_nama']); 
					$('#u_golongan').html(data['u_pangkat']+' / '+data['u_golongan']); 
					$('#u_eselon').html(data['u_eselon']); 
					$('#u_jabatan').html(data['u_jabatan']); 
					$('#u_unit_kerja').html(data['u_unit_kerja']); 
					$('#txt_u_jabatan').html(data['u_jabatan']); 
					$('#txt_u_skpd').html(data['u_skpd']); 


					$('#p_nip').html(data['p_nip']); 
					$('#p_nama').html(data['p_nama']); 
					$('#p_golongan').html(data['p_pangkat']+' / '+data['p_golongan']); 
					$('#p_eselon').html(data['p_eselon']); 
					$('#p_jabatan').html(data['p_jabatan']); 
					$('#p_unit_kerja').html(data['p_unit_kerja']); 

					$('.pegawai_id').val(data['pegawai_id']); 
					$('.skp_bulanan_id').val(data['skp_bulanan_id']); 
					$('.jm_kegiatan_bulanan').val(data['jm_kegiatan_bulanan']);
					$('.u_nama').val(data['u_nama']); 
					$('.u_jabatan_id').val(data['u_jabatan_id']); 
					$('.p_nama').val(data['p_nama']); 
					$('.p_jabatan_id').val(data['p_jabatan_id']);
 
					$('.jenis_jabatan').val(data['u_jenis_jabatan']); 
					$('.jabatan_id').val(data['jabatan_id']);
					$('.renja_id').val(data['renja_id']);
					$('.waktu_pelaksanaan').val(data['waktu_pelaksanaan']);
					
					$('.modal-create_capaian_bulanan_confirm').modal('show'); 
				}else if (data['status']==='fail'){
				




				}else{
					Swal.fire({
						title: 'Error!',
						text: 'Capaian Bulanan belum bisa dibuat',
						type: 'error',
						confirmButtonText: 'Tutup'
					})
				}
				
			},
			error: function(jqXHR , textStatus, errorThrown) {

					Swal.fire({
						title: 'Error!',
						text: 'Capaian Bulanan  belum bisa dibuat',
						type: 'error',
						confirmButtonText: 'Tutup'
					})
			}
			
		})
	});

	$(document).on('click','.hapus_capaian_bulanan',function(e){
		var capaian_bulanan_id = $(this).data('id') ;

		Swal.fire({
			title: "Hapus  Capaian Bulanan",
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
					url		: '{{ url("api_resource/hapus_capaian_bulanan") }}',
					type	: 'POST',
					data    : { capaian_bulanan_id:capaian_bulanan_id },
					cache   : false,
					success:function(data){
							$('.personal_jm_capaian_tahunan').html(data['jm_capaian_tahunan']);
							$('.personal_jm_capaian_bulanan').html(data['jm_capaian_bulanan']);
							$('.personal_jm_capaian_triwulan').html(data['jm_capaian_triwulan']);
							Swal.fire({
									title: "",
									text: "Sukses",
									type: "success",
									width: "200px",
									showConfirmButton: false,
									allowOutsideClick : false,
									timer: 900
									}).then(function () {
										$('#skp_bulanan_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#skp_bulanan_table').DataTable().ajax.reload(null,false);
											
											
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
