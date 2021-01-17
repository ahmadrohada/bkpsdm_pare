
<div class="box box-maroon div_subkegiatan" hidden>
    <div class="box-header with-border">
		{{-- <h1 class="box-title">
            List Kegiatan
        </h1> --}}
		&nbsp;
		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa  fa-level-up"></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => '', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">
		<strong>Sub Kegiatan :</strong>
		<p class="text-muted " style="font-size:11pt;">
			<span class="txt_subkegiatan_label"></span>
		</p>
		<strong>Cost</strong>
		<p class="text-muted " style="font-size:12pt;">
			<span class="cost"></span>
		</p>

		<div class="toolbar pull-right">
			
		</div>
		<table id="ind_subkegiatan_table2" class="table table-striped table-hover table-condensed" >
			<thead>
				<tr class="success">
					<th>NO</th>
					<th >INDIKATOR SUB KEGIATAN</th>
					<th >TARGET</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

@include('pare_pns.modals.renja_ind_subkegiatan')


<script type="text/javascript">
	function load_subkegiatan2(subkegiatan_id){
		$.ajax({
				url			: '{{ url("api/subkegiatan_detail") }}',
				data 		: {subkegiatan_id : subkegiatan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
						$('.txt_subkegiatan_label').html(data['label']);
						$('.cost').html("Rp. "+ data['cost']);
						$('.subkegiatan_id').val(data['subkegiatan_id']);
						
				},
				error: function(data){
					
				}						
		});

		$('#ind_subkegiatan_table2').DataTable({
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
										{ className: "text-center", targets: [ 0,2 ] }
									],
					ajax			: {
										url	: '{{ url("api/skpd-renja_ind_subkegiatan_list") }}',
										data: { subkegiatan_id: subkegiatan_id },
									}, 
					columns			:[
									{ data: 'ind_subkegiatan_id' , orderable: true,searchable:false,width:"30px",
											"render": function ( data, type, row ,meta) {
												return meta.row + meta.settings._iDisplayStart + 1 ;
											}
										},
									{ data: "label_ind_subkegiatan", name:"label_ind_subkegiatan", orderable: true, searchable: true},
									{ data: "target_ind_subkegiatan", name:"target_ind_subkegiatan", orderable: true, searchable: true, width:"90px"},
								
								],
								initComplete: function(settings, json) {
									
									}
			
			
		});	
	}

</script>
