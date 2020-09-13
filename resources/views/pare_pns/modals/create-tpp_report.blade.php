<div class="modal fade create-tpp_report_modal" id="createKegiatan" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">
					Create TPP Report
				</h4>
			</div>

			<form id="create-tpp_report-form" method="POST" action="">


				<div class="modal-body">

					<input type="hidden" name="skpd_id" class="form-control skpd_id"> 
					<input type="hidden" name="periode_id" class="form-control periode_id">
					<input type="hidden" name="formula_hitung_id" class="form-control formula_hitung_id">
					<input type="hidden" name="ka_skpd" class="form-control ka_skpd">
					<input type="hidden" name="admin_skpd" class="form-control admin_skpd">


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
							<span class="tahun"></span> 
						</p>
					</div>

					<div class="form-group jabatan ">
						<label>Bulan Kinerja</label> 
						<select class="form-control input-sm bulan" id="bulan" name="bulan" style="width:100%">
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
				<div class="modal-footer">
					{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
					{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-sm btn-primary pull-right ', 'type' => 'button', 'id' => 'simpan_tpp_report' )) !!}
				</div>

			</form>
		</div>
	</div>
</div>







<script type="text/javascript">

	$('.bulan').select2();

	$(document).on('click', '#simpan_tpp_report', function() {
		show_loader();
		var data = $('#create-tpp_report-form').serialize();
		$.ajax({
			url: '{{ url("api_resource/simpan_tpp_report") }}',
			type: 'POST',
			data: data,
			success: function(data, textStatus, jqXHR) {

				$('#skpd_tpp_report_list_table').DataTable().ajax.reload(null, false);

				Swal.fire({
					title: "",
					text: "Sukses",
					type: "success",
					width: "200px",
					showConfirmButton: false,
					allowOutsideClick: false,
					timer: 1500
				}).then(function() {
						$('.create-tpp_report_modal').modal('hide');

					},

					function(dismiss) {
						if (dismiss === 'timer') {

						}
					}
				)
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('#skpd_tpp_report_list_table').DataTable().ajax.reload(null, false);
				swal.close();
				//var test = $.parseJSON(jqXHR.responseText);
				//var data = test.errors;

				Swal.fire({
						title				: "Create TPP Report",
						text				: "Terjadi Kesalahan",
						type				: "warning",
						confirmButtonText	: "Close",
						confirmButtonColor	: "btn btn-success",
					});
			}

		});

	});
</script>