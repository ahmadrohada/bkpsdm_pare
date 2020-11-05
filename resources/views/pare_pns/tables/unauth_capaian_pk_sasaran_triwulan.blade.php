<div class="box-body table-responsive" style="min-height:330px;">
	<div class="toolbar">  
 	</div>

	<table id="realisasi_sasaran_triwulan_table" class="table table-striped table-hover" >
		<thead>
			<tr>
				<th>NO</th>
				<th>SASARAN PERJANJIAN KINERJA</th>
				<th>INDIKATOR SASARAN</th>
				<th>TARGET</th>
				<th>REALISASI</th>
				<th><i class="fa fa-cog"></i></th>
			</tr>
		</thead>
							
	</table>

</div>

<style>
table.dataTable tbody td {
  vertical-align: middle;
}
</style>


@include('pare_pns.modals.realisasi_sasaran_triwulan')

<script type="text/javascript">

	load_sasaran_triwulan();
  	function load_sasaran_triwulan(){
		
		var table_sasaran_triwulan = $('#realisasi_sasaran_triwulan_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: true,
				paging          : false,
				//order 			: [0 , 'asc' ],
				columnDefs		: [
									{ "orderable": false, className: "text-center", targets: [ 0,3,4,5 ] },
									@if ( ( request()->segment(4) == 'edit' )|( request()->segment(4) == 'ralat' ) )  
										{ visible: true, "targets": [5]}
									@else
										{ visible: false, "targets": [5]}
									@endif
									 
								],
				ajax			: {
									url	: '{{ url("api_resource/realisasi_sasaran_triwulan") }}',
									data: { 
											"capaian_pk_triwulan_id" 	: 789,
											"renja_id" 					: 45,
										 },
								},
				targets			: 'no-sort',
				bSort			: false,
				rowsGroup		: [ 1 ],
				columns			: [
									{ data: 'sasaran_id' , orderable: true,searchable:false,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
										}
									},
									{ data: "sasaran_label", name:"sasaran_label",
										"render": function ( data, type, row ) {
											return row.sasaran_label;
											
										}
									}, 
									{ data: "indikator_label", name:"indikator_label",
										"render": function ( data, type, row ) {
											return row.indikator_label;
											
										}
									}, 
									
									{ data: "target", name:"target", width:"100px",
										"render": function ( data, type, row ) {
											return row.target ;
										}
									},
									{ data: "realisasi_quantity", name:"realisasi_quantity", width:"100px",
										"render": function ( data, type, row ) {
											if ( (row.realisasi_indikator_id) >= 1 ){
												return row.realisasi_quantity ;
											}else{
												return  '-';
											
											} 

											
										}
									},
									{  data: 'action',width:"60px",
											"render": function ( data, type, row ) {
										
												return  '<span style="margin:2px;" ><a class="btn btn-default btn-xs "  "><i class="fa fa-pencil" ></i></a></span>'+
														'<span style="margin:2px;" ><a class="btn btn-default btn-xs "  "><i class="fa fa-close " ></i></a></span>';
									
										}
									},
									
								
								],
								initComplete: function(settings, json) {
								
							}
		});	
	}


</script>
