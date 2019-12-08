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

			<form method="post" 
				target="_blank" 
				action="tpp_report/cetak">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
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
							</select>
						</div>
					</div>
				</div>
				<div class="form-group margin skpd_f">
					<label>SKPD</label>
					<!-- <div class="input-group input-group-sm"> -->
					<select class="form-control input-sm skpd" name="tpp_report_id" style="width: 100%;"></select>
					<!-- <span class="input-group-btn">
							<button type="button" class="btn btn-info btn-flat">Go!</button>
						</span> -->
					<!-- </div> -->
				</div>
				<div class="form-group margin unit_kerja_f">
					<label>Unit Kerja</label>
					<select class="form-control input-sm unit_kerja" name="unit_kerja_id" style="width: 100%;">
						<option value="all">-</option>
					</select>

				</div>
				<div class="form-group margin div_lihat">
					<button type="button" class="btn btn-info btn-block lihat">Lihat <i class="fa fa-eye"></i></button>
				</div>
				<div class="form-group margin div_cetak hidden" >
					<button type="submit" class="btn btn-success btn-block cetak">Cetak <i class="fa fa-print"></i></button>
				</div>

				{{-- <button class="lihat form-control btn-primary btn-sm" >
					Lihat
					<i class="lihat_table glyphicon glyphicon-eye-open"></i>
					<i class="load_table fa fa-spinner faa-spin animated"></i>
				</button>
				<button class="cetak form-control btn-success btn-sm" >
					Cetak
					<i class=" glyphicon glyphicon-print"></i>
				</button> --}}

				


			</div>
			</form>
		</div>
	</div>
</div>





<script type="text/javascript">

	function reset_div(){
		$('.div_cetak').addClass('hidden');
		$('.div_lihat').removeClass('hidden');

		//$('#tpp_report_table').DataTable().clear().draw();
	}

	$('.periode_capaian_f').on('click', function() {
		$('.periode_capaian_f').removeClass('has-error');
	});
	$('.skpd_f').on('click', function() {
		$('.skpd_f').removeClass('has-error');
	});
	$('.unit_kerja_f').on('click', function() {
		$('.unit_kerja_f').removeClass('has-error');
	});


	$('.periode_bulan,.skpd,.unit_kerja').select2();
	//$('.unit_kerja').attr("disabled", true);

	$('.periode_tahun').select2({
		ajax: {
			url: '{{ url("api_resource/cetak_tpp_periode_list") }}',
			dataType: 'json',
			quietMillis: 500,
			data: function(params) {
				var queryParameters = {
					tahun: params.term
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


	$('.periode_tahun').change(function() {

		reset_div();
		periode_id = $(this).val();
		$('.periode_bulan').select2({
			ajax: {
				url: '{{ url("api_resource/cetak_tpp_periode_bulan_list") }}',
				dataType: 'json',
				quietMillis: 500,
				data: function(params) {
					var queryParameters = {
						bulan: params.term,
						periode_id:periode_id
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


	$('.periode_bulan').change(function() {
		bulan = $(this).val();
		periode_id = $('.periode_tahun').val();

		$('.skpd').val('').trigger('change');
		reset_div();

		$('.skpd').select2({
			ajax: {
				url: '{{ url("api_resource/cetak_tpp_skpd_list") }}',
				dataType: 'json',
				quietMillis: 500,
				data: function(params) {
					var queryParameters = {
						nama_skpd: params.term,
						periode_id:periode_id,
						bulan:bulan
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

	

	$('.skpd').change(function() {
		tpp_report_id = $(this).val();
		reset_div();
		

		$('.unit_kerja').val('').trigger('change');
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
		
		reset_div();

	});

	$(document).on('click', '.lihat', function() {

		periode_id 		= $(".periode_tahun").val();
		bulan 			= $(".periode_bulan").val();
		tpp_report_id 	= $(".skpd").val();
		unit_kerja_id 	= $(".unit_kerja").val();

		var data = [periode_id, bulan, tpp_report_id, unit_kerja_id];
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

		if ( (periode_id != null) & (bulan != null) & (tpp_report_id != null) & (unit_kerja_id != null) ) {
			load_table_tpp(tpp_report_id, unit_kerja_id);
			//alert();
		}
		


	});

	
</script>