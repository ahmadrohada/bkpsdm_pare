<div class="modal fade cetak-tpp_report_modal" id="cetakTPPReport" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">
					Cetak TPP Report
				</h4>
			</div>
			<div class="modal-body"> 
			<form method="post" target="_blank" action="tpp_report/cetak">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="tpp_report_id" class="tpp_report_id" >
				
					<div class="form-group">
						<label>Nama SKPD</label>
						<p class="label-perjanjian_kinerja">
							<span class="nama_skpd"></span>
						</p>
					</div>
					<div class="form-group">
						<label>Jumlah Pegawai</label>
						<p class="label-perjanjian_kinerja">
							<span class="jumlah_pegawai"></span>
						</p>
					</div>
					<div class="form-group">
						<label>Periode</label>
						<p class="label-perjanjian_kinerja">
							<span class="periode"></span> 
						</p>
					</div>

					<div class="form-group unit_kerja_f">
						<label>Unit Kerja</label>
						<select class="form-control input-sm unit_kerja" name="unit_kerja_id" style="width: 100%;">
							<option value="all">-</option>
						</select>
	
					</div>

			</div>
			<div class="modal-footer">
				<div class="form-group  div_cetak hidden" >
					<button type="submit" class="btn btn-success btn-block cetak">Cetak <i class="fa fa-print"></i></button>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>







<script type="text/javascript">
	$('.cetak').on('click', function(){
		$('.cetak-tpp_report_modal').modal('hide'); 
	});

	$('.unit_kerja_f').on('click', function() {
		$('.unit_kerja_f').removeClass('has-error');
	});

	$('.unit_kerja').select2();

	$('.cetak-tpp_report_modal').on('hidden.bs.modal', function(){
		$('.unit_kerja').val("").trigger('change');
	})


	$('.cetak-tpp_report_modal').on('shown.bs.modal', function(){
		var tpp_report_id = $('.tpp_report_id').val();
		$('.unit_kerja').select2({
			ajax: {
				url: '{{ url("api_resource/cetak_tpp_unit_kerja_list") }}',
				dataType: 'json',
				quietMillis: 500,
				data: function(params) {
					var queryParameters = {
						tpp_report_id: tpp_report_id,
						nama_unit_kerja: params.term
					}
					return queryParameters;
				},
				processResults: function(data) {
					return {
						results: $.map(data, function(item) {
							return {
								text: item.text,
								id: item.id,
							}
						})
					};
				}
			},
		});
	});
	

	$('.unit_kerja').change(function() {
		$('.div_cetak').removeClass('hidden');
	});

</script>