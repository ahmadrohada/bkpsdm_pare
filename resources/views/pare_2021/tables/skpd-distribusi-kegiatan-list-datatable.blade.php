<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
			Jabatan {!!  $jenis_jabatan !!}
        </h3>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
            {!! Form::button('<i class="fa fa-times"></i>', array('class' => 'btn btn-box-tool','title' => 'close', 'data-widget' => 'remove', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>
	<div class="box-body table-responsive">

		<table id="jabatan_table" class="table table-striped table-hover table-condensed">
			<thead>
				<tr class="success">
					<th>NO</th>
					<th>JABATAN</th>
					<th>JENIS</th>
					<th>UNIT KERJA</th>
					<th>ACTION</th>
				</tr>
			</thead>
			
			
		</table>

	</div>
</div>


<script type="text/javascript">
$(document).ready(function() {
	//alert();
	

	$('#jabatan_table').DataTable({
			processing      : true,
			serverSide      : true,
			responsive      : true,
			stateSave       : true,
			autoWidth       : true,
			paging          : true,
			ajax			: '{{ action('DistribusiKegiatanController@DataJabatan'.$jenis_jabatan) }}',
			columns	:[
							{ data: 'rownum' , orderable: false,searchable:false,
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
							{ data: "nama_jabatan", name:"jabatan.skpd", orderable: true, searchable: true},
							{ data: "jenis_jabatan" ,  name:"jenis_jabatan.jenis_jabatan", orderable: true, searchable: true},
							{ data: "nama_unit_kerja" , name:"unit_kerja.unit_kerja", orderable: true, searchable: true},
							{ data: 'action', orderable: false, searchable: false ,width:"150px"}
							
						],
						initComplete: function(settings, json) {
							
   				 		}
		
	});	
	
});
</script>
