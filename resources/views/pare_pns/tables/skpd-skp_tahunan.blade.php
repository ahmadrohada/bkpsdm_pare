<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            SKP Tahunan
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
	</div>
	<div class="row" style="padding:5px 30px; min-height:200px;">
		
		<span  data-toggle="tooltip" title="Create SKP Tahunan"><a class="btn btn-info btn-sm create_skp_tahunan"><i class="fa fa-plus" ></i> SKP Tahunan</a></span>
		
		<div class="box-body table-responsive ">
		
			<table id="rkpd_table" class="table table-striped table-hover table-condensed">
				<thead>
					<tr class="success">
						<th>NO</th>
						<th>PERIODE</th>
						<th>NIP</th>
						<th>NAMA</th>
						
						<th>JABATAN</th>
						<th>ESELON</th>
						<th>NAMA ATASAN</th>
						<th><i class="fa fa-cog" style="margin-left:12px !important;"></i></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

@include('pare_pns.modals.skpd_create_skp_tahunan')

<script type="text/javascript">

	$('#rkpd_table').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				autoWidth		: false,
				bInfo			: false,
				bSort			: true,
				lengthChange	: false,
				//order 			: [ 2 , 'desc' ],
				lengthMenu		: [10,25,50],
				columnDefs		: [
									{ 	className: "text-center", targets: [ 0,1,2,5,7 ] }/* ,
									//{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api/skpd_skp_tahunan_list") }}',
									data: { skpd_id : {{$skpd_id}} },
									delay:3000
								},
				

				columns	:[
								{ data: 'skp_tahunan_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								{ data: "periode" ,  name:"periode.label", orderable: true, searchable: true},
								{ data: "nip_pegawai" ,  name:"pejabat.nip", orderable: true, searchable: true},
								{ data: "nama_pegawai" ,  name:"skp_tahunan.u_nama", orderable: true, searchable: true},
								
								{ data: "jabatan" ,  name:"jabatan.skpd", orderable: true, searchable: true},
								{ data: "eselon" ,  name:"eselon.eselon", orderable: true, searchable: true,width:"40px"},
								{ data: "nama_atasan" ,  name:"skp_tahunan.p_nama", orderable: true, searchable: true},
								{ data: "status" , orderable: false,searchable:false,width:"65px",
										"render": function ( data, type, row ) {
											return  '<span  data-toggle="tooltip" title="Lihat" style="margin:1px;" ><a class="btn btn-info btn-xs lihat_skp_tahunan"  data-id="'+row.skp_tahunan_id+'"><i class="fa fa-eye" ></i></a></span>'+
													'<span  data-toggle="tooltip" title="cetak" style="margin:2px;" ><a class="btn btn-primary btn-xs cetak_skp_tahunan"  data-id="'+row.skp_tahunan_id+'"><i class="fa fa-print" ></i></a></span>';
									}
								}, 
								
							]
			
	});
	
	
	$(document).on('click','.lihat_skp_tahunan',function(e){
		var skp_tahunan_id = $(this).data('id') ;
		//alert(skp_tahunan_id);
		window.location.assign("skp_tahunan/"+skp_tahunan_id);
	});


	$(document).on('click','.create_skp_tahunan',function(e){
		//var skpd_id = {{ $skpd_id }};
		$('.modal-skpd_create_skp_tahunan').modal('show');
	});

	$(document).on('click','.cetak_skp_tahunan',function(e){
		var skp_tahunan_id = $(this).data('id') ;
		window.location.assign("skp-tahunan/"+skp_tahunan_id+"/cetak");
	});

</script>
