<div class="box box-maroon div_ind_subkegiatan" hidden>
	<div class="box-header with-border">
		{{-- <h1 class="box-title">
			
		</h1> --}}
		&nbsp;
		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa  fa-level-up"></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tujuan List', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">

		<strong>Indikator Sub Kegiatan</strong>
		<p class="text-muted " style="font-size:11pt;">
			<span class="txt_ind_subkegiatan_label"></span>
		</p>

		<strong>Target</strong>
		<p class="text-muted " style="font-size:11pt;">
			<span class="txt_ind_subkegiatan_target"></span>
		</p>

					
	</div>
</div>



<script type="text/javascript">

    
	function load_ind_subkegiatan(ind_subkegiatan_id){
		
		$.ajax({
				url			: '{{ url("api/ind_subkegiatan_detail") }}',
				data 		: {ind_subkegiatan_id : ind_subkegiatan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
						$('.txt_ind_subkegiatan_label').html(data['label']);
						$('.txt_ind_subkegiatan_target').html(data['target']+" "+data['satuan']);
						
				},
				error: function(data){
					
				}						
		});

	}



</script>
