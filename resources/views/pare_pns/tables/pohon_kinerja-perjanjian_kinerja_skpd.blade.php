<style>
	
	.no-sort::after { display: none!important; }
	.no-sort { pointer-events: none!important; cursor: default!important; }

</style>

<div class="row">
	<div class="col-md-6">
		<div class="box box-success">
			<div class="box-header with-border text-center">
				<h1 class="box-title ">
				
				</h1>
				<div class="box-tools pull-right">
					<form method="post" target="_blank" action="./cetak_perjanjian_kinerja">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="renja_id" value="{{ $renja->id }}">
						<button type="submit" class="btn btn-info btn-sm"><i class="fa fa-print"></i> Cetak</button>
					</form> 
					
				</div>
			</div>
			<div class="box-body table-responsive">
				<div class="box-tools pull-right"></div>
				<table id="perjanjian_kinerja_sasaran_table" class="table table-striped table-hover" >
					<thead>
						<tr class="success">
							<th class="no-sort"  style="padding-right:8px;">NO</th>
							<th >SASARAN STRATEGIS/SASARAN</th>
							<th >INDIKATOR KINERJA</th>
							<th >TARGET</th>
							<th><i class="fa fa-cog"></i></th>
						</tr>
					</thead>
					
				</table>
			</div>
		</div>
		
		
	</div> 
	<div class="col-md-6">

		<div class="box box-success">
			<div class="box-header with-border text-center">
				<h1 class="box-title ">
				
				</h1>
				<div class="box-tools pull-right">
					{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
				</div>
			</div>
			<div class="box-body table-responsive">
				<table id="perjanjian_kinerja_program_table" class="table table-striped table-hover" >
					<thead>
						<tr class="success">
							<th class="no-sort" style="padding-right:8px;">NO</th>
							<th >PROGRAM / KEGIATAN</th>
							<th >AGGARAN</th>
							<th >KETERANGAN</th>
						</tr>
					</thead>
					
				</table>
				
				<ul class="list-group list-group-unbordered" style="margin-top:5px;">
					<li class="list-group-item">
						<b>TOTAL ANGGARAN <span class="pull-right total_anggaran">Rp. </span></b>
					</li>
				</ul>
				
			</div>
			
		</div>		
		
	</div> 
</div>




<script type="text/javascript">


function load_perjanjian_kinerja(){

    $('#perjanjian_kinerja_sasaran_table').DataTable({
			destroy			: true,
			processing      : false,
			serverSide      : true,
			autoWidth		: false,
			bInfo			: false,
			bSort			: false, 
			lengthChange	: false,
			deferRender		: true,
			searching      	: false,
			paging          : true,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,3,4 ] }
							  ],
			ajax			: {
								url	: '{{ url("api/skpd-pk_sasaran_strategis") }}', 
								data: { renja_id: {!! $renja->id !!} },
							 }, 
			rowsGroup		: [0,1,4],
			columns			:[
							{ data: 'no' },
							{ data: "sasaran_label", name:"sasaran_label", orderable: false, searchable: false,
								"render": function ( data, type, row ) {
									if ( row.pk_status == 1 ){
										return  row.sasaran_label;
									}else{
										return  '<text class="blm_add">'+row.sasaran_label+'</text>';
									}		
								}
							},
							{ data: "ind_sasaran_label", name:"ind_sasaran_label", orderable: false, searchable: false,
								"render": function ( data, type, row ) {
									if ( row.pk_status == 1 ){
										return  row.ind_sasaran_label;
									}else{
										return  '<text class="blm_add">'+row.ind_sasaran_label+'</text>';
									}		
								}
							},
							{ data: "target", name:"target", orderable: false, searchable: false , width:"90px",
								"render": function ( data, type, row ) {
									if ( row.pk_status == 1 ){
										return  row.target;
									}else{
										return  '<text class="blm_add">'+row.target+'</text>';
									}		
								}
							},
							{  data: 'action',width:"30px",orderable: false,
								"render": function ( data, type, row ) {
									if ( row.pk_status == 1 ){
										return  '<span  data-toggle="tooltip" title="Remove Sasaran" style="margin:1px;" ><a class="btn btn-warning btn-xs remove_sasaran"  data-id="'+row.sasaran_id+'"><i class="fa fa-remove" ></i></a></span>';
									}else{
										return  '<span  data-toggle="tooltip" title="Add Sasaran" style="margin:1px;" ><a class="btn btn-success btn-xs add_sasaran"  data-id="'+row.sasaran_id+'"><i class="fa fa-plus" ></i></a></span>';
									}
									
										
								}
						},
							
							
						],
						initComplete: function(settings, json) {
							
   				 		}
		
		});	

		$('#perjanjian_kinerja_program_table').DataTable({
			destroy			: true,
			processing      : false,
			serverSide      : true,
			autoWidth		: false,
			bInfo			: false,
			bSort			: false, 
			lengthChange	: false,
			searching      	: false,
			paging          : true,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,3 ] },
								{ className: "text-right", targets: [ 2 ] }
							  ],
			ajax			: {
								url	: '{{ url("api/skpd-pk_program") }}',
								data: { renja_id: {!! $renja->id !!} },
							 }, 
			rowsGroup		: [0,1],
			columns			:[
								{ data: 'no' },
								{ data: "program_label", name:"program_label", orderable: false, searchable: false},
								{ data: "anggaran", name:"anggaran", orderable: false, searchable: false,width:"140px"},
								{ data: "keterangan", name:"keterangan", orderable: false, searchable: false , width:"90px"},
								
								
							],
							initComplete: function(settings, json) {
								
								
							}
		
		});	

		hitung_total_anggaran();

	}



	function hitung_total_anggaran(){
		$.ajax({
				url			: '{{ url("api/skpd-total_anggaran_pk") }}',
				data 		: { renja_id: {!! $renja->id !!} },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					
					$('.total_anggaran').html(data['total_anggaran']);
					
				},
				error: function(data){
					
				}						
		});
	}


	$(document).on('click','.add_sasaran',function(e){
		var sasaran_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api/add_sasaran_to_pk") }}',
				data 		: {sasaran_id : sasaran_id},
				method		: "POST",
				success		: function(data) {
					Swal.fire({
							title: "",
							text: "Berhasil ditambahkan",
							type: "success",
							width: "200px",
							showConfirmButton: false,
							allowOutsideClick : false,
							timer: 1500
						}).then(function () {
							$('#perjanjian_kinerja_program_table').DataTable().ajax.reload(null,false); 
							$('#perjanjian_kinerja_sasaran_table').DataTable().ajax.reload(null,false);
							hitung_total_anggaran();
						},
						function (dismiss) {
							if (dismiss === 'timer') {
								//table.ajax.reload(null,false);
							}
					})


				},
				error: function(data){
					Swal.fire({
			        		title: "Error",
			        		text: "",
			        		type: "error"
			        	}).then (function(){
			        		
			        	});
				}						
		});	
	});

	$(document).on('click','.remove_sasaran',function(e){
		var sasaran_id = $(this).data('id') ;
		$.ajax({
				url			: '{{ url("api/remove_sasaran_from_pk") }}',
				data 		: {sasaran_id : sasaran_id},
				method		: "POST",
				success		: function(data) {
					Swal.fire({
							title: "",
							text: "Berhasil dihapus",
							type: "success",
							width: "200px",
							showConfirmButton: false,
							allowOutsideClick : false,
							timer: 1500
						}).then(function () {
                           	
							$('#perjanjian_kinerja_program_table').DataTable().ajax.reload(null,false); 
							$('#perjanjian_kinerja_sasaran_table').DataTable().ajax.reload(null,false);
							hitung_total_anggaran();
						},
						function (dismiss) {
							if (dismiss === 'timer') {
								//table.ajax.reload(null,false);
							}
					})


				},
				error: function(data){
					Swal.fire({
			        		title: "Error",
			        		text: "",
			        		type: "error"
			        	}).then (function(){
			        		
			        	});
				}						
		});	
	});
</script>
