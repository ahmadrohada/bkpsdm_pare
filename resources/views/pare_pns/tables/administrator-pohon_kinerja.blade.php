<div class="box {{ $h_box }}">
    <div class="box-header with-border">
        <h1 class="box-title">
            Pohon Kinerja SKPD 
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
	</div>
	<div class="row" style="padding:5px 30px; min-height:200px;">
		<div class="box-body table-responsive">
			<table id="renja_table" class="table table-striped table-hover table-condensed">
				<thead>
					<tr class="success">
						<th>NO</th>
						<th>PERIODE</th>
						<th>NAMA SKPD</th>
						<th>KA SKPD</th>
						<th>JM TUJUAN</th>

						<th><i class="fa fa-cog" style="margin-left:12px !important;"></i></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>



<script type="text/javascript">
	
		$('#renja_table').DataTable({
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
									{ 	className: "text-center", targets: [ 0,1,4,5 ] }/* ,
									//{ 	className: "hidden-xs", targets: [ 5 ] } */
								],
				ajax			: {
									url	: '{{ url("api_resource/administrator_pohon_kinerja_list") }}',
									
									delay:3000
								},
				

				columns	:[
								{ data: 'periode_id' , orderable: true,searchable:false,
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								
								
								{ data: "periode" ,  name:"periode", orderable: true, searchable: false},
								{ data: "nama_skpd" ,  name:"skpd.skpd", orderable: true, searchable: true},
								{ data: "ka_skpd" ,  name:"ka_skpd", orderable: true, searchable: false},
								{ data: "jm_tujuan" ,  name:"jm_tujuan", orderable: true, searchable: false},
								{ data: "status" , orderable: false,searchable:false,
									"render": function ( data, type, row ) {
										return  '<span  data-toggle="tooltip" title="Lihat" style="margin:2px;" ><a class="btn btn-info btn-xs lihat_renja"  data-id="'+row.renja_id+'" ><i class="fa fa-eye" ></i></a></span>'
									}
								},
								
							]
			
		});
	
	

	
	$(document).on('click','.lihat_renja',function(e){
		var renja_id = $(this).data('id') ;
		
		window.location.assign("pohon_kinerja/"+renja_id);
	});

</script>
