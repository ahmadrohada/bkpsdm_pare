<div class="box-body table-responsive" style="min-height:330px;">
	<div class="toolbar">
		{{-- @if (request()->segment(4) == 'edit' ) 
		<span><a class="btn btn-info btn-sm add_kegiatan_skp_tahunan" ><i class="fa fa-plus" ></i> Add Kegiatan SKP</a></span>
		@endif --}}
	</div>

	<table id="kegiatan_skp_tahunan_1_table" class="table table-striped table-hover" >
		<thead>
			<tr>
				<th rowspan="2">No</th>
				<th rowspan="2" style="white-space: nowrap; padding: 3px 120px;">KEGIATAN TAHUNAN</th>
				<th rowspan="2" style="padding: 3px 130px;">INDIKATOR</th>
				<th colspan="4">TARGET</th>
				<th rowspan="2"><i class="fa fa-cog"></i></th>
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



<script type="text/javascript">

	$('#kegiatan_skp_tahunan_1_table').DataTable({ 
				destroy			: true,
				processing      : true,
				serverSide      : true,
				searching      	: false,
				paging          : true,
				bInfo			: false,
				bSort			: false,
				lengthChange	: false,
				lengthMenu		: [20,50,100],
				columnDefs		: [
									{ className: "text-center", targets: [ 0,3,4,5,7 ] },
									{ className: "text-right", targets: [ 6 ] },
									@if (request()->segment(4) == 'edit')  
										{ visible: false, "targets": [7]},
									@else
										{ visible: false, "targets": [7]},
									@endif
								],
				ajax			: {
									url	: '{{ url("api/kegiatan_skp_tahunan_1") }}',
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
									{  data: 'action',width:"60px",
											"render": function ( data, type, row ) {
												if ( row.indikator_kegiatan_skp_tahunan_id == null ){
													return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_kegiatan_skp_tahunan"  data-id="'+row.kegiatan_skp_tahunan_label+'"><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_kegiatan_skp_tahunan"  data-id="'+row.kegiatan_skp_tahunan_id+'" data-label="'+row.kegiatan_skp_tahunan_label+'" ><i class="fa fa-close " ></i></a></span>';
												}else{
													return  '<span  data-toggle="tooltip" title="Edit" style="margin:2px;" ><a class="btn btn-success btn-xs edit_indikator_kegiatan_skp_tahunan"  data-id="'+row.indikator_kegiatan_skp_tahunan_label+'"><i class="fa fa-pencil" ></i></a></span>'+
															'<span  data-toggle="tooltip" title="Hapus" style="margin:2px;" ><a class="btn btn-danger btn-xs hapus_indikator_kegiatan_skp_tahunan"  data-id="'+row.indikator_kegiatan_skp_tahunan_id+'" data-label="'+row.indikator_kegiatan_skp_tahunan_label+'" ><i class="fa fa-close " ></i></a></span>';
												}
											
										}
									},
								
								],
								initComplete: function(settings, json) {
								
							}
	});	
</script>