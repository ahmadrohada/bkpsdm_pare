<div class="box box-primary div_ka_skpd_detail">
	<div class="box-header with-border">
		<h1 class="box-title">
			Detail SKPD
		</h1>


		<div class="box-tools pull-right">
			
		</div>
	</div>
	<div class="box-body table-responsive">

		<strong>Periode renja</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="periode_label">
				{{ $renja->Periode->label}}
			</span>
		</p>

		<strong>SKPD</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="skpd_label">
				{{ Pustaka::capital_string($renja->SKPD->skpd) }}
			</span>
		</p>


		<!-- <i class="fa  fa-gg"></i> <span class="txt_ak" style="margin-right:10px;"></span>
		<i class="fa fa-industry"></i> <span class="txt_output" style="margin-right:10px;"></span>
		<i class="fa fa-hourglass-start"></i> <span class="txt_waktu" style="margin-right:10px;"></span>
		<i class="fa fa-money"></i> <span class="txt_cost" style="margin-right:10px;"></span> -->
					
	</div>
</div>
<div class="box box-primary div_kegiatan_ka_skpd_list">
    <div class="box-header with-border">
		<h1 class="box-title">
            Kegiatan List
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>



	<div class="box-body table-responsive">

		<div class="toolbar">
			
			<span  data-toggle="tooltip" title="Create Tujuan"><a class="btn btn-info btn-sm create_tujuan" ><i class="fa fa-plus" ></i> Tujuan</a></span>
		
		</div>
		<table id="kegiatan_ka_skpd_table" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >LABEL</th>
					<th><i class="fa fa-cog"></i></th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>


<script type="text/javascript">

    $('#kegiatan_ka_skpd_table').DataTable({
				destroy			: true,
				processing      : false,
				serverSide      : true,
				searching      	: false,
				paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2 ] }
							  ],
			ajax			: {
								url	: '{{ url("api_resource/skpd-renja_tujuan_list") }}',
								data: { renja_id: {!! $renja->id !!} },
							 }, 
			columns			:[
							{ data: 'tujuan_id' , orderable: true,searchable:false,width:"30px",
									"render": function ( data, type, row ,meta) {
										return meta.row + meta.settings._iDisplayStart + 1 ;
									}
								},
							{ data: "label", name:"x", orderable: true, searchable: true},
							{  data: 'action',width:"60px",
									"render": function ( data, type, row ) {
										return  '<span  data-toggle="tooltip" title="Edit" style="margin:1px;" ><a class="btn btn-success btn-xs edit_tujuan"  data-id="'+row.tujuan_id+'"><i class="fa fa-pencil" ></i></a></span>'+
												'<span  data-toggle="tooltip" title="Hapus" style="margin:1px;" ><a class="btn btn-danger btn-xs hapus_tujuan"  data-id="'+row.tujuan_id+'" data-label="'+row.label+'" ><i class="fa fa-close " ></i></a></span>';
											
									}
							},
						],
						initComplete: function(settings, json) {
							
   				 		}
		
	});	

	

</script>
