<div class="row">
	<div class="col-md-12">
		<div class="box box-primary">
			<div class="box-header with-border text-center">
				<h1 class="box-title ">
				
				</h1>
				<div class="box-tools pull-right" style="padding-top:5px;">
					<form method="post" target="_blank" action="./cetak_kontrak_kinerja-JFT">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="renja_id" value="{{ $skp->Renja->id }}">
						<input type="hidden" name="jabatan_id" value="{{$skp->PegawaiYangDinilai->Jabatan->id}}">
						<input type="hidden" name="skp_tahunan_id" value="{{$skp->id}}">
						<button type="submit" class="btn btn-info btn-xs"><i class="fa fa-print"></i> Cetak</button>
					</form>
				</div>
			</div>
			<div class="box-body table-responsive">
				
				<table id="kontrak_kinerja_jft_kegiatan_table" class="table table-striped table-hover" >
					<thead>
						<tr class="success">
							<th class="no-sort"  style="padding-right:8px;">NO</th>
							<th >KEGIATAN</th>
							<th >TARGET</th>
						</tr>
					</thead>
					
				</table>
			</div>
		</div>
		
		
	</div> 
	
</div>



<script type="text/javascript">


function load_kontrak_kinerja(){


    $('#kontrak_kinerja_jft_kegiatan_table').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : true,
				lengthChange	: false,
				lengthMenu		: [20],
				bInfo			: false,
				bSort			: false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0 ] }
							  ],
			ajax			: {
								url	: '{{ url("api_resource/jft-kk_sasaran_strategis") }}',
								data: { 
										"renja_id" 			: {!! $skp->Renja->id !!} , 
										"jabatan_id" 		: {!! $skp->PegawaiYangDinilai->Jabatan->id !!},
										"skp_tahunan_id" 	: {!! $skp->id !!}

								 	},
							 }, 
			columns			:[
							{ data: 'id' , orderable: false,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "kegiatan", name:"", orderable: false, searchable: false}, 
							{ data: "target", name:"", orderable: false, searchable: false , width:"230px"},
							
						],
						initComplete: function(settings, json) {
							
   				 		}
		
		});	


		

	}



</script>
