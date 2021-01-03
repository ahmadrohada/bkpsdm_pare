<div class="box-body table-responsive">
	<div class="toolbar">
	</div>
	<table id="kegiatan_bulanan_table" class="table table-striped table-hover" >
		<thead>
			<tr>
				<th>No</th>
				<th>KEGIATAN BULANAN</th>
				<th>TARGET</th>
			</tr>
		</thead>
	</table>
</div>

@include('pare_pns.modals.kegiatan_bulanan')

<script type="text/javascript">

  function LoadKegiatanBulananTable(){
		var table_skp_bulanan = $('#kegiatan_bulanan_table').DataTable({
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: true,
				paging          : true,
				autoWidth		: false,
				bInfo			: false,
				bSort			: false,
				lengthChange	: false,
				deferRender		: true,
				order 			: [ 0 , 'asc' ],
				//lengthMenu		: [10,25,50],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2 ] },
								],
				ajax			: {
									url	: '{{ url("api/kegiatan_bulanan_5") }}',
									data: { 
										
											"renja_id" 		 : {!! $skp->SKPTahunan->Renja->id !!} , 
											"jabatan_id" 	 : {!! $skp->PegawaiYangDinilai->Jabatan->id !!},
											"skp_bulanan_id" : {!! $skp->id !!}
									 },
								},
				columns			: [
									{ data: 'rencana_aksi_id' ,width:"30px",
										"render": function ( data, type, row ,meta) {
											return meta.row + meta.settings._iDisplayStart + 1 ;
									}
									},
									{ data: "label", name:"label",
										"render": function ( data, type, row ) {
											return row.label;
											
										}
									},
									{ data: "target", name:"target", width:"140px",
										"render": function ( data, type, row ) {
											if ( (row.kegiatan_bulanan_id) <= 0 ){
												return "<span class='text-danger'>"+row.target+"</span>";
											}else{
												return row.target;
											}
										}
									},
								],
								initComplete: function(settings, json) {
								
							}
		});	
	}

	

</script>
