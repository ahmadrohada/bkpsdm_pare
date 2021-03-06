<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border text-center">
				<h1 class="box-title ">
				
				</h1>
				<div class="box-tools pull-right" style="padding-top:5px;">

					@if ( ( request()->segment(4) != 'edit' ) & ( request()->segment(4) != 'ralat' ) )
						<?php $action = "{{$skp->id}}/cetak_kontrak_kinerja-JFU" ; ?>
					@else
						<?php $action = "./cetak_kontrak_kinerja-JFU" ; ?>
					@endif

					<form method="post" target="_blank" action="{{$action}}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="renja_id" value="{{ $skp->Renja->id }}">
						<input type="hidden" name="jabatan_id" value="{{$skp->PegawaiYangDinilai->Jabatan->id}}">
						<input type="hidden" name="skp_tahunan_id" value="{{$skp->id}}">
						<button type="submit" class="btn btn-info btn-xs"><i class="fa fa-print"></i> Cetak</button>
					</form>
				</div>
			</div>
			<div class="box-body table-responsive">
				
				<table id="kontrak_kinerja_kegiatan_jfu_table" class="table table-striped table-hover" >
					<thead>
						<tr class="success">
							<th class="no-sort"  style="padding-right:8px;">NO</th>
							<th >KEGIATAN</th>
							<th >RENCANA AKSI</th></th>
							<th >TARGET</th>
						</tr>
					</thead>
					
				</table>
			</div>
		</div>
		
		
	</div> 
	{{-- <div class="col-md-6">

		<div class="box box-primary">
			<div class="box-header with-border text-center">
				<h1 class="box-title ">
				
				</h1>
				<div class="box-tools pull-right">
					{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
				</div>
			</div>
			<div class="box-body table-responsive">
				<table id="kk_angaran_kegiatan_jfu_table" class="table table-striped table-hover" >
					<thead>
						<tr class="success">
							<th class="no-sort" style="padding-right:8px;">NO</th>
							<th >KEGIATAN</th>
							<th >AGGARAN</th>
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
		
	</div>  --}}
</div>



<script type="text/javascript">


function load_kontrak_kinerja(){


    $('#kontrak_kinerja_kegiatan_jfu_table').DataTable({
				destroy			: true,
				//processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				bInfo			: false,
				bSort			: false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0 ] },
								/* { "visible": false, targets: [ 0 ] } */
							  ],
			ajax			: {
								url	: '{{ url("api/jfu-kk_sasaran_strategis") }}',
								data: { 
										"renja_id" : {!! $skp->Renja->id !!} , 
										"jabatan_id" : {!! $skp->PegawaiYangDinilai->Jabatan->id !!},
										"skp_tahunan_id" : {!! $skp->id !!}

								 	},
							 }, 
			rowsGroup		: [0,1],
			columns			:[
							{ data: 'no' , orderable: false,searchable:false,width:"30px"},
							{ data: "kegiatan_label", name:"kegiatan_label", orderable: false, searchable: false}, 
							{ data: "rencana_aksi_label", name:"rencana_aksi_label", orderable: false, searchable: false},
							{ data: "target", name:"target", orderable: false, searchable: false , width:"80px"},
						
							
						],
						initComplete: function(settings, json) {
							
   				 		}
		
		});	


		/* $('#kk_angaran_kegiatan_jfu_table').DataTable({
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
								url	: '{{ url("api/jfu-kk_anggaran_kegiatan") }}',
								data: { 
										"renja_id" : {!! $skp->Renja->id !!} , 
										"jabatan_id" : {!! $skp->PegawaiYangDinilai->Jabatan->id !!},
										"skp_tahunan_id" : {!! $skp->id !!}

								 	},
							 }, 
			columns			:[
								{ data: 'kegiatan_id' , orderable: false,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
								{ data: "kegiatan_label", name:"kegiatan_label", orderable: false, searchable: false,
									"render": function ( data, type, row ) {
										if ( row.kk_status == 1 ){
											return  row.kegiatan_label;
										}else{
											return  '<text class="blm_add">'+row.kegiatan_label+'</text>';
										}		
									}
								},
								{ data: "anggaran", name:"anggaran", orderable: false, searchable: false,
									"render": function ( data, type, row ) {
										if ( row.kk_status == 1 ){
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
		*/
	}


	/*
	function hitung_total_anggaran(){
		$.ajax({
				url			: '{{ url("api/jfu-total_anggaran_kk") }}',
				data		: { 
									"renja_id" : {!! $skp->Renja->id !!} , 
									"jabatan_id" : {!! $skp->PegawaiYangDinilai->Jabatan->id !!},
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
	} */

	


</script>
