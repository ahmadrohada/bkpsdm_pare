<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
           History Jabatan
        </h1> 

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
	</div> 
	<div class="row" style="padding:5px 30px; min-height:200px;">
		<div class="box-body table-responsive">
			<table id="skp_tahunan_table" class="table table-striped table-hover">
				<thead>
					<tr class="success">
						<th>NO</th>
						<th>PERIODE</th>
						<th>TMT</th>
						<th>JABATAN</th>
						<th>SKPD</th>
						<th>POHON KINERJA</th>

						<th>SKP TAHUNAN</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

@include('pare_pns.modals.create_skp_tahunan_confirm')

@include('pare_pns.modals.skp_tahunan_bawahan')

<script type="text/javascript">
	$('#skp_tahunan_table').DataTable({
					destroy			: true,
					processing      : true,
					serverSide      : true,
					searching      	: false,
					paging          : true,
					autoWidth		: false,
					bInfo			: false,
					bSort			: true,
					lengthChange	: false,
					order 			: [ 0 , 'desc' ],
					lengthMenu		: [10,25,50],

				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,2,5,6 ] }
								  ],
				ajax			: {
									url	: '{{ url("api_resource/personal_skp_jabatan_list") }}',
									data: { pegawai_id : {!! $pegawai->id !!} },
									delay:3000

								},
				//rowsGroup		: [4],
				columns			:[
								{ data: 'id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								{ data: "periode" ,  name:"periode", orderable: true, searchable: true,
									"render": function ( data, type, row ) {
										if ( row.jabatan_status == 'active' ){
											return  '<p class="text-success">'+row.periode+'</p>';
										}else{
											return  row.periode;
										}
									}
								},
								{ data: "tmt_jabatan" ,  name:"tmt_jabatan", orderable: true, searchable: true,
									"render": function ( data, type, row ) {
										if ( row.jabatan_status == 'active' ){
											return  '<p class="text-success">'+row.tmt_jabatan+'</p>';
										}else{
											return  row.tmt_jabatan;
										}
									}
								},
								{ data: "jabatan" ,  name:"jabatan", orderable: true, searchable: true,
									"render": function ( data, type, row ) {
										if ( ( row.jabatan_status == 'active') & ( row.tahun_now == 1 ) ){
											return  '<span class="btn btn-sm label-success">'+row.jabatan+'</span>';
										}else{
											return  row.jabatan;
										}
									}
								
								},
								{ data: "skpd" ,  name:"skpd", orderable: true, searchable: true},
								{ data: "renja" , orderable: false,searchable:false,width:"40px",
										"render": function ( data, type, row ) {
										if (row.renja == true ){
											return  '<span class="label label-success"><i class="fa fa-check"></i></span>';
										}else{
											return  '<span class="label label-default"><i class="fa fa-close"></i></span>';
											
										}
										
									}
								},
								{ data: "skp_tahunan" , orderable: false,searchable:false,width:"120px",
										"render": function ( data, type, row ) {
										if ( ( row.skp_tahunan == 0 ) & (row.jabatan_status == 'active') ){ 
											return  '<span  data-toggle="tooltip" title="Create SKP Tahunan" style="margin:1px;" ><a class="btn btn-warning btn-xs create_skp_tahunan"  data-jabatan_id="'+row.jabatan_id+'" data-periode_id="'+row.periode_id+'" data-pegawai_id="'+row.pegawai_id+'">Create SKP</a></span>';
										}else if (row.skp_tahunan == 1 ){
											return  '<span class="btn btn-success btn-xs" style="width:68px; cursor:default;"><i class="fa fa-check"></i></i></span>';

										
										}else if (row.skp_tahunan == 2 ){
											return  '<span class="btn btn-default btn-xs" disabled>Create SKP</i></span>';
										}else{
											return  '<span class="btn btn-default btn-xs" disabled>Create SKP</i></span>';
										}
									}
								},
								
							]
			
	});


	

	$(document).on('click','.edit_skp_tahunan',function(e){
		var skp_tahunan_id = $(this).data('id') ;
		//alert(skp_tahunan_id);



		window.location.assign("skp_tahunan/"+skp_tahunan_id+"/edit");
	});

	$(document).on('click','.lihat_skp_tahunan',function(e){
		var skp_tahunan_id = $(this).data('id') ;
		//alert(skp_tahunan_id);



		window.location.assign("skp_tahunan/"+skp_tahunan_id);
	});

	$(document).on('click','.hapus_skp_tahunan',function(e){
		var skp_tahunan_id = $(this).data('id') ;
		//alert(kegiatan_tahunan_id);

		Swal.fire({
			title: "Hapus  SKP Tahunan",
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
					url		: '{{ url("api_resource/hapus_skp_tahunan") }}',
					type	: 'POST',
					data    : {skp_tahunan_id:skp_tahunan_id},
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
										$('#skp_tahunan_table').DataTable().ajax.reload(null,false);
										
									},
									function (dismiss) {
										if (dismiss === 'timer') {
											$('#skp_tahunan_table').DataTable().ajax.reload(null,false);
											
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
