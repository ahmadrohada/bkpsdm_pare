<style>
	td.dt-nowrap { white-space: nowrap }
	.no-sort::after { display: none!important; }
	.no-sort { pointer-events: none!important; cursor: default!important; }
	table{
	  margin: 0 auto;
	 
	  clear: both;
	  border-collapse: collapse;
	  table-layout: fixed; // ***********add this
	  word-wrap:break-word; // ***********and this
	  white-space: nowrap;
	  text-overflow: ellipsis;
	  overflow: hidden;
	}
	
</style>

<div class="box box-success">
    <div class="box-header with-border text-center">
		<h1 class="box-title ">
			PERJANJIAN KINERJA PERUBAHAN TAHUN 2018<br>
			PERANGKAT DAERAH DINAS PEMBERDAYAAN MASYARAKAT DAN DESA
        </h1>
    </div>
	<div class="box-body table-responsive">

		<div class="toolbar">
			
		</div>
		<table id="perjanjian_kinerja_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th rowspan="2">NO</th>
					<th rowspan="2">SASARAN STRATEGIS/SASARAN</th>
					<th rowspan="2">INDIKATOR KINERJA</th>
					<th rowspan="2">TARGET</th>
					<th rowspan="2">PROGRAM/ KEGIATAN</th>
					<th colspan="2">ANGGARAN</th>
					<th rowspan="2">KET</th>
				</tr>
				<tr>
					<th>SEBELUM PERUBAHAN</th>
					<th>SETELAH PERUBAHA</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>


<script type="text/javascript">


function load_perjanjian_kinerja(){


    $('#perjanjian_kinerja_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,3 ] }
							  ],
			ajax			: {
								url	: '{{ url("api/skpd-pk_sasaran_list") }}',
								data: { renja_id: {!! $renja->id !!} },
							 }, 
			columns			:[
							{ data: 'sasaran_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "sasaran_label", name:"sasaran_label", orderable: true, searchable: true},
							{ data: "ind_sasaran_label", name:"ind_sasaran_label", orderable: true, searchable: true },
							{ data: "", name:"", orderable: true, searchable: true , width:"90px"},
							{ data: "program_label", name:"program_label", orderable: true, searchable: true},
							{ data: "", name:"", orderable: true, searchable: true , width:"90px"},
							{ data: "", name:"", orderable: true, searchable: true , width:"90px"},
							{ data: "", name:"", orderable: true, searchable: true , width:"90px"},
							
						],
						initComplete: function(settings, json) {
							
   				 		}
		
		});	

	}

</script>
