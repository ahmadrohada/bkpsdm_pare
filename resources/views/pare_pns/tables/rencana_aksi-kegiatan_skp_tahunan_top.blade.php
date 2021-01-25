<div class="box box-kegiatan_tahunan div_kegiatan_skp_tahunan_top">
	<div class="box-header with-border">
		<h1 class="box-title">
			Kegiatan SKP Tahunan 
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
			{!! Form::button('<i class="fa fa-question-circle "></i>', array('class' => 'btn btn-box-tool bantuan','data-id' => '1', 'title' => 'Bantuan', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive" style="min-height:330px;">
		<div class="toolbar"> 

		</div>

		<table id="kegiatan_tahunan_3_table" class="table table-striped table-hover" >
			<thead>
				<tr>
					<th rowspan="2">No</th>
					<th rowspan="2">KEGIATAN TAHUNAN</th>
					<th colspan="4">TARGET</th>
				</tr>
				<tr>
					<th>MUTU</th>
					<th>MUTU</th>
					<th>WAKTU</th>
					<th>ANGGARAN</th>
				</tr>
			</thead>
							
		</table>
	</div>
</div>

<script type="text/javascript">

		$('#kegiatan_tahunan_3_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
				autoWidth		: false,
				bInfo			: false,
				bSort			: false, 
				lengthChange	: false,
				deferRender		: true,
				columnDefs		: [
									{ className: "text-center", targets: [ 0,2,3,4 ] },
									{ className: "text-right", targets: [ 5 ] },
									{ "orderable": false, targets: [ 0,1,2,3,4,5 ]  }
								],
				ajax			: {
									url		: '{{ url("api/kegiatan_skp_tahunan_3") }}',
									data	: { "skp_tahunan_id" : {!! $skp->id !!} }
								},
				rowsGroup		: [0,1,2,3,4,5],
				columns			: [
									{ data: 'no' },
									{ data: "kegiatan_skp_tahunan_label", name:"kegiatan_skp_tahunan_label", width:"220px" },
									{ data: "target_ak", name:"target_ak" },
									{ data: "target_quality", name:"target_quality"},
									{ data: "target_waktu", name:"target_waktu"},
									{ data: "target_cost", name:"target_cost"}
								],
								initComplete: function(settings, json) {
								
							}
		});
</script>