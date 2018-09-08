<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
			<small>
				
				<span class="text-primary"> {!!  Pustaka::nama_pegawai($user->pegawai->gelardpn , $user->pegawai->nama , $user->pegawai->gelarblk) !!}</span>
			</small>
        </h3>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>


	
	<div class="box-body table-responsive">
	<a  class="btn btn-sm btn-success create_skp_tahunan" href="#" title="" style=""><span class="fa fa-plus"></span> Create SKP Tahunan</a>

		<table id="skp_tahunan"  class="table table-striped table-hovers" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >PERIODE</th>
                    <th>MASA PENILAIAN</th>
					<th>PEJABAT PENIALAI</th>
					<th>STATUS</th>
					<th><i class="fa fa-cog"></i></th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>

@include('admin.modals.create-skp_tahunan_confirm')


   


<script type="text/javascript">
$(document).ready(function() {
	//alert();
	/* $('.create-skp_tahunan_confirm_modal').on('hidden.bs.modal', function(){
		$('#skp_tahunan').DataTable().ajax.reload(null,false);
		
	}); */
	


	$(document).on('click','.create_skp_tahunan',function(e){
	 
		$('.periode_perjanjian_kinerja').html('2018');


		$.ajax({
      		method    : "GET",
     		url       : '{{ url("api_resource/create_skp_tahunan_confirm") }}',
			data      : { pegawai_id: {{ $user->pegawai->id }} },
			dataType  : "json",
			success   : function (data) {

				$('.periode_tahunan').html(data['periode_tahunan']);
				$('.mulai').val(data['tgl_mulai']);
				$('.selesai').val(data['tgl_selesai']);

				
				$('.u_nama').html(data['u_nama']);
				$('.u_nip').html(data['u_nip']);
				$('.u_pangkat_golongan').html(data['u_pangkat']+ '/' +data['u_golongan']);

				$('.u_jabatan').html(data['u_jabatan']);
				$('.u_unit_kerja').html(data['u_unit_kerja']);
				$('.u_skpd').html(data['u_skpd']);


				$('.pegawai_id').val(data['pegawai_id']);
				$('.perjanjian_kinerja_id').val(data['perjanjian_kinerja_id']);
				$('.tgl_mulai').val(data['tgl_mulai']);
				$('.tgl_selesai').val(data['tgl_selesai']);
				$('.jabatan_id').val(data['jabatan_id']);
				$('.u_nama').val(data['u_nama']);

				
				
				$('.create-skp_tahunan_confirm_modal').modal('show');
			},
			error: function(data) {
				swal({
						title: "Error",
						text: "SKP Tahunan Sudah dibuat untuk Periode saat ini",
						type: "warning"
					}).then (function(){
						default_a();	
						
						
					}); 
					
			} 
		});


		//pegawai
		

		//atasan
		/* $('.p_nip').html('nip atasan');
		$('.p_nama').html('nama atasan');
		$('.p_jabatan').html('jabatan atasan');
		$('.p_eselon').html('eselon atasan');
		$('.p_unit_kerja').html('unit_kerja atasan');
		$('.p_skpd').html('skpd atasan'); */





		
		
	});

   
	
	var table = $('#skp_tahunan').DataTable({
		serverSide		: true,
		select			: true,
		searching      	: false,
		paging          : false,
		columnDefs		: [
							{ className: "text-center", targets: [ 0,1,2,4,5 ] }
						  ],
		ajax			: {
							url: '{{ url("api_resource/personal_skp_tahunan_list") }}',
							data: { skpd_id:{{ $skpd->id }} },
							type: 'GET'
						  },
		columns			: [
							{ data: null , orderable: false,searchable:false, width:"80px",
									render : function ( data, type, row ) {
										return data.rownum;
									}
							},
							{ data: "periode", name:"periode", orderable: true, searchable: true,width:"200px"},
							{ data: "masa_penilaian" ,  name:"masa_penilaian", orderable: false, searchable: false},
							{ data: "pejabat_penilai" ,  name:"pejabat_penilai", orderable: false, searchable: false},
							{ data: 'step' , orderable: false,searchable:false, width:"80px",
									"render": function ( data, type, row ) {
										if (row.step == '1'){
										return 	[  	'<i class="fa fa-send" data-toggle="tooltip" data-placement="right" title="SKP menunggu approve dari atasan"></i>'
												];
										}else if(row.step == '2'){
										return 	[  	'<i class="fa fa-check" data-toggle="tooltip" data-placement="right" title="SKP disetujui oleh atasan"></i>'
												];
										}else if(row.step == '3'){
										return 	[  	'<i class="fa fa-remove" data-toggle="tooltip" data-placement="right" title="SKP ditolak oleh atasan"></i>'
												];
										}else if(row.step == '4'){
										return 	[  	'<i class="fa fa-exchange" data-toggle="tooltip" data-placement="right" title="SKP dalam pengajuan ralat"></i>'
												];
										}else if(row.step == '5'){
										return 	[  	'<i class="fa fa-pencil" data-toggle="tooltip" data-placement="right" title="SKP belum selesai"></i>'
												];
										}
									}
							},
							{ data: 'step' , orderable: false,searchable:false, width:"80px",
									"render": function ( data, type, row ) {
										return 	[  	 '<a href="#" class="btn btn-xs '+row.status_btn_hapus+' " data-toggle="tooltip" data-placement="top" title="Hapus" style="margin:1px;" ><i class="glyphicon glyphicon-trash"></i></a>'
													+'<a href="./skp-tahunan/'+row.skp_tahunan_id+'" class="btn btn-xs '+row.status_btn_lihat+'" data-toggle="tooltip" data-placement="top" title="Lihat" style="margin:1px;" ><i class="glyphicon glyphicon-eye-open"></i></a></span>' 
													+'<a href="./skp-tahunan/'+row.skp_tahunan_id+'/edit" class="btn btn-xs '+row.status_btn_edit+'" data-toggle="tooltip" data-placement="top" title="Edit" style="margin:1px;" ><i class="glyphicon glyphicon-pencil"></i></a></span>'
												];
									}
							}
						  ]
								
    
	} );


	
/*  ----------------------------------------------------------- **/
/** ##################   HAPUS SKP   ########################## **/
/*  ----------------------------------------------------------- **/
	$(document).on('click','.hapus',function(e){
        e.preventDefault();
		skp_id = $(this).val();
		
		swal({
			title: "Apakah anda yakin?",
			text: "SKP dan kegiatannya akan dihapus!",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Ya, hapus SKP!",
			closeOnConfirm: false
		}).then(function () {
			
			alert ("function on progress");
			
			/* $.ajax({
				type: 'POST',
				url:"./kelas/proses.php",
				data:{req:'delete_skp_tahunan',skp_id:skp_id},
				cache:false,
				success: function(e) {
						swal({
							title: "",
							text: "Sukses",
							type: "success",
							width: "200px",
							showConfirmButton: false,
							allowOutsideClick : false,
							timer: 1200
						}).then (function(){
							load_data_skp();	
									
								
							},// handling the promise rejection
							function (dismiss) {
								if (dismiss === 'timer') {
									load_data_skp();
								}
							}
						)
				}
			}) */
		
		});
		
		
	});



});
</script>
