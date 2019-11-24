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
					<input type="hidden" name="bulan" class="form-control bulan">
					<input type="hidden" name="formula_perhitungan_id" class="form-control formula_perhitungan_id" value="1">
					<input type="hidden" name="ka_skpd" class="form-control ka_skpd">
					<input type="hidden" name="admin_skpd" class="form-control admin_skpd">


					<div class="form-group">
						<label>Nama SKPD</label>
						<p class="label-perjanjian-kinerja">
							<span class="nama_skpd"></span>
						</p>
					</div>
					<div class="form-group">
						<label>Jumlah Pegawai</label>
						<p class="label-perjanjian-kinerja">
							<span class="jumlah_pegawai"></span>
						</p>
					</div>

				</div>
				<div class="modal-footer">
					{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_cancel_text'), array('class' => 'btn btn-sm btn-default pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
					{!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> ' . Lang::get('modals.confirm_modal_button_save_text'), array('class' => 'btn btn-sm btn-primary pull-right btn-flat', 'type' => 'button', 'id' => 'simpan_tpp_report' )) !!}
				</div>

			</form>
		</div>
	</div>
</div>







<script type="text/javascript">
	
	$('.create-tpp_report_modal').on('hidden.bs.modal', function() {
		$('.txt-kegiatan').html('');
		$('.kegiatan').removeClass('has-error');
		$("#jabatan").select2("val", "");
	});

	$(document).on('click', '.kegiatan', function() {
		$('.kegiatan').removeClass('has-error');
	});



	$(document).on('click', '#simpan_tpp_report', function() {

		var data = $('#create-tpp_report-form').serialize();
		$.ajax({
			url: '{{ url("api_resource/simpan_tpp_report") }}',
			type: 'POST',
			data: data,
			success: function(data, textStatus, jqXHR) {

				$('#kegiatan_table').DataTable().ajax.reload(null, false);

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

				var test = $.parseJSON(jqXHR.responseText);

				var data = test.errors;

				$.each(data, function(index, value) {
					//alert (index+":"+value);




				});


			}

		});

	});
</script>