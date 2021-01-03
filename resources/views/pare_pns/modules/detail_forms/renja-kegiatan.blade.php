<div class="box box-primary div_kegiatan_detail" hidden>
	<div class="box-header with-border">
		<h1 class="box-title">
			Detail Kegiatan
		</h1>

		<div class="box-tools pull-right">
			
		</div>
	</div>
	<div class="box-body table-responsive" >

		<strong>Label</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_kegiatan_label"></span>
		</p>

		<strong>Indikator</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_kegiatan_indikator"></span>
		</p>

		<strong>Target</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_kegiatan_target"></span>
		</p>

		<strong>Anggaran</strong>
		<p class="text-muted " style="margin-top:8px;padding-bottom:10px;">
			<span class="txt_kegiatan_cost"></span>
		</p>

					
	</div>
</div>


<script type="text/javascript">


function load_ind_kegiatan(kegiatan_id){


	$.ajax({
			url			: '{{ url("api/kegiatan_detail") }}',
			data 		: {kegiatan_id : kegiatan_id},
			method		: "GET",
			dataType	: "json",
			success	: function(data) {
					$('.txt_kegiatan_label').html(data['label']);
					$('.txt_kegiatan_indikator').html(data['indikator']);
					$('.txt_kegiatan_target').html(data['target']+' '+data['satuan']);
					$('.txt_kegiatan_cost').html("Rp. "+data['cost']);
					
					
			},
			error: function(data){
				
			}						
	});



}



</script>
