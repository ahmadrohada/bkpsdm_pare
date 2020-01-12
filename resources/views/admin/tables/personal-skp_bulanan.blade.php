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
					<th>MASA PENILAIAN</th>
					<th>JABATAN</th>
					<th>SKPD</th>
					<th><i class="fa fa-cog"></i></th>
				</tr>
			</thead>
			
			
		</table>

	</div>
</div>


<script type="text/javascript">
	$('#skp_bulanan_table').DataTable({
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				lengthMenu		: [12,100],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,2,5 ] }/* ,
									//{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api_resource/personal_skp_bulanan_list") }}',
									data: { pegawai_id : {!! $pegawai->id !!} },
									delay:3000

								},
				

				columns	:[
								{ data: 'id' , orderable: false,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "periode" ,  name:"periode", orderable: false, searchable: true},
								{ data: "masa_penilaian" ,  name:"masa_penilaian", orderable: false, searchable: true},
								{ data: "jabatan" ,  name:"jabatan", orderable: true, searchable: true},
								{ data: "skpd" ,  name:"skpd", orderable: true, searchable: true},
								{ data: "skp_bulanan" , orderable: false,searchable:false,width:"100px",
										"render": function ( data, type, row ) {
										

										if ( row.status == 0 ){
											return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs" disabled><i class="fa fa-eye" ></i></a></span>'
													
													+'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_skp_bulanan"  data-id="'+row.skp_bulanan_id+'" data-periode="'+row.periode+'" ><i class="fa fa-close " ></i></a></span>';
										
										}else{
											return  '<span  data-toggle="tooltip" title="Lihat" style="margin:1px;" ><a class="btn btn-info btn-xs lihat_skp_bulanan"  data-id="'+row.skp_bulanan_id+'"><i class="fa fa-eye" ></i></a></span>'
													
													+'<span style="margin:1px;" ><a class="btn btn-default btn-xs " disabled><i class="fa fa-close " ></i></a></span>';
										
										}
										
										
									}
								},
								
							]
			
	});


	

	$(document).on('click','.edit_skp_bulanan',function(e){
		var skp_bulanan_id = $(this).data('id') ;
		//alert(skp_bulanan_id);



		window.location.assign("skp_bulanan/"+skp_bulanan_id+"/edit");
	});

	$(document).on('click','.lihat_skp_bulanan',function(e){
		var skp_bulanan_id = $(this).data('id') ;
		//alert(skp_bulanan_id);



		window.location.assign("skp_bulanan/"+skp_bulanan_id);
	});

	$(document).on('click','.hapus_skp_bulanan',function(e){
		var skp_bulanan_id = $(this).data('id') ;
		//alert(skp_bulanan_id);

		Swal.fire({
			title: "Hapus  SKP Bulanan",
			text:$(this).data('periode'),
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
					url		: '{{ url("api_resource/hapus_skp_bulanan") }}',
					type	: 'POST',
					data    : {skp_bulanan_id:skp_bulanan_id},
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
