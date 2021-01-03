<div class="box box-primary">
	<div class="box-header with-border">
		<h1 class="box-title">
			Detail Sasaran
		</h1>

		<div class="box-tools pull-right">
			
		</div>
	</div>
	<div class="box-body table-responsive">

		<!-- <strong>Periode</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="kegiatan_tahunan_label"></span>
		</p>

		<strong>SKPD</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="kegiatan_tahunan_label"></span>
		</p> -->


		<!-- <i class="fa  fa-gg"></i> <span class="txt_ak" style="margin-right:10px;"></span>
		<i class="fa fa-industry"></i> <span class="txt_output" style="margin-right:10px;"></span>
		<i class="fa fa-hourglass-start"></i> <span class="txt_waktu" style="margin-right:10px;"></span>
		<i class="fa fa-money"></i> <span class="txt_cost" style="margin-right:10px;"></span> -->
					
	</div>
</div>
<div class="box box-primary">
    <div class="box-header with-border">
		<h1 class="box-title">
            List Indikator Sasaran
        </h1>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>



	<div class="box-body table-responsive">

		<div class="toolbar">
			
			<span  data-toggle="tooltip" title="Create Tujuan"><a class="btn btn-info btn-sm create_tujuan" ><i class="fa fa-plus" ></i> Tujuan</a></span>
		
		</div>
		<table id="ind_sasaran" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >LABEL</th>
					<th>ACTION</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>



<script type="text/javascript">

    $('#ind_sasaran').DataTable({
			processing      : true,
			serverSide      : true,
			searching      	: false,
			paging          : false,
			columnDefs		: [
								{ className: "text-center", targets: [ 0,2 ] }
							  ],
			/* ajax			: {
								url	: '{{ url("api/skpd-renja_kegiatan_list") }}',
								data: { indikator_sasaran_id: 100 },
							 }, */
			columns			:[
							{ data: 'rownum' , orderable: false,searchable:false, width:"60px",
								"render": function ( data, type, row ) {
									return row.rownum;
									/* switch (row.rownum) {
									case 1:
										return '<i class="fa fa-close text-red">'+row.rownum+'</i>';
										break;
									case 2:
										return '<i class="fa fa-check text-blue">'+row.rownum+'</i>';
										break; 
									} */
							}},
							{ data: "label", name:"x", orderable: true, searchable: true},
							{ data: 'action', orderable: false, searchable: false ,width:"150px"}
							
						],
						initComplete: function(settings, json) {
							
   				 		}
		
	});	

</script>
