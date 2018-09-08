<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
			<small>
				
				<span class="text-primary"> {!!  $skpd->unit_kerja !!}</span>
			</small>
        </h3>

        <div class="box-tools pull-right">
            {!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
        </div>
    </div>



	<div class="box-body table-responsive">
		<table id="perjanjian_kinerja" data-order='[[ 1, "asc" ]]' data-page-length='25' class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >LABEL</th>
                    <th>MASA PERIODE</th>
					<th>ACTION</th>
				</tr>
			</thead>
			
		</table>

	</div>
</div>

@include('admin.modals.create-perjanjian_kinerja_confirm')


   


<script type="text/javascript">
$(document).ready(function() {
	//alert();

	
	

	$(document).on('click','.create',function(e){
		$('#create-perjanjian-kinerja-form').attr('action', $(this).data('url'));
		$('.periode').html($(this).data('label'));
		$('.periode_tahunan_id').val($(this).data('id'));
		
	});

   
	
	var table = $('#perjanjian_kinerja').DataTable({
		serverSide		: true,
		select			: true,
		searching      	: false,
		paging          : false,
		columnDefs		: [
							{ className: "text-center", targets: [ 0,1,3 ] }
						  ],

		ajax			: {
							url: '{{ url("api_resource/skpd_periode_perjanjian_kinerja_list") }}',
							data: { skpd_id:{{ $skpd->id }} },
							type: 'GET'
						  },
		columns			: [
							{ data: 'rownum' , orderable: false,searchable:false, width:"80px",
									"render": function ( data, type, row ) {
										return row.rownum;
									}
							},
							{ data: "periode_tahunan", name:"periode_tahunan", orderable: true, searchable: true,width:"200px"},
							{ data: "masa_periode" ,  name:"masa_periode", orderable: false, searchable: false},
							{ data: 'action', orderable: false, searchable: false ,width:"150px"}
						  ]
    
	} );

});
</script>
