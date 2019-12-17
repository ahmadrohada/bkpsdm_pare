

<div class="box box-success">
    <div class="box-header with-border text-center">
		<h1 class="box-title ">
			PERJANJIAN KINERJA PERUBAHAN TAHUN 2018<br>
			{{ $renja->SKPD->skpd }}<br>
			KEPALA {{ $renja->SKPD->skpd }}
        </h1>
    </div>
	<div class="box-body table-responsive">

		<div class="toolbar">
			
		</div>
		<table id="perjanjian_kinerja_sasaran_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th >NO</th>
					<th >SASARAN STRATEGIS/SASARAN</th>
					<th >INDIKATOR KINERJA</th>
					<th >TARGET</th>
				</tr>
			</thead>
			
		</table>

		<br>

		<table id="perjanjian_kinerja_program_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th >NO</th>
					<th >PROGRAM / KEGIATAN</th>
					<th >AGGARAN</th>
					<th >KETERANGAN</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>


<script type="text/javascript">


function load_perjanjian_kinerja(){


    $('#perjanjian_kinerja_sasaran_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,3 ] }
							  ],
			ajax			: {
								url	: '{{ url("api_resource/skpd-pk_sasaran_list") }}',
								data: { renja_id: {!! $renja->id !!} },
							 }, 
			columns			:[
							{ data: 'id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "sasaran", name:"sasaran_label", orderable: true, searchable: true},
							{ data: "indikator", name:"ind_sasaran_label", orderable: true, searchable: true },
							{ data: "target", name:"target", orderable: true, searchable: true , width:"90px"},
							
							
						],
						initComplete: function(settings, json) {
							
   				 		}
		
		});	


		$('#perjanjian_kinerja_program_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,3 ] },
								{ className: "text-right", targets: [ 2 ] }
							  ],
			ajax			: {
								url	: '{{ url("api_resource/skpd-pk_program_list") }}',
								data: { renja_id: {!! $renja->id !!} },
							 }, 
			columns			:[
							{ data: 'id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "program", name:"program_label", orderable: true, searchable: true},
							{ data: "anggaran", name:"anggaran", orderable: true, searchable: true,width:"160px"},
							{ data: "keterangan", name:"keterangan", orderable: true, searchable: true , width:"250px"},
							
							
						],
						initComplete: function(settings, json) {
							
   				 		}
		
		});	

	}

</script>
