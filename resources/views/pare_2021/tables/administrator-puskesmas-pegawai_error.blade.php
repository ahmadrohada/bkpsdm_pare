<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            {!! Pustaka::capital_string($nama_puskesmas) !!}
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
	</div>
	<div class="row" style="padding:5px 30px; min-height:200px;">
		<div class="box-body table-responsive">
			<table id="pegawai_table" class="table table-striped table-hover table-condensed">
				<thead>
					<tr class="success">
						<th rowspan="2">NO</th>
						<th colspan="4">DATA DARI ADMIN</th>
						<th colspan="4">DATA HISTORY JABATAN</th>
						<th colspan="3">DATA TPP REPORT</th>
						{{-- <th><i class="fa fa-cog" style="margin-left:12px !important;"></i></th> --}}
					</tr>
					<tr class="success">
						<th>NIP</th>
						<th>NAMA</th>
						<th>GOL</th>
						<th>JABATAN</th>

						<th>JABATAN</th>
						<th>UNIT KERJA ID</th>
						<th>M_SKPD ID</th>
						<th>M_SKPD UK ID</th>
						
						<th>UNIT KERJA ID</th>
						<th>CAP</th>
						<th>ID</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>



<script type="text/javascript">

		$('#pegawai_table').DataTable({
			destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				autoWidth		: false,
				bInfo			: false,
				bSort			: true,
				lengthChange	: false,
				order 			: [ 0 , 'asc' ],
				lengthMenu		: [50],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,3,6,7,8,9,10,11] },
								],
				ajax			: {
									url	: '{{ url("api_resource/administrator_pegawai_puskesmas_list_error") }}',
									data: { puskesmas_id : {{$puskesmas_id}} },
									//delay:3000
								},
				

				columns	:[
								{ data: 'pp_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "pp_nip" ,  name:"pegawai_puskesmas.nip"},
								{ data: "pp_nama", name:"pegawai_puskesmas.nama"},
								{ data: "pp_gol" ,  name:"pegawai_puskesmas.gol"},
								{ data: "pp_jabatan" ,  name:"pegawai_puskesmas.jabatan"},

								{ data: "hijab_jabatan" ,  name:"jabatan.skpd"},
								{ data: "hijab_unit_kerja_id", name:"hijab.unit_kerja_id"},
								{ data: "hijab_jabatan_id", name:"hijab.id_jabatan"},
								{ data: "m_skpd_id_uk" ,  name:"jabatan.id_unit_kerja"},
			
								{ data: "tpp_unit_kerja_id" , name:"tpp.unit_kerja_id"},
								{ data: "tpp_capaian" , name:"tpp.cap_skp"},
								{ data: "tpp_id" , name:"tpp.id"},
								/* 
								{ data: "action" , orderable: false,searchable:false,width:"50px",
										"render": function ( data, type, row ) {

										if ( row.user == '1'){
											return  '<span  data-toggle="tooltip" title="Lihat" style="margin:1px;" class=""><a href="../pegawai/'+row.pegawai_id+'" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a></span>';
										}else{
											return  '<span  data-toggle="tooltip" title="Tambah" style="margin:1px;" class=""><a href="../pegawai/'+row.pegawai_id+'/add" class="btn btn-xs btn-warning"><i class="fa fa-user-plus"></i></a></span>';
											
										}
									}
								}, */
								
							]
			
		});







		$(document).on('click','.add',function(e){
			var user_id = $(this).data('id') ;
			
			Swal.fire({
				title: "Jadikan Admin Puskesmas",
				type: "question",
				//type: "question",
				showCancelButton: true,
				cancelButtonText: "Batal",
				confirmButtonText: "Setuju",
				confirmButtonClass: "btn btn-success",
				cancelButtonColor: "btn btn-danger",
				cancelButtonColor: "#d33",
				closeOnConfirm: false,
				closeOnCancel:false
			}).then ((result) => {
				if (result.value){
					$.ajax({
						url		: '{{ url("api_resource/add_admin_puskesmas") }}',
						type	: 'POST',
						data    : {user_id:user_id},
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
											$('#pegawai_table').DataTable().ajax.reload(null,false);

										},
										function (dismiss) {
											if (dismiss === 'timer') {
												$('#pegawai_table').DataTable().ajax.reload(null,false);
												
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


		$(document).on('click','.remove',function(e){
			var user_role_id = $(this).data('id') ;
			
			Swal.fire({
				title: "Hapus Admin Puskesmas",
				type: "warning",
				//type: "question",
				showCancelButton: true,
				cancelButtonText: "Batal",
				confirmButtonText: "Setuju",
				confirmButtonClass: "btn btn-success",
				cancelButtonColor: "btn btn-danger",
				cancelButtonColor: "#d33",
				closeOnConfirm: false,
				closeOnCancel:false
			}).then ((result) => {
				if (result.value){
					$.ajax({
						url		: '{{ url("api_resource/remove_admin_puskesmas") }}',
						type	: 'POST',
						data    : {user_role_id:user_role_id},
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
											$('#pegawai_table').DataTable().ajax.reload(null,false);

										},
										function (dismiss) {
											if (dismiss === 'timer') {
												$('#pegawai_table').DataTable().ajax.reload(null,false);
												
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
