<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            {!! Pustaka::capital_string($nama_skpd) !!}
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body table-responsive">

		<table id="pegawai_table" class="table table-striped table-hover table-condensed">
			<thead>
				<tr class="success">
				<th>NO</th>
					<th>NIP</th>
					<th>NAMA LENGKAP</th>
					<th>ESL</th>
					<th>GOL</th>
					<th>JABATAN</th>
					<th>UNIT KERJA</th>
					<th><i class="fa fa-get-pocket" style="margin-left:12px !important;"></i></th>
					<th><i class="fa fa-cog" style="margin-left:12px !important;"></i></th>
				</tr>
			</thead>
			
			
		</table>

	</div>
</div>



<script type="text/javascript">

		$('#pegawai_table').DataTable({
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				order 			: [ 3 , 'asc' ],
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,3,4,7,8] }/* ,
									{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api_resource/administrator_pegawai_skpd_list") }}',
									data: { skpd_id : {{$skpd_id}} },
									delay:3000
								},
				

				columns	:[
								{ data: 'pegawai_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "nip" ,  name:"pegawai.nip", orderable: true, searchable: false},
								{ data: "nama_pegawai", name:"pegawai.nama", orderable: true, searchable: true},
								{ data: "eselon" ,  name:"eselon.eselon", orderable: true, searchable: true},
								{ data: "golongan" ,  name:"golongan.golongan", orderable: true, searchable: true},
								{ data: "jabatan" ,  name:"jabatan.skpd", orderable: true, searchable: true},
								{ data: "nama_unit_kerja" , name:"unit_kerja.unit_kerja", orderable: true, searchable: true},
								{ data: "action" , orderable: false,searchable:false,width:"50px",
										"render": function ( data, type, row ) {
										if ( row.user == '1'){
											if ( row.role_admin == '1'){
												return  '<span  data-toggle="tooltip" title="Remove from Admin" style="margin:1px;" class="remove btn btn-xs btn-info" data-id="'+row.admin_role_user+'">Admin</span>';
											}else{
												return  '<span  data-toggle="tooltip" title="Add to Admin" style="margin:1px;" class="add btn btn-xs btn-default" data-id="'+row.user_id+'">Admin</span>';
												
											}
										}else{
											return  '<span style="margin:1px;" class="btn btn-xs btn-default" disabled>Admin</span>';
										}
									}
								},
								{ data: "action" , orderable: false,searchable:false,width:"50px",
										"render": function ( data, type, row ) {

										if ( row.user == '1'){
											return  '<span  data-toggle="tooltip" title="Lihat" style="margin:1px;" class=""><a href="../pegawai/'+row.pegawai_id+'" class="btn btn-xs btn-info"><i class="fa fa-eye"></i></a></span>';
										}else{
											return  '<span  data-toggle="tooltip" title="Tambah" style="margin:1px;" class=""><a href="../pegawai/'+row.pegawai_id+'/add" class="btn btn-xs btn-warning"><i class="fa fa-user-plus"></i></a></span>';
											
										}
									}
								},
								
							]
			
		});







		$(document).on('click','.add',function(e){
			var user_id = $(this).data('id') ;
			
			Swal.fire({
				title: "Jadikan Admin SKPD",
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
						url		: '{{ url("api_resource/add_admin_skpd") }}',
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
				title: "Hapus Admin SKPD",
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
						url		: '{{ url("api_resource/remove_admin_skpd") }}',
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
