<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Data Capaian Bulanan SKPD
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
	</div>
	<div class="row" style="padding:5px 30px; min-height:200px;">
		<div class="box-body table-responsive">
			<table id="capaian_bulanan_skpd" class="table table-striped table-hover">
				<thead>
					<tr class="success">
						<th>NO</th>
						<th>PERIODE</th>
						<th>BULAN</th> 
						<th>NIP</th>
						<th>NAMA</th>
						<th>ESELON</th>
						<th>JABATAN</th>
						<th><i class="fa fa-cog"></i></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#capaian_bulanan_skpd').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				autoWidth		: false,
				bInfo			: false,
				bSort			: false,
				lengthChange	: false,
				//order 			: [ 0 , 'desc' ],
				lengthMenu		: [15,25,50],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,2,3,5,7] }
								],
				ajax			: {
									url	: '{{ url("api/skpd_capaian_bulanan_list") }}',
									data: { skpd_id : {{ $skpd_id }} },
									delay:3000

								},
				
				rowsGroup		: [1],
				columns			:[
								{ data: 'capaian_id',searchable:false,width:"25px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								{ data: "periode" ,searchable: true,width:"40px",
									"render": function ( data, type, row ) {
										if (row.capaian_status_approve == 2){
											return "<span class='text-danger'>"+row.periode+"</span>";
										}else{
											return row.periode;
										}

									}	
								},
								{ data: "bulan" ,  name:"skp_bulanan.bulan",searchable: true,width:"95px",
									"render": function ( data, type, row ) {
										if (row.capaian_status_approve == 2){
											return "<span class='text-danger'>"+row.bulan+"</span>";
										}else{
											return row.bulan;
										}

									}	
								},
								{ data: "nip_pegawai",name:"nip",searchable: true,
									"render": function ( data, type, row ) {
										if (row.capaian_status_approve == 2){
											return "<span class='text-danger'>"+row.nip_pegawai+"</span>";
										}else{
											return row.nip_pegawai;
										}

									}	
								},
								{ data: "nama_pegawai",searchable: true,width:"250px",
									"render": function ( data, type, row ) {
										if (row.capaian_status_approve == 2){
											return "<span class='text-danger'>"+row.nama_pegawai+"</span>";
										}else{
											return row.nama_pegawai;
										}

									}	
								},
								{ data: "eselon", name:"eselon" , searchable: true,width:"150px",
									"render": function ( data, type, row ) {
										if (row.capaian_status_approve == 2){
											return "<span class='text-danger'>"+row.eselon+"</span>";
										}else{
											return row.eselon;
										}

									}	
								},
								{ data: "jabatan" , name:"jabatan" ,searchable: true,
									"render": function ( data, type, row ) {
										if (row.capaian_status_approve == 2){
											return "<span class='text-danger'>"+row.jabatan+"</span>";
										}else{
											return row.jabatan;
										}

									}	
								},
								{ data: "status" , orderable: false,searchable:false,width:"50px",
										"render": function ( data, type, row ) {
											if ( row.capaian_send_to_atasan == '0'){
												return  '<span  data-toggle="tooltip" title="Ubah Status" style="margin:1px;" ><a class="btn btn-default btn-xs " ><i class="fa fa-backward" ></i></a></span>';
											}else{
												return  '<span  data-toggle="tooltip" title="Ubah Status" style="margin:1px;" ><a class="btn btn-success btn-xs ubah_status"  data-id="'+row.capaian_id+'"><i class="fa fa-backward" ></i></a></span>';
											}
											
									}
								}
								
							]
			
	});

	$(document).on('click','.ubah_status',function(e){
		var capaian_bulanan_id = $(this).data('id');
		Swal.fire({
				title: "Ubah Status Capaian",
				text: "Status Capaian akan kembali ke draft,  Diperlukan Proses kirim ke atan agar nilai Capaian bisa masuk ke TPP report",
				type: "warning",
				showCancelButton: true,
				cancelButtonText: "Batal",
				confirmButtonText: "Ubah",
				cancelButtonColor: "#7a7a7a",
				closeOnConfirm: false,
				showLoaderOnConfirm	: true,
		}).then ((result) => {
			if (result.value){
				$.ajax({
					url		: '{{ url("api/ubah_status_capaian_bulanan") }}',
					type	: 'POST',
					data    : { capaian_bulanan_id:capaian_bulanan_id},
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
										$('#capaian_bulanan_skpd').DataTable().ajax.reload(null, false);
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											
											
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
