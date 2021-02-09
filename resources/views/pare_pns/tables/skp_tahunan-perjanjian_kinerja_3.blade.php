<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header with-border text-center">
				<h1 class="box-title ">
				
				</h1>
				<div class="box-tools pull-right" style="padding-top:5px;">
					<form method="post" target="_blank" action="./cetak_perjanjian_kinerja-Eselon4">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="renja_id" value="{{ $skp->Renja->id }}">
						<input type="hidden" name="jabatan_id" value="{{$skp->PegawaiYangDinilai->Jabatan->id}}">
						<input type="hidden" name="skp_tahunan_id" value="{{$skp->id}}">
						<button type="submit" class="btn btn-info btn-xs"><i class="fa fa-print"></i> Cetak</button>
					</form>
				</div>
			</div>
			<div class="box-body table-responsive">
				
				<table id="perjanjian_kinerja_sasaran_table" class="table table-striped table-hover" >
					<thead>
						<tr class="success">
							<th class="no-sort"  style="padding-right:8px;">NO</th>
							<th >SASARAN STRATEGIS/SUB KEGIATAN</th>
							<th >INDIKATOR SUB KEGIATAN</th>
							<th >TARGET</th>
							<th><i class="fa fa-cog"></i></th>
						</tr>
					</thead>
					
				</table>
			</div>
		</div>
		
		
	</div> 
	<div class="col-md-6">

		<div class="box box-primary">
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
							<th >SUB KEGIATAN</th>
							<th >AGGARAN</th>
							{{-- <th><i class="fa fa-cog"></i></th> --}}
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
								{ className: "text-center", targets: [ 0,3 ] },
								@if (request()->segment(4) == 'edit')  
									{ visible: true, "targets": [4]},
								@else
									{ visible: false, "targets": [4]},
								@endif
							  ],
			ajax			: {
								url	: '{{ url("api/eselon4-pk_sasaran_strategis") }}',
								data: { "skp_tahunan_id" : {!! $skp->id !!} },
							 }, 
			columns			:[
							{ data: 'no' },
							{ data: "subkegiatan_label",orderable: false, searchable: false,
								"render": function ( data, type, row ) {
									if ( row.pk_status == 1 ){
										return  row.subkegiatan_label;
									}else{
										return  '<text class="blm_add">'+row.subkegiatan_label+'</text>';
									}		
								}
							},
							{ data:"indikator_subkegiatan_label", orderable: false, searchable: false,
								"render": function ( data, type, row ) {
									if ( row.pk_status == 1 ){
										return  row.indikator_subkegiatan_label;
									}else{
										return  '<text class="blm_add">'+row.indikator_subkegiatan_label+'</text>';
									}		
								}
							
							},
							{ data: "target", orderable: false, searchable: false , width:"80px",
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
											return  '<span  data-toggle="tooltip" title="Hapus Sub Kegiatan" style="margin:1px;" ><a class="btn btn-success btn-xs remove_esl4_pk_subkegiatan"  data-id="'+row.subkegiatan_id+'"><i class="fa fa-check" ></i></a></span>';
										}else{
											return  '<span  data-toggle="tooltip" title="Tambah Sub Kegiatan" style="margin:1px;" ><a class="btn btn-default btn-xs add_esl4_pk_subkegiatan"  data-id="'+row.subkegiatan_id+'"><i class="fa fa-minus" ></i></a></span>';
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
			deferRender		: true,
			searching      	: false,
			paging          : true,
			columnDefs		: [
									{ className: "text-center", targets: [ 0 ] },
									{ className: "text-right", targets: [ 2 ] },
									
								],
			ajax			: {
								url	: '{{ url("api/eselon4-pk_program") }}',
								data: { "skp_tahunan_id" : {!! $skp->id !!} },
							 }, 
			columns			:[
								{ data: 'subkegiatan_id' , orderable: false,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								{ data:"subkegiatan_label", orderable: false, searchable: false,
									"render": function ( data, type, row ) {
										if ( row.pk_status == 1 ){
											return  row.subkegiatan_label;
										}else{
											return  '<text class="blm_add">'+row.subkegiatan_label+'</text>';
										}		
									}
								},
								{ data:"subkegiatan_cost", orderable: false, searchable: false,
									"render": function ( data, type, row ) {
										if ( row.pk_status == 1 ){
											return  row.subkegiatan_cost;
										}else{
											return  '<text class="blm_add">'+row.subkegiatan_cost+'</text>';
										}		
									}
								},
							
						],
						initComplete: function(settings, json) {
							
							
   				 		}
		
		});	

		hitung_total_anggaran();

	}



	function hitung_total_anggaran(){
		$.ajax({
				url			: '{{ url("api/eselon4-total_anggaran_pk") }}',
				data		: { "skp_tahunan_id" : {!! $skp->id !!} },
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					
					$('.total_anggaran').html(data['total_anggaran']);
					
				},
				error: function(data){
					
				}						
		});
	}

	

	$(document).on('click','.remove_esl4_pk_subkegiatan',function(e){
		var subkegiatan_id = $(this).data('id') ;
		show_loader();
		$.ajax({
				url			: '{{ url("api/remove_esl4_subkegiatan_from_pk") }}',
				data 		: {subkegiatan_id : subkegiatan_id},
				method		: "POST",
				success		: function(data) {
					$('#perjanjian_kinerja_sasaran_table').DataTable().ajax.reload(null,false); 
					$('#perjanjian_kinerja_program_table').DataTable().ajax.reload(null,false); 
					hitung_total_anggaran();
					Swal.fire({
							title: "",
							text: "Berhasil Dihapus",
							type: "success",
							width: "200px",
							showConfirmButton: false,
							allowOutsideClick : false,
							timer: 1500
						}).then(function () {
							
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

	$(document).on('click','.add_esl4_pk_subkegiatan',function(e){
		var subkegiatan_id = $(this).data('id') ;
		show_loader();
		$.ajax({
				url			: '{{ url("api/add_esl4_subkegiatan_to_pk") }}',
				data 		: {subkegiatan_id : subkegiatan_id},
				method		: "POST",
				success		: function(data) {
					$('#perjanjian_kinerja_sasaran_table').DataTable().ajax.reload(null,false); 
					$('#perjanjian_kinerja_program_table').DataTable().ajax.reload(null,false); 
					hitung_total_anggaran();
					Swal.fire({
							title: "",
							text: "Berhasil ditambahkan",
							type: "success",
							width: "200px",
							showConfirmButton: false,
							allowOutsideClick : false,
							timer: 1500
						}).then(function () {
							
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
