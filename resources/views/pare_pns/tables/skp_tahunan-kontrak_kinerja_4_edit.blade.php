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
						<input type="hidden" name="jabatan_id" value="{{$skp->PejabatYangDinilai->Jabatan->id}}">
						<input type="hidden" name="skp_tahunan_id" value="{{$skp->id}}">
						<button type="submit" class="btn btn-info btn-xs"><i class="fa fa-print"></i> Cetak</button>
					</form>
				</div>
			</div>
			<div class="box-body table-responsive">
				
				<table id="kontrak_kinerja_kegiatan_table" class="table table-striped table-hover" >
					<thead>
						<tr class="success">
							<th class="no-sort"  style="padding-right:8px;">NO</th>
							<th >SASARAN STRATEGIS/PROGRAM</th>
							<th >INDIKATOR PROGRAM</th>
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
				<table id="kontrak_kinerja_program_table" class="table table-striped table-hover" >
					<thead>
						<tr class="success">
							<th class="no-sort" style="padding-right:8px;">NO</th>
							<th >KEGIATAN</th>
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


function load_kontrak_kinerja(){


    $('#kontrak_kinerja_kegiatan_table').DataTable({
				destroy			: true,
				//processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				bInfo			: false,
				bSort			: false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,3 ] }
							  ],
			ajax			: {
								url	: '{{ url("api_resource/jfu-kk_sasaran_strategis") }}',
								data: { 
										"renja_id" : {!! $skp->Renja->id !!} , 
										"jabatan_id" : {!! $skp->PejabatYangDinilai->Jabatan->id !!},
										"skp_tahunan_id" : {!! $skp->id !!}

								 	},
							 }, 
			columns			:[
							{ data: 'id' , orderable: false,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "kegiatan", name:"kegiatan_label", orderable: false, searchable: false,
								"render": function ( data, type, row ) {
									if ( row.pk_status == 1 ){
										return  row.kegiatan;
									}else{
										return  '<text class="blm_add">'+row.kegiatan+'</text>';
									}		
								}
							},
							{ data: "indikator", name:"indikator_kegiatan_label", orderable: false, searchable: false,
								"render": function ( data, type, row ) {
									if ( row.pk_status == 1 ){
										return  row.indikator;
									}else{
										return  '<text class="blm_add">'+row.indikator+'</text>';
									}		
								}
							
							},
							{ data: "target", name:"target", orderable: false, searchable: false , width:"80px",
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
											return  '<span  data-toggle="tooltip" title="Hapus Kegiatan" style="margin:1px;" ><a class="btn btn-success btn-xs remove_esl4_pk_kegiatan"  data-id="'+row.kegiatan_id+'"><i class="fa fa-check" ></i></a></span>';
										}else{
											return  '<span  data-toggle="tooltip" title="Tambah Kegiatan" style="margin:1px;" ><a class="btn btn-default btn-xs add_esl4_pk_kegiatan"  data-id="'+row.kegiatan_id+'"><i class="fa fa-minus" ></i></a></span>';
										}
										
											
									}
							},
							
						],
						initComplete: function(settings, json) {
							
   				 		}
		
		});	


		$('#kontrak_kinerja_program_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				bInfo			: false,
				bSort			: false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0 ] },
								{ className: "text-right", targets: [ 2 ] }
							  ],
			ajax			: {
								url	: '{{ url("api_resource/eselon4-pk_program") }}',
								data: { 
										"renja_id" : {!! $skp->Renja->id !!} , 
										"jabatan_id" : {!! $skp->PejabatYangDinilai->Jabatan->id !!},
										"skp_tahunan_id" : {!! $skp->id !!}

								 	},
							 }, 
			columns			:[
								{ data: 'kegiatan_id' , orderable: false,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								{ data: "kegiatan", name:"kegiatan_label", orderable: false, searchable: false,
									"render": function ( data, type, row ) {
										if ( row.pk_status == 1 ){
											return  row.kegiatan;
										}else{
											return  '<text class="blm_add">'+row.kegiatan+'</text>';
										}		
									}
								},
								{ data: "anggaran", name:"anggaran", orderable: false, searchable: false,
									"render": function ( data, type, row ) {
										if ( row.pk_status == 1 ){
											return  row.anggaran;
										}else{
											return  '<text class="blm_add">'+row.anggaran+'</text>';
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
				url			: '{{ url("api_resource/eselon4-total_anggaran_pk") }}',
				data		: { 
									"renja_id" : {!! $skp->Renja->id !!} , 
									"jabatan_id" : {!! $skp->PejabatYangDinilai->Jabatan->id !!},
									"skp_tahunan_id" : {!! $skp->id !!}
								},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
					
					$('.total_anggaran').html(data['total_anggaran']);
					
				},
				error: function(data){
					
				}						
		});
	}

	

	$(document).on('click','.remove_esl4_pk_kegiatan',function(e){
		var kegiatan_id = $(this).data('id') ;
		show_loader();
		$.ajax({
				url			: '{{ url("api_resource/remove_esl4_kegiatan_from_pk") }}',
				data 		: {kegiatan_id : kegiatan_id},
				method		: "POST",
				success		: function(data) {
					$('#kontrak_kinerja_kegiatan_table').DataTable().ajax.reload(null,false); 
					$('#kontrak_kinerja_program_table').DataTable().ajax.reload(null,false); 
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

	$(document).on('click','.add_esl4_pk_kegiatan',function(e){
		var kegiatan_id = $(this).data('id') ;
		show_loader();
		$.ajax({
				url			: '{{ url("api_resource/add_esl4_kegiatan_to_pk") }}',
				data 		: {kegiatan_id : kegiatan_id},
				method		: "POST",
				success		: function(data) {
					$('#kontrak_kinerja_kegiatan_table').DataTable().ajax.reload(null,false); 
					$('#kontrak_kinerja_program_table').DataTable().ajax.reload(null,false); 
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
