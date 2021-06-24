<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Capaian Tahunan SKPD
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
	</div>
	<div class="row" style="padding:5px 30px; min-height:200px;">
		
			
		<div class="box-body table-responsive ">
		
			<table id="capaian_tahunan" class="table table-striped table-hover table-condensed">
				<thead>
					<tr class="success">
						<th>NO</th>
						<th>PERIODE</th>
						<th>NIP</th>
						<th>NAMA</th>
						
						<th>JABATAN</th>
						<th>ESELON</th>
						<th><i class="fa fa-cog" style="margin-left:12px !important;"></i></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

@include('pare_pns.modals.skpd_create_skp_tahunan')

<script type="text/javascript">

	$('#capaian_tahunan').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				autoWidth		: false,
				bInfo			: false,
				bSort			: true,
				lengthChange	: false,
				order 			: [ 0 , 'desc' ],
				lengthMenu		: [10,25,50],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,2,5,6 ] }/* ,
									//{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api/skpd_capaian_tahunan_list") }}',
									data: { skpd_id : {{$skpd_id}} },
									delay:3000
								},
				

				columns	:[
								{ data: 'capaian_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "periode" ,  name:"periode.label", orderable: true, searchable: true},
								{ data: "nip_pegawai" ,  name:"pejabat.nip", orderable: true, searchable: true},
								{ data: "nama_pegawai" ,  name:"skp_tahunan.u_nama", orderable: true, searchable: true},
								
								{ data: "jabatan" ,  name:"jabatan.skpd", orderable: true, searchable: true},
								{ data: "eselon" ,  name:"eselon.eselon", orderable: true, searchable: true,width:"120px"},
								{ data: "status" , orderable: false,searchable:false,width:"80px",
										"render": function ( data, type, row ) {
											if (row.capaian_send_to_atasan == 1 ){
													if (row.capaian_status_approve == 2){
														//ditolak
														return  '<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_capaian_tahunan"  data-id="'+row.capaian_id+'"><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="cetak" style="margin:2px;" ><a class="btn btn-primary btn-xs cetak_capaian_tahunan"  data-id="'+row.capaian_id+'"><i class="fa fa-print" ></i></a></span>';
													}else{
														//diterima
														return  '<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_capaian_tahunan"  data-id="'+row.capaian_id+'"><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="cetak" style="margin:2px;" ><a class="btn btn-primary btn-xs cetak_capaian_tahunan"  data-id="'+row.capaian_id+'"><i class="fa fa-print" ></i></a></span>';
													}
												}else{
													//blm dikirim
													return  	'<span  data-toggle="tooltip" title="lihat" style="margin:2px;" ><a class="btn btn-default btn-xs "><i class="fa fa-eye" ></i></a></span>'+
																'<span  data-toggle="tooltip" title="cetak" style="margin:2px;" ><a class="btn btn-default btn-xs "  data-id="'+row.capaian_id+'"><i class="fa fa-print" ></i></a></span>';
												}
									}
								},
								
							]
			
	});
	
	
	$(document).on('click','.lihat_capaian_tahunan',function(e){
		var capaian_id = $(this).data('id') ;
		window.location.assign("capaian-tahunan/"+capaian_id);
	});

	$(document).on('click','.cetak_capaian_tahunan',function(e){
		var capaian_id = $(this).data('id') ;
		window.location.assign("capaian-tahunan/"+capaian_id+"/cetak");
	});


</script>
