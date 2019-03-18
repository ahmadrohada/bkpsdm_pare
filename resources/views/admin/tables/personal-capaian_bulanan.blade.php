<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Data SKP Bulanan
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body table-responsive">

		<table id="skp_bulanan_table" class="table table-striped table-hover table-condensed">
			<thead>
				<tr class="success">
					<th>NO</th>
					<th>PERIODE</th>
					<th>BULAN</th>
					<th>PELAKSANAAN</th>
					<th>JABATAN</th>
					<th>CAPAIAN</th>
				</tr>
			</thead>
			
			
		</table>

	</div>
</div>

@include('admin.modals.create_capaian_bulanan_confirm')

<script type="text/javascript">
	$('#skp_bulanan_table').DataTable({
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				order 			: [ 2 , 'desc' ],
				//dom 			: '<"toolbar">frtip',
				lengthMenu		: [50,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,2,3,5,] }/* ,
									//{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api_resource/personal_capaian_bulanan_list") }}',
									data: { pegawai_id : {!! $pegawai->id !!} },
									delay:3000

								},
				

				columns	:[
								{ data: 'skp_bulanan_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true},
								{ data: "bulan" ,  name:"bulan", orderable: true, searchable: true},
								{ data: "pelaksanaan" ,  name:"pelaksanaan", orderable: true, searchable: true,width:"250px"},
								{ data: "jabatan" ,  name:"jabatan", orderable: true, searchable: true},
								
								{ data: "capaian" , orderable: false,searchable:false,width:"120px",
										"render": function ( data, type, row ) {
										if (row.remaining_time >= 0 ){ 
											if (row.capaian >= 1 ){
												return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_capaian_bulanan"  data-id="'+row.capaian+'"><i class="fa fa-pencil" ></i></a></span>'+
														'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-default btn-xs lihat_capaian_bulanan"  data-id="'+row.capaian+'"><i class="fa fa-eye" ></i></a></span>'+
														'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_capaian_bulanan"  data-id="'+row.capaian+'" data-label="'+row.periode+' [ '+row.bulan+' ]"><i class="fa fa-close " ></i></a></span>';

											}else{
												return  '<span style="margin:1px;" ><a class="btn btn-warning btn-xs create_capaian_bulanan"  data-skp_bulanan_id="'+row.skp_bulanan_id+'" style="width:75px;">Capaian</a></span>';
											}


											
										}else{

											return row.remaining_time;
											
										
										}
									}
								},
								
							]
			
	});


	$(document).on('click','.edit_capaian_bulanan',function(e){
		var capaian_id = $(this).data('id') ;
		//alert(skp_tahunan_id);



		window.location.assign("capaian-bulanan/"+capaian_id+"/edit");
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
