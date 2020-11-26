<div class="modal fade cetak-puskesmas_tpp_report_modal" id="cetakTPPReport" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">
					Cetak TPP Report Uptd Puskesmas
				</h4>
			</div>
			<div class="modal-body"> 
			<form method="post" target="_blank" action="tpp_report/cetak">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="tpp_report_id" class="tpp_report_id" >
				<input type="hidden" name="puskesmas_id" class="puskesmas_id" value="{{ $puskesmas_id }}">
				
					<div class="form-group">
						<label>Nama Puskesmas</label>
						<p class="label-perjanjian_kinerja">
							<span class="nama_puskesmas"></span>
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
			</div>
			<div class="modal-footer">
				<div class="form-group  div_cetak" >
					<button type="submit" class="btn btn-success btn-block cetak">Cetak <i class="fa fa-print"></i></button>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>







<script type="text/javascript">
	$('.cetak').on('click', function(){
		$('.cetak-puskesmas_tpp_report_modal').modal('hide'); 
	});


	$('.cetak-puskesmas_tpp_report_modal').on('shown.bs.modal', function(){
		var tpp_report_id = $('.tpp_report_id').val();
		var puskesmas_id = $('.puskesmas_id').val();
		
	});
	

</script>