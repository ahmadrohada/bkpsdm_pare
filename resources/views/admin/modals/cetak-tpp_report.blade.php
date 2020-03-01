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
				<input type="text" name="_token" value="{{ csrf_token() }}">
				<input type="text" name="tpp_report_id" class="tpp_report_id" >
				
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
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success btn-block cetak">Cetak <i class="fa fa-print"></i></button>
			</div>
		</form>
		</div>
	</div>
</div>







<script type="text/javascript">
	$('.cetak').on('click', function(){
		$('.cetak-tpp_report_modal').modal('hide'); 
	});
	

</script>