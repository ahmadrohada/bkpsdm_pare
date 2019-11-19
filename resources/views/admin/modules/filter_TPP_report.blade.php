<div class="box {{ $h_box}}">
	<div class="box-header with-border">
		<h1 class="box-title">
			Filter TPP Report
		</h1>
		<div class="box-tools pull-right">
			{!! Form::button('<i class="fa fa-minus"></i>', array('class' => 'btn btn-box-tool','title' => 'Collapse', 'data-widget' => 'collapse', 'data-toggle' => 'tooltip')) !!}
		</div>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-5">
				<div class="form-group margin">
					<label>Periode capaian</label>
					<div class="row">
						<div class="col-xs-4">
							<select class="form-control input-sm periode_tahun" name="periode_tahun" style="width: 100%;"></select>
						</div>
						<div class="col-xs-8">
							<select class="form-control input-sm periode_bulan" name="periode_bulan" style="width: 100%;">
								<option value="">Pilih Bulan</option>
								<option value="01">Januari</option>
								<option value="02">Februari</option>
								<option value="03">Maret</option>
								<option value="04">April</option>
								<option value="05">Mei</option>
								<option value="06">Juni</option>
								<option value="07">Juli</option>
								<option value="08">Agustus</option>
								<option value="09">September</option>
								<option value="10">Oktober</option>
								<option value="11">November</option>
								<option value="12">Desember</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group margin">
					<label>SKPD</label>
					<div class="input-group input-group-sm">
						<input type="text" class="form-control input-sm">
						<span class="input-group-btn">
							<button type="button" class="btn btn-info btn-flat">Go!</button>
						</span>
					</div>
				</div>
				<div class="form-group margin">
					<label>Unit Kerja</label>
					<select class="form-control input-sm unit_kerja" name="unit_kerja" style="width: 100%;"></select>

				</div>
				<div class="form-group margin">
					<button type="button" class="btn btn-info btn-block">Lihat <i class="fa fa-eye"></i></button>

				</div>




			</div>
		</div>
	</div>
</div>





<script type="text/javascript">
	$('.periode_bulan,.unit_kerja').select2();

	$('.periode_tahun').select2({
		ajax: {
			url: '{{ url("api_resource/periode_tahunan_list") }}',
			dataType: 'json',
			quietMillis: 500,
			data: function(params) {
				var queryParameters = {
					jabatan: params.term
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
</script>