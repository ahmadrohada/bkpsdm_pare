<div class="box-body table-responsive" style="min-height:330px;">
	<div class="toolbar"></div>
	<table id="kegiatan_skp_tahunan_4_table" class="table table-striped table-hover" >
		<thead>
			<tr>
				<th rowspan="2">No</th>
				<th rowspan="2" style="white-space: nowrap; padding: 3px 120px;">KEGIATAN TAHUNAN</th>
				<th rowspan="2" style="padding: 3px 130px;">INDIKATOR</th>
				<th colspan="4">TARGET</th>
			</tr>
			<tr>
				<th style="padding: 3px 25px;">AK</th>
				<th style="padding: 3px 20px;">QUANTITY</th>
				<th>WAKTU</th>
				<th style="padding: 3px 30px;">ANGGARAN</th>

			</tr>
		</thead>
						
	</table>
</div>


@include('pare_pns.modals.kegiatan_skp_tahunan-add')

<script type="text/javascript">

	$('#kegiatan_skp_tahunan_4_table').DataTable({  
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				bInfo			: false,
				bSort			: false,
				lengthChange	: false,
				lengthMenu		: [25,50,100],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,3,4,5 ] },
									{ className: "text-right", targets: [ 6 ] },
								],
				ajax			: {
									url	: '{{ url("api/kegiatan_skp_tahunan_4") }}',
									data: { "skp_tahunan_id" : {!! $skp->id !!} },
								},
				rowsGroup		: [ 0,1,3,5,6 ],
				columns			: [
									{ data: "no",searchable:false},
									{ data: "kegiatan_skp_tahunan_label", name:"kegiatan_skp_tahunan_label"}, 
									{ data: "indikator_kegiatan_skp_tahunan_label", name:"indikator_kegiatan_skp_tahunan_label"}, 
									{ data: "target_ak", name:"target_ak" },
									{ data: "target_quantity", name:"target_quantity"},
									{ data: "target_waktu", name:"target_waktu"},
									{ data: "target_cost", name:"target_cost"},
								],
								initComplete: function(settings, json) {
								
							}
	});	
</script>