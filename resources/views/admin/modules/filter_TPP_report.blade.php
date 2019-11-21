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
				<div class="form-group margin periode_capaian_f">
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
				<div class="form-group margin skpd_f">
					<label>SKPD</label>
					<!-- <div class="input-group input-group-sm"> -->
					<select class="form-control input-sm skpd" name="skpd" style="width: 100%;"></select>
					<!-- <span class="input-group-btn">
							<button type="button" class="btn btn-info btn-flat">Go!</button>
						</span> -->
					<!-- </div> -->
				</div>
				<div class="form-group margin unit_kerja_f">
					<label>Unit Kerja</label>
					<select class="form-control input-sm unit_kerja" name="unit_kerja" style="width: 100%;">
						<option value="all">SEMUA UNIT KERJA</option>
					</select>

				</div>
				<div class="form-group margin">
					<button type="button" class="btn btn-info btn-block lihat">Lihat <i class="fa fa-eye"></i></button>

				</div>




			</div>
		</div>
	</div>
</div>





<script type="text/javascript">
	$('.periode_capaian_f').on('click', function() {
		$('.periode_capaian_f').removeClass('has-error');
	});
	$('.skpd_f').on('click', function() {
		$('.skpd_f').removeClass('has-error');
	});
	$('.unit_kerja_f').on('click', function() {
		$('.unit_kerja_f').removeClass('has-error');
	});


	$('.periode_bulan,.unit_kerja').select2();
	$('.unit_kerja').attr("disabled", true);

	$('.periode_tahun').select2({
		ajax: {
			url: '{{ url("api_resource/tpp_report_periode_tahunan_list") }}',
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

	$('.skpd').select2({
		ajax: {
			url: '{{ url("api_resource/tpp_report_skpd_list") }}',
			dataType: 'json',
			quietMillis: 500,
			data: function(params) {
				var queryParameters = {
					nama_skpd: params.term
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

	$('.skpd').change(function() {
		skpd_id = $(this).val();
		//alert(skpd_id);


		$('.unit_kerja').attr("disabled", false);
		$('.unit_kerja').val('all').trigger('change');


		$('.unit_kerja').select2({
			ajax: {
				url: '{{ url("api_resource/tpp_report_unit_kerja_list") }}',
				dataType: 'json',
				quietMillis: 500,
				data: function(params) {
					var queryParameters = {
						skpd_id: skpd_id,
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

	$(document).on('click', '.lihat', function() {

		periode_tahun = $(".periode_tahun").val();
		periode_bulan = $(".periode_bulan").val();
		skpd = $(".skpd").val();
		unit_kerja = $('.unit_kerja').val();
		var data = [periode_tahun, periode_bulan, skpd, unit_kerja];
		$.each(data, function(index, value) {
			if (index == 0) {
				((value == null) ? $('.periode_capaian_f').addClass('has-error') : '');
			}
			if (index == 1) {
				((value == null) ? $('.periode_capaian_f').addClass('has-error') : '');
			}
			if (index == 2) {
				((value == null) ? $('.skpd_f').addClass('has-error') : '');
			}
			if (index == 3) {
				((value == null) ? $('.unit_kerja_f').addClass('has-error') : '');
			}
		});

		if ( (periode_tahun != null) & (periode_bulan != null) & (skpd != null) & (unit_kerja != null) ) {
			load_table_tpp(periode_tahun, periode_bulan, skpd, unit_kerja);
			//alert();
		}
		


	});

	
</script>