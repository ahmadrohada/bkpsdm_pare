<div class="box box-indikator_kegiatan div_ind_kegiatan_detail" hidden>
	<div class="box-header with-border">
		<h1 class="box-title">
			Detail Indikator Kegiatan
		</h1>

		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-remove "></i>', array('class' => 'btn btn-box-tool tutup_detail','title' => 'Tutup', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body table-responsive">

		<strong>Indikator Kegiatan</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_ind_kegiatan_label"></span>
		</p>

		<strong>Target</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_ind_kegiatan_target"></span>
		</p>

		

		<!-- <i class="fa  fa-gg"></i> <span class="txt_ak" style="margin-right:10px;"></span>
		<i class="fa fa-industry"></i> <span class="txt_output" style="margin-right:10px;"></span>
		<i class="fa fa-hourglass-start"></i> <span class="txt_waktu" style="margin-right:10px;"></span>
		<i class="fa fa-money"></i> <span class="txt_cost" style="margin-right:10px;"></span> -->
					
	</div>
</div>



<script type="text/javascript">

    
	function load_ind_kegiatan_end2(ind_kegiatan_id){
		
		$.ajax({
				url			: '{{ url("api_resource/ind_kegiatan_detail") }}',
				data 		: {ind_kegiatan_id : ind_kegiatan_id},
				method		: "GET",
				dataType	: "json",
				success	: function(data) {
						$('.txt_ind_kegiatan_label').html(data['label']);
						$('.txt_ind_kegiatan_target').html(data['target']+" "+data['satuan']);
						
				},
				error: function(data){
					
				}						
		});

	}



</script>
