<div class="modal fade modal-tpp_report_data" id="createIndikatorProgram" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    TPP Report Data  
                </h4>
            </div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12 form-group" style="margin-top:-10px;">
						<strong>Nama Pegawai</strong>
						<p class="text-info " style="margin-top:1px;">
							<span class="nama_pegawai"></span>
						</p>
					</div>
					<div class="col-md-12 form-group" style="margin-top:-8px !important;">
						<strong>Jabatan / Eselon</strong>
						<p class="text-info " style="margin-top:1px;">
							<span class="jabatan"></span>
						</p>
					</div>
					<div class="col-md-12 form-group" style="margin-top:-10px">
						<strong>TPP Rupiah</strong>
						<p class="text-info " style="margin-top:1px;">
							<span class="tpp_rupiah"></span>
						</p>
					</div>
				</div>
				<div class="row" style="padding-left:15px; padding-right:15px;">
					<strong>KINERJA</strong>
					<table class="table table table-striped table-condensed table-hover no-footer dataTable">
						<thead>
							<tr>
								<th>TPP x <span class="persen_kinerja"></span></th>
								<th>CAP</th>
								<th>SKOR</th>
								<th>POT % </th>
								<th>JM TPP</th>
							</tr>
						</thead>
						<tr style="font-size:10pt; color:#185286;">
							<td style="text-align:right"><span class="tpp_kinerja"></span></td>
							<td style="text-align:center"><span class="capaian_kinerja"></td>
							<td style="text-align:center"><span class="skor_capaian"></td>
							<td style="text-align:center"><span class="potongan_kinerja"></td>
							<td style="text-align:right"><span class="jm_tpp_kinerja"></td>
						</tr>

					</table>
				</div>
				<div class="row" style="margin-top:10px; padding-left:15px; padding-right:15px;">
					<strong>KEHADIRAN</strong>
					<table class="table table table-striped table-condensed table-hover no-footer dataTable">
						<thead>
							<tr>
								<th>TPP x <span class="persen_kehadiran"></span></th>
								<th>SKOR</th>
								<th>POT % </th>
								<th>JM TPP</th>
							</tr>
						</thead>
						<tr style="font-size:10pt; color:#185286;">
							<td style="text-align:right"><span class="tpp_kehadiran"></td>
							<td style="text-align:center"><span class="skor_kehadiran"></td>
							<td style="text-align:center"><span class="pot_kehadiran"></td>
							<td style="text-align:right"><span class="jm_tpp_kehadiran"></td>
						</tr>

					</table>
				</div>
				<div class="row data_baru_tpp hidden"  style="margin-top:-10px;">
					<hr>
					<div class="col-md-12 form-group text-center" style="margin-top:-10px;">
						<strong>DATA BARU</strong>
					</div>
					<div class="col-md-12 form-group" style="margin-top:-10px;">
						<strong>TPP Rupiah</strong>
						<p class="text-info " style="margin-top:1px;">
							<span class="new_tpp_rupiah"></span>
						</p>
					</div>
				</div>
				<div class="row data_baru_kinerja hidden" style="padding-left:15px; padding-right:15px;">
					<strong>KINERJA</strong>
					<table class="table table table-striped table-condensed table-hover no-footer dataTable">
						<thead>
							<tr>
								<th>TPP x <span class="new_persen_kinerja"></span></th>
								<th>CAP</th>
								<th>SKOR</th>
								<th>POT % </th>
								<th>JM TPP</th>
							</tr>
						</thead>
						<tr style="font-size:10pt; color:#185286;">
							<td style="text-align:right"><span class="new_tpp_kinerja"></span></td>
							<td style="text-align:center"><span class="new_capaian_kinerja"></td>
							<td style="text-align:center"><span class="new_skor_capaian"></td>
							<td style="text-align:center"><span class="new_potongan_kinerja"></td>
							<td style="text-align:right"><span class="new_jm_tpp_kinerja"></td>
						</tr>

					</table>
				</div>
				<div class="row data_baru_kehadiran hidden" style="margin-top:10px; padding-left:15px; padding-right:15px;">
					<strong>KEHADIRAN</strong>
					<table class="table table table-striped table-condensed table-hover no-footer dataTable">
						<thead>
							<tr>
								<th>TPP x <span class="new_persen_kehadiran"></span></th>
								<th>SKOR</th>
								<th>POT % </th>
								<th>JM TPP</th>
							</tr>
						</thead>
						<tr style="font-size:10pt; color:#185286;">
							<td style="text-align:right"><span class="new_tpp_kehadiran"></td>
							<td style="text-align:center"><span class="new_skor_kehadiran"></td>
							<td style="text-align:center"><span class="new_pot_kehadiran"></td>
							<td style="text-align:right"><span class="new_jm_tpp_kehadiran"></td>
						</tr>

					</table>
				</div>
				
			</div>
			<form  id="update_tpp" method="POST" action="">

			<input type="hidden"  name="tpp_report_data_id" class="tpp_report_data_id">
			<input type="hidden"  name="new_capaian_bulanan_id" class="new_capaian_bulanan_id">
			<input type="hidden"  name="new_tpp_rupiah" class="new_tpp_rupiah">
			<input type="hidden"  name="new_tpp_kinerja" class="new_tpp_kinerja">
			<input type="hidden"  name="new_capaian_kinerja" class="new_capaian_kinerja">
			<input type="hidden"  name="new_skor_capaian" class="new_skor_capaian">
			<input type="hidden"  name="new_potongan_kinerja" class="new_potongan_kinerja">

			<input type="hidden"  name="new_tpp_kehadiran" class="new_tpp_kehadiran">
			<input type="hidden"  name="new_skor_kehadiran" class="new_skor_kehadiran">
			<input type="hidden"  name="new_pot_kehadiran" class="new_pot_kehadiran">

			<div class="modal-footer ">
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_cancel_icon').'" aria-hidden="true"></i> Batal', array('class' => 'btn btn-sm btn-default pull-left ', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
                {!! Form::button('<i class="fa fa-fw '.Lang::get('modals.confirm_modal_button_save_icon').'" aria-hidden="true"></i> <span name="text_button_submit">UPDATE TPP</span>', array('class' => 'btn btn-primary data_baru btn-sm pull-right  btn-submit', 'type' => 'button', 'id' => 'simpan' )) !!}
            </div>

            </form>
        </div>
    </div>
</div>




<script type="text/javascript">

	

	$('.modal-tpp_report_data').on('hidden.bs.modal', function(){
	
		$('.sidebar-mini').attr("style", "padding-right:0px;");
		$('.data_baru_kehadiran,.data_baru_kinerja,.data_baru_tpp').hidden(); 

	});


	$(document).on('click','#simpan',function(e){
			var data = $('#update_tpp').serialize();
			show_loader();
			$.ajax({
				url		: '{{ url("api/tpp_report_data_update") }}',
				type	: 'POST',
				data	:  data,
				success	: function(data , textStatus, jqXHR) {
					swal.close();
					Swal.fire({
						title: "",
						text: "Sukses",
						type: "success",
						width: "200px", 
						showConfirmButton: false,
						allowOutsideClick : false,
						timer:1500
					}).then(function () {
						$('.modal-tpp_report_data').modal('hide');
						$('#tpp_report_data_table').DataTable().ajax.reload(null,false);
						
					},
						
						function (dismiss) {
							if (dismiss === 'timer') {
								$('.modal-tpp_report_data').modal('hide');
								$('#tpp_report_data_table').DataTable().ajax.reload(null,false);
							}
						}
				)	
				},
				error: function(jqXHR , textStatus, errorThrown) {
					swal.close();
					var test = $.parseJSON(jqXHR.responseText);
					var data= test.errors;
					$.each(data, function(index,value){
					});
				}
			});

	});


</script>